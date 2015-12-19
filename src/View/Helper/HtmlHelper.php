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

/**
* 
*/
trait HtmlHelper {
	
	/**
	 * creat the html <a> balise
	 * @param  string $content the content of the a balise
	 * @param  array  $link    the link see url for mor info
	 * @param  array  $attr    the attribute of <a> balise
	 * @return string          the <a> balise
	 */
	public function link($content,$link = [],$attr=[]){
		$attr['href'] = $this->request->url($link);
		$retour = $this->surround($content,'a',$attr);
		return $retour;
	}

	/**
	 * creat the html attribute 
	 * @param  array  $attr list of attribute 
	 * @return string       the attribute
	 */
	public function createAttr($attr = []){
		$retour = '';
		if(isset($attr) && !empty($attr)){
			foreach ($attr as $key => $value) {
				$retour.= $key .'="'.$value.'" ';
			}
		}
		return $retour;
	}

	/**
	 * surround html tag
	 * @param  string $content the content text
	 * @param  string $tag     tag html
	 * @param  array  $attr    list of attribute 
	 * @return string          the html
	 */
	public function surround($content,$tag,$attr = [],$default = true){
		$this->addDefaultClass($tag,$attr,$default);
		$retour = '<'.$tag.' '.$this->createAttr($attr).'>';
		$retour .=  $content.'</'.$tag.'>';
		return $retour;
	}

	/**
	 * add default class 
	 * @param strin $tag   tag html
	 * @param array &$attr the attribut
	 */
	private function addDefaultClass($tag,&$attr,$default = true){
		if(isset($this->dClass[$tag])&&$default){
			$s = ' ';
			if(!isset($attr['class'])){
				$attr['class'] = '';
				$s = '';
			}
			$attr['class'] = $this->dClass[$tag].$s.$attr['class'];
		}
	}

}