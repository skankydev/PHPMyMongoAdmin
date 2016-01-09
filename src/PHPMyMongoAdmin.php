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

include_once APP_FOLDER.DS."src".DS."Config".DS."Config.php"; 
include_once APP_FOLDER.DS."src".DS."Utilities".DS."Debug.php"; 

use PHPMyMongoAdmin\Request;
use PHPMyMongoAdmin\Router;
use PHPMyMongoAdmin\MasterView;
use PHPMyMongoAdmin\MasterController;
use PHPMyMongoAdmin\Config\Config;
use PHPMyMongoAdmin\Utilities\Session;
use PHPMyMongoAdmin\Controller\ErrorController;

class PHPMyMongoAdmin {
	
	public $request;
	public $router;
	public $controller;

	public function __construct() {
		try {
			Session::start();
			Config::getConf();
			$this->request = Request::getInstance();
			$this->router = new Router($this->request);
			$this->request->setRouter($this->router);
			$this->controller = MasterController::load();
		} catch (\Exception $e) {
			$this->controller = new ErrorController($e);
			//c'est fait 
		}
	}
}
