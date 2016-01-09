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

	private static $_instance = null;

	public $uri;
	public $sheme;
	public $method;
	public $protocol;
	public $ip;
	

	public $namespace;
	public $controller;
	public $action;
	public $params = [];
	public $data;
	public $history;
	public $router;
	public $userAgent;

	public static function getInstance() {
		if(is_null(self::$_instance)) {
			self::$_instance = new Request();  
		}
		return self::$_instance;
	}
	public function __construct(){
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
			$this->data = (object)$_POST;
		}
	}
	/**
	 * get value form $_POST
	 * @param  string $name value
	 * @return mixed       $_POST | $_POST[$value]
	 */
	public function getPost($name = ''){
		if($this->isPost()){
			if(empty($name)){
				return $_POST;
			}else{
				return $_POST[$name];
			}
		}
		return false;
	}
	/**
	 * get $_FILES
	 * @return array $_FILES
	 */
	public function getFiles(){
		if(empty($_FILES)){
			return false;
		}
		return $_FILES;
	}
	/**
	 * ca viendra un jour
	 * @param  string $name [description]
	 * @return [type]       [description]
	 */
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
		//$this->history->notDirect();
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
	 * get a link to the router
	 * @param Router $router the router object
	 */
	public function setRouter(Router &$router){
		$this->router = $router;
	}
}
