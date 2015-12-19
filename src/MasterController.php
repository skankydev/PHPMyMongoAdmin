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
use PHPMyMongoAdmin\MasterView;
use PHPMyMongoAdmin\MasterCollection;
use PHPMyMongoAdmin\Controller\Tools\FlashMessagesTool;

/**
* 
*/
class MasterController {

	public $request;
	public $viewModel = 'MasterView';
	private $tools = [
		'FlashMessages',
	];
	
	/**
	 * construct
	 * @param Request $request the request
	 */
	public function __construct(Request &$request){
		$this->request = $request;
		
		$name = explode('\\',get_class($this));
		$collectionName = str_replace('Controller','',$name[2]);

		$cName = $name[0].'\\Model\\Collection\\'.$collectionName.'Collection';

		$this->{$collectionName} = MasterCollection::load($cName);
		$this->view = MasterView::load($request,$this->viewModel);
		$this->loadTools();
		$this->execute();
	}

	/**
	 * creat tools for controller
	 * @return void
	 */
	protected function loadTools(){
		if(!isset($this->FlashMessages)){
			$this->FlashMessages = new FlashMessagesTool();
		}
	}

	/**
	 * execute action from the request
	 */
	public function execute(){
		if(!method_exists($this,$this->request->action)){
			throw new \Exception("the method {$this->request->action} does not exist", 102);
		}
		call_user_func_array([$this,$this->request->action],$this->request->params);
		$this->view->render();
	}

	/**
	 * load a Controller 
	 * @param  Request $request the client request
	 * @return mixed        a Controller
	 */
	static function load(Request &$request){
		$name = $request->namespace.'\\Controller\\'.$request->controller;
		return new $name($request);
	}

}