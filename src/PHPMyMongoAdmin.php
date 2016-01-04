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
use PHPMyMongoAdmin\MasterController;
use PHPMyMongoAdmin\MasterView;
use PHPMyMongoAdmin\Config\Config;
use PHPMyMongoAdmin\Utilities\Session;

class PHPMyMongoAdmin {
	
	public $request;
	public $router;
	public $controller;

	public function __construct() {
		try {
			Session::start();
			Config::getConf();
			$this->request = new Request();
			$this->router = new Router($this->request);
			$this->request->setRouter($this->router);
			$this->request->updateHistory();
			$this->controller = MasterController::load($this->request);
		} catch (\Exception $e) {
			var_dump($e->getCode().' : '.$e->getMessage());
			var_dump($e);
			//echo $e->xdebug_message;
			//TO DO fair des view pour les erreur
		}
	}
}
