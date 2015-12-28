<?php 
/**
 * Copyright (c) 2015 SCHENCK Simon
 * 
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) SCHENCK Simon
 * @since         0.0.1
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 *
 */
namespace PHPMyMongoAdmin\View\Helper;

use PHPMyMongoAdmin\View\Helper\MasterHelper;
use PHPMyMongoAdmin\View\Helper\Htmlhelper;
use PHPMyMongoAdmin\Config\Config;
/**
* 
*/
class FormHelper extends MasterHelper {

	use HtmlHelper;

	private $data;
	private $dClass;
	private $formAttr = ['accept-charset'=>"UTF-8"];
	private $submitBtn = false;

	/**
	 * create the form object 
	 * @param array $data the data to put in input
	 */
	function __construct($data = array()){
		$this->data = $data;
		$this->dClass = Config::get('form.class');
	}

	/**
	 * check if i have value for input
	 * @param  string $name the name of the value
	 * @return mixed        the value
	 */
	private function checkValue($name){
		return (isset($this->data->{$name})?$this->data->{$name}:null);
	}

	/**
	 * check if a checkbox is checked
	 * @param  string $name  the name of the checkbox
	 * @param  string $value the value of the checkbox
	 * @return string        checked or null
	 */
	private function checkChecked($name,$value=''){
		$retour = '';
		$name = str_replace('[]', '', $name);
		if(!empty($this->data->{$name})){
			if(is_array($this->data->{$name})){
				$retour = in_array($value, $this->data->{$name})?'checked':'';
			}else{
				$retour = isset($this->data->{$name})?'checked':'';
			}
		}
		return $retour;
	}

	/**
	 * check the selected value for a select
	 * @param  string $name  the name of the select
	 * @param  string $value the value of the select
	 * @return string        selected or null
	 */
	private function checkSelected($name,$value=''){
		$retour = '';
		if(isset($this->data->{$name})){
			if(is_array($this->data->{$name})){
				$retour = in_array($value, $this->data->{$name})?'selected':'';
			}else{
				if (isset($this->data->{$name})) {
					$retour = $this->data->{$name}===$value?'selected':'';
				}
			}
		}
		return $retour;
	}

	/**
	 * create the form balise
	 * @param  string $action the url for valide form
	 * @param  array  $attr   the attribute
	 * @param  string $method the method of form (default POST)
	 * @return string         the balise form
	 */
	public function start($action,$attr = [],$method='POST'){
		$retour = '<form action="'.$action.'" ';
		$attr =  array_merge($this->formAttr,$attr);
		$retour .= $this->createAttr($attr);
		$retour .= 'method="'.$method.'">';
		return $retour;
	}

	/**
	 * close the form add the submit button if not exsiste
	 * @return string the html
	 */
	public function end(){
		$retour = '';
		if(!$this->submitBtn){
			$retour .= $this->submit('Send');
		}
		$retour .= '</form>';
		return $retour;
	}

	/**
	 * create a fildset 
	 * @param  array  $option the list of option for the fieldset 
	 * @example [
	 *      'fieldset'=> list of attr for balise fieldset ,
	 *		'legend'  => if is set create the legende balise,
	 *		'input'   => the list of input in the fieldset balise,
	 *		]
	 * @return string        the html 
	 */
	public function fieldset($option = array()){
		$fAttr = [];
		if(isset($option['fieldset'])){
			$fAttr = $option['fieldset'];
		}
		$retour = '';
		if(isset($option['legend'])){
			$content = $option['legend']['content'];
			$attr = $option['legend'];
			unset($attr['content']);
			$retour .= $this->legend($content,$attr);
		}

		$methods = get_class_methods($this);
		
		foreach ($option['input'] as $key => $value) {
			$message = '';
			$contentDiv = '';
			if(!isset($value['type'])){
				$value['type'] = 'text';
			}
			$class = $value['type'];
			if(isset($value['multiple'])&&($value['multiple']==='checkbox')){
				$class .= ' checkbox';
			}
			if(isset($this->data->messageValidate[$key])){
				$class .= ' not-valid';
				$message = '<span class="valid-message">'.$this->data->messageValidate[$key].'</span>';
			}
			//$retour .= '<div class="input '.$class.'">';
			$label = '';
			if(isset($value['label'])){
				$lAttr = ['for'=>$key];
				if(isset($value['labelAttr'])){
					$lAttr = array_merge($lAttr,$value['labelAttr']);
					unset($value['labelAttr']);
				}
				$label .= $this->label($value['label'],$lAttr);
				unset($value['label']);
			}
			$input ='';
			if(in_array($value['type'],$methods)){
				$name = $value['type'];
				$input .= $this->{$name}($key,$value);
			}else{
				$input .= $this->input($key,$value);
			}
			$contentDiv .= ($value['type']==='checkbox')? $input.$label:$label.$input;
			$contentDiv .= $message;

			$retour .= $this->surround($contentDiv,'div',['class'=>$class]);

		}
		$retour = $this->surround($retour,'fieldset',$fAttr);
		return $retour;
	}

