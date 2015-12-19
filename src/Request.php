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

use PHPMyMongoAdmin\Utilities\UserAgent;
use PHPMyMongoAdmin\Utilities\Session;
use PHPMyMongoAdmin\Utilities\Historique;
use PHPMyMongoAdmin\Config\Config;

class Request {

	public $uri;
	public $sheme;
	public $method;
	public $protocol;
	public $ip;
	

	public $namespace;
	public $controller;
	public $action;
	public $params = [];
	public $data = [];
	public $history;
	public $router;
	public $userAgent;
	public $swaped;

	public function __construct(){
		//debug($_SERVER);die();
		$this->swaped    = false;
		$this->host      = $_SERVER['HTTP_HOST'];
		$this->uri       = $_SERVER['REQUEST_URI'];
		$this->sheme     = $_SERVER['REQUEST_SCHEME'];
		$this->method    = $_SERVER['REQUEST_METHOD'];
		$this->protocol  = $_SERVER['SERVER_PROTOCOL'];
		$this->ip        = $_SERVER['REMOTE_ADDR'];
		$this->referer   = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:null;
		$this->userAgent = new UserAgent();
		$this->history = new Historique();

		if($this->isPost()){
			$this->data = $_POST;
		}
	}
	public function getParams($name = ''){
		if(empty($name)){
			return $this->params;
		}else{
			return $this->params[$name];
		}
	}
	/**
	 * insert the new url in session
	 * @return void
	 */
	public function updateHistory(){
		$this->history->updateHistorique($this);
	}
	/**
	 * get the request history
	 * @return array histories
	 */
	public function getHistories(){
		return ['histories'=>$this->history->getHistorique()];
	}

	/**
	 * redirect the request to a new link
	 * @param  array  $link a array description of the link
	 */
	public function redirect($link = []){
		$this->history->notDirect();
		//debug($this->history);
		$url ='';
		if(is_string($link)){
			$url = $this->url($this->router->getRouteByName($link));			
		}else{
			$url = $this->url($link);
		}
		header('Location: '.$url);
		exit();
	}

	/**
	 * check if the request is poste
	 * @return boolean true or false
	 */
	public function isPost(){
		return ($this->method === 'POST');
	}

	/**
	 * creat the url 
	 * @param  array  $link ['controller'=>'','action'=>'','params'=>['name'=>'value','name'=>'value'...]]
	 * @return string       the absolut url;
	 */
	public function url($link = [], $absolut = true){
		$url = '';
		if(!isset($link['controller'])){
			$link['controller'] = str_replace('Controller','',$this->controller);
		}
		if(!isset($link['action'])){
			$link['action'] = $this->action;
		}
		if($absolut){
			$url .= $this->sheme.'://'.$this->host;
		}
		$url .= '/'.strtolower($link['controller']).'/'.strtolower($link['action']);
		if(!empty($link['params'])){
			foreach ($link['params'] as $key => $params){
				$url .= '/'.$params;
			}
		}
		return $url;
	}

	/**
	 * swap request information to a new request
	 * a easy way for run a controller 
	 * load the new one in your controller 
	 * @param  array  $link the new direction if link is empty he get the last direct request
	 * @return void
	 */
	public function swap($link = []){
		/*--bullshit--*/
		if(empty($link)){
			$link = $this->history->getLastDirect();
		}
		$this->namespace = $link['link']['namespace'];
		$this->controller = $link['link']['controller'];
		$this->action = $link['link']['action'];
		$this->params = $link['link']['params'];
		$this->history->notDirect();
		$this->swaped = true;
	}

	/**
	 * get a link to the router
	 * @param Router $router the router object
	 */
	public function setRouter(Router &$router){
		$this->router = $router;
	}
}
