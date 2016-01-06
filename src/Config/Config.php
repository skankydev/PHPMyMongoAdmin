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

namespace PHPMyMongoAdmin\Config;
//include_once   APP_FOLDER.DS."PHPMyMongoAdmin".DS."Utilities".DS."Traits".DS."ArrayPathable.php"; 

use PHPMyMongoAdmin\Utilities\Traits\ArrayPathable;

const SECOND =  1;
const MINUTE =  60;
const HOUR   =  3600;
const DAY    =  86400;
const WEEK   =  604800;
const MONTH  =  2592000;
const YEAR   =  31536000;

/**
* app config 
*/
class Config {

	use ArrayPathable;

	static $conf;
	
	static function viewDir(){
		return APP_FOLDER.DS."src".DS.'Template'.DS.'view';
	}
	static function layoutDir(){
		return APP_FOLDER.DS."src".DS.'Template'.DS.'layout';
	}
	static function elementDir(){
		return APP_FOLDER.DS."src".DS.'Template'.DS.'element';
	}
	static function controllerDir(){
		return APP_FOLDER.DS."src".DS.'Controller';
	}
	static function getDbConf($dbSelec = 'default'){
		return self::arrayGet('db.'.$dbSelec,self::$conf);
	}

	static function getRoutes(){
		return self::arrayGet('routes',self::$conf);
	}

	static function getModuleList(){
		return self::arrayGet('Module',self::$conf);
	}

	static function getDefaultNamespace(){
		return self::arrayGet('default.namespace',self::$conf);
	}

	static function getDefaultAction(){
		return self::arrayGet('default.action',self::$conf);
	}
	
	static function getVersion(){
		return self::arrayGet('PHPMyMongoAdmin.version',self::$conf);
	}
	
	static function getDebug(){
		return self::arrayGet('debug',self::$conf);
	}
	static function get($path){
		return self::arrayGet($path,self::$conf);
	}

	static function getCurentNamespace(){
		return self::get('PHPMyMongoAdmin.curentNamespace');
	}

	static function setCurentNamespace($name){
		return self::set('PHPMyMongoAdmin.curentNamespace',$name);
	}

	static function set($path,$value){
		return self::arraySet($path,$value,self::$conf);
	}

	static function getConf(){
		if(empty(self::$conf)){
			$mConf = require APP_FOLDER.DS."config".DS."master.config.php";
			$tmpConf = [];
			$conf = array_replace_recursive($tmpConf,$mConf);
			$dConf = require DS.'default.config.php';
			self::$conf = array_replace_recursive($dConf,$conf);
		}

		return self::$conf;
	}

}