	/**
	 * create the legend balise
	 * @param  string $content the content of the balise
	 * @param  array  $attr    the attribute for the balise
	 * @return string          the html
	 */
	public function legend($content,$attr = []){
		$retour = '<legend ';
		$retour .= $this->createAttr($attr);
		$retour .= '>'.$content.'</legend>';
		return $retour;
	}
	
	/**
	 * create the label balise
	 * @param  string $content the content of the balise
	 * @param  array  $attr    the attribute
	 * @return string          the html
	 */
	public function label($content, $attr = []){
		$retour = $this->surround($content,'label',$attr);
		return $retour;
	}
	
	/**
	 * create input balise
	 * @param  string $name the name
	 * @param  array  $attr the attribute
	 * @return string       the html
	 */
	public function input($name,$attr = []){
		if(!isset($attr['type'])){
			$attr['type'] = 'text';
		}
		if(!isset($attr['value'])){
			$attr['value'] = $this->checkValue($name);
		}
		if(!isset($attr['name'])){
			$attr['name'] = $name;
		}
		if(!isset($attr['id'])){
			$attr['id'] = $name;
		}
		$this->addDefaultClass('input',$attr);
		$retour = '<input '.$this->createAttr($attr).' >';
		return $retour;
	}

	/**
	 * create select form
	 * @param  string  $name     the name
	 * @param  array   $attr     the attribute
	 * @param  string  $multiple type of multiple selection
	 * @return string            the html
	 */
	public function select($name,$attr = []){
		$retour ='';
		$multiple = isset($attr['multiple'])?$attr['multiple']:false;
		if($multiple==='checkbox'){
			$retour .= $this->multipleCheckbox($name,$attr);
		}else{
			$option = $attr['option'];
			unset($attr['option']);
			unset($attr['type']);
			//var_dump($attr);
			$multiple = $multiple?'multiple':'';
			$sName = $multiple?$name.'[]':$name;
			$retour .= '<select id="'.$name.'" name="'.$sName.'"';
			$retour .= $this->createAttr($attr);
			$retour .= $multiple.'>';
			foreach ($option as $key => $value) {
				$val = $value;
				if(is_string($key)){
					$val = $key;
				}
				$retour .= '<option value="'.$val.'" '.$this->checkSelected($name,$val).'>';
				$retour .= $value;
				$retour .= '</option>';
			}
			$retour .= '</select>';
		}
		return $retour;
	}

	/**
	 * create checkbox 
	 * @param  string $name the name
	 * @param  array  $attr the attribute
	 * @param  string $value the checkbox value
	 * @return string        the html
	 */
	public function checkbox($name,$attr = [],$value=''){
		if (empty($value)) {
			$value = $name;
		}
		$retour ='<input id="'.$value.'" type="checkbox" name="'.$name.'" value="'.$value.'"';
		$retour .= $this->checkChecked($name,$value).' ';
		$retour .= $this->createAttr($attr).' />';
		return $retour;
	}

	/**
	 * create multiple checkbox 
	 * @param  string $name the name
	 * @param  array  $attr the attribute
	 * @return string       the html
	 */
	public function multipleCheckbox($name,$attr = []){
		$option = $attr['option'];
		unset($attr['option']);
		$myAttr = [];
		if(isset($attr['attr'])){
			$myAttr = $attr['attr'];
		}
		$retour = '';
		foreach ($option as $key => $value) {
			$tmp = $this->checkbox($name.'[]',$myAttr,$value);
			$tmp .= $this->label(is_string($key)?$key:$value,['for'=>$value]);
			$retour .= $this->surround($tmp,'div',['class'=>'checkbox-multiple'],false);
		}
		return $retour;
	}

	/**
	 * create textarea
	 * @param  string $name the name
	 * @param  array  $attr the attributr
	 * @return string       the html
	 */
	public function textarea($name,$attr = []){
		unset($attr['type']);
		if(!isset($attr['name'])){
			$attr['name'] = $name;
		}
		if(!isset($attr['id'])){
			$attr['id'] = $name;
		}
		$retour = $this->surround($this->checkValue($name),'textarea',$attr);
		return $retour;
	}

	/**
	 * create submit button
	 * @param  string $content the content
	 * @param  array  $attr    the attribute
	 * @return string          the html
	 */
	public function submit($content, $attr = []){
		$this->submitBtn = true;
		$attr['type'] = 'submit';
		$retour = $this->surround($content,'button',$attr);
		return $this->surround($retour,'div',['class'=>'submit'],false);
	}
}
