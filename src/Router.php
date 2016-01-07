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

class Router
{
	private $routes = [];

	/**
	 * translates information of the request for application
	 * @param Request &$request the request
	 */
	function __construct(Request &$request) {

		$this->routes = Config::getRoutes();
		$params = [];
		$uri = $request->uri;
		if(array_key_exists($uri, $this->routes)){
			$request->namespace  = $this->routes[$uri]['options']['namespace'];
			$request->controller = ucfirst($this->routes[$uri]['options']['controller']).'Controller';
			$request->action     = $this->routes[$uri]['options']['action'];
			if(isset($this->routes[$uri]['params'])){
				$request->params     = $this->routes[$uri]['params'];
			}
		}else{
			$uri = substr($request->uri, 1);
			$tmp = explode('/', $uri);
			$request->namespace  = Config::getDefaultNamespace();
			$request->controller = ucfirst($tmp[0]).'Controller';
			$request->action     = isset($tmp[1]) ? $tmp[1] : Config::getDefaultAction();

			if(isset($tmp[2])&&!empty($tmp[2])){
				$request->params = array_slice($tmp,2);
			}
		}
	}

	/**
	 * return route by name
	 * @param  string $name the name
	 * @return array        the $link
	 */
	function getRouteByName($name){
		$retour = false;
		if(array_key_exists($name, $this->routes)){
			$retour = $this->routes[$name]['options'];
		}
		return $retour;
	}
}