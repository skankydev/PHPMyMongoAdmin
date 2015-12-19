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
namespace PHPMyMongoAdmin\Utilities\Traits;

/**
 * this trait is a simple way to use a path like this 'foo.bar' for travel a array like this $array['foo']['bar']
 */
trait ArrayPathable {

	static $myArrayPathable; //juste in case pointer is not set

	/**
	 * get value in array 
	 * @param  string $path the path to the data separated by dot
	 * @return mixed        the value
	 */
	static function arrayGet($path,&$pointer){
		if(strlen($path)==0){
			return $pointer;
		}
		$path = explode('.',$path);
		$retour = $pointer;
		foreach ($path as $key) {
			if(isset($retour[$key])){
				$retour = $retour[$key];
			}else{
				return false;
			}
		}
		return $retour;
	}

	/**
	 * set value in a array path
	 * @param string  $path     the path to the data separated by dot
	 * @param mixed   $value    the value
	 * @param pointer &$pointer the array we need to read
	 * @return  void
	 */
	static function arraySet($path,$value,&$pointer = 'stepOne'){
		$aPath = explode('.',$path);
		if($pointer==='stepOne'){
			$pointer = &self::$myArrayPathable;
		}
		if(count($aPath)>1){
			$path = strstr($path,'.');
			$path = substr($path,-strlen($path)+1);
			if( !isset($pointer[$aPath[0]]) || !is_array($pointer[$aPath[0]])){
				$pointer[$aPath[0]] = [];
			}
			return self::arraySet($path,$value,$pointer[$aPath[0]]);
		}else{
			$pointer[$aPath[0]] = $value;
		}
		return true;
	}

	/**
	 * delete value in array path
	 * @param  string  $path     the path to the data separated by dot
	 * @param  pointer &$pointer the array where we need to delete a data
	 * @return void
	 */
	static function arrayDelete($path,&$pointer = 'stepOne'){
		$aPath = explode('.',$path);
		if($pointer==='stepOne'){
			$pointer = &self::$myArrayPathable;
		}
		if(count($aPath)>1){
			$path = strstr($path,'.');
			$path = substr($path,-strlen($path)+1);
			if( !isset($pointer[$aPath[0]])){
				return null;
			}
			return self::arrayDelete($path,$pointer[$aPath[0]]);
		}else{
			unset($pointer[$aPath[0]]);
		}
		return true;
	}

}