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
namespace PHPMyMongoAdmin;

use PHPMyMongoAdmin\Config\Config;
use PHPMyMongoAdmin\View\Helper\HtmlHelper;
use PHPMyMongoAdmin\View\Helper\FormHelper;
use PHPMyMongoAdmin\View\Helper\FlashMessagesHelper;
use PHPMyMongoAdmin\Utilities\Session;
/**
* 
*/
class MasterView {

	use HtmlHelper;

	protected $script = '';

	public $data = [];
	public $layout = 'default';
	public $displayLayout = true;
	public $helpers = ['Form','FlashMessages'];
	

	function __construct($request){
		$this->request = $request;
	}

	/**
	 * render the view
	 */
	public function render(){
		$this->loadHelper();
		$this->makePath();
		extract($this->data);
		ob_start();
		require($this->viewPath);
		$this->content = ob_get_clean();
		
		if($this->displayLayout){
			require ($this->layoutPath);
		}else{
			echo $this->content;
		}
	}
	/**
	 * render a element of view 
	 * @param string $element element name
	 * @param  array  $option  variable for view
	 * @return view element just say echo
	 */
	public function element($element,$option = []){
		$fileName = Config::elementDir().DS.$element.'.ctp';
		extract($option);
		ob_start();
		require($fileName);
		return ob_get_clean();
	}
	/**
	 * create the path/to/folder for diferante view
	 * @return void 
	 */
	public function makePath(){
		$this->layoutPath = Config::layoutDir().DS.$this->layout.'.ctp';
		if(!file_exists($this->layoutPath)){
			throw new \Exception("the layout file : {$this->layoutPath} does not exist", 601);
		}
		$viewFolder = strtolower(str_replace('Controller','',$this->request->controller));
		$this->viewPath = Config::viewDir().DS.$viewFolder.DS.$this->request->action.'.ctp';
		if(!file_exists($this->viewPath)){
			throw new \Exception("the view file : {$this->viewPath} does not exist", 601);
		}
	}


	/**
	 * pour afficher un element crée avant layout (la view du controller pour le momant) mais c pas fini 
	 * @param  string $name the name
	 * @return  view element just say echo
	 */
	public function fetch($var){
		echo $this->{$var};
	}

	public function set($key,$valeur=null){
		if(is_array($key)){
			$this->data += $key;
		}else{
			$this->data[$key] = $valeur;
		}
	}

	public function setHelper($key,$valeur=null){
		if(is_array($key)){
			$this->helpers += $key;
		}else{
			$this->helpers[$key] = $valeur;
		}
	}

	/**
	 * TODO tu a rien foutu mec fo retravailler ca !
	 */
	static function load(Request $request,$name = 'PHPMyMongoAdmin\MasterView'){
		/*$fileName = Config::controllerDIR().DS.$request->controller.'.php';
		if(!file_exists($fileName)){
			throw new \Exception("Controller {$request->controller} does not exist", 101);
		}
		require $fileName;
		$name = $request->namespace.'\\Controller\\'.$request->controller;*/
		return new MasterView($request);
	}
	
	public function loadHelper(){
		
		if(!isset($this->Form)){
			$this->Form = new FormHelper($this->request->data);
		}

		if(!isset($this->FlashMessages)){
			$this->FlashMessages = new FlashMessagesHelper($this->request->data);
		}
	}
	
	/**
	 * start the buffuring view for script in end of the page
	 * @return void
	 */
	public function startScript(){
		ob_start();
	}
	
	/**
	 * stop the buffuring for script
	 * @return void
	 */
	public function stopScript(){
		$this->script .= ob_get_clean();
	}

	/**
	 * get the script 
	 * @return string the script
	 */
	public function getScript(){
		$retour = $this->script;
		/*if($this->request->swaped){
			$retour .= $this->surround("history.pushState({ path: this.path }, '', '{$this->request->url()}');",'script');
		}*/
		return $retour;
	}

}