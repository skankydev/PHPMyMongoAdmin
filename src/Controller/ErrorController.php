<?php 

/**
 * Copyright (c) 2015 SCHENCK Simon
 * 
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) SCHENCK Simon
 * @since         0.0.2
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 *
 */
namespace PHPMyMongoAdmin\Controller;

use PHPMyMongoAdmin\MasterController;
use PHPMyMongoAdmin\Request;
use PHPMyMongoAdmin\MasterView;
use PHPMyMongoAdmin\Config\Config;
use Exception;

class ErrorController extends MasterController{

	public $request;
	/**
	 * construct
	 * @param Exception $exception the exception
	 */
	public function __construct($exception){
		$this->request = Request::getInstance();
		$save['controller'] =  $this->request->controller;
		$this->request->controller = 'ErrorController';
		$save['action'] =  $this->request->action;
		if(Config::getDebug()){
			$this->request->action = 'error';
		}else{
			$this->request->action = 'error404';
		}
		$this->request->params = ['error'=>$exception];
		$this->view = new MasterView();
		$this->view->set($save);
		$this->view->layout = 'error';
		$this->loadTools();
		$this->execute();
	}

	public function error(Exception $error){
		$fv['error'] = $error;
		$fv['class'] = get_class($error);
		$fv['traces'] = $error->getTrace();
		if($error instanceof \MongoDB\Driver\Exception\RuntimeException){
			$data = [];
			switch ($fv['class']) {
				case 'MongoDB\Driver\Exception\BulkWriteException':
					$data = [];
					$result = $error->getWriteResult();
					$data['error'] = $result->getWriteConcernError();
					$data['Inserted'] = $result->getInsertedCount();
					$data['Deleted'] = $result->getDeletedCount();
					$data['Modified'] = $result->getModifiedCount();
					$data['Upserted'] = $result->getUpsertedCount();
					$fv['info'] = $data;
				break;
				
				default:
				break;
			}
			
		}
		$this->view->set($fv);
	}
	public function error404(Exception $error){

	}

}