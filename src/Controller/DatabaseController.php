<?php 
/**
 * Copyright (c) 2015 SCHENCK Simon
 * 
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) SCHENCK Simon
 * @since         0.0.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 *
 */
namespace PHPMyMongoAdmin\Controller;

use PHPMyMongoAdmin\MasterController;


class DatabaseController extends MasterController {

	function index(){
		$dbList = $this->Database->getDBList();
		$this->view->set(['dbList' => $dbList]);
	}

	public function view($dbName = ''){
		$collectionList = $this->Database->getCollectionList($dbName);
		$this->view->set(['dbName' => $dbName,'collectionList'=>$collectionList]);
	}

	public function add($dbName = ''){
		$data = [];
		if($this->request->isPost()){
			$data = (object)$this->request->data;
			$option = [];
			$option['autoIndexId'] = isset($data->autoIndexId);
			if(isset($data->capped)){
				$option['capped'] = true;
				$option['size'] = (int)$data->size;
				if(!empty($data->max)){
					$option['max'] = (int)$data->max;
				}
			}
			if($this->Database->createCollection($data->database,$data->collection,$option)){
				$this->FlashMessages->set("The Collection $data->collection has been create",['class' => 'success']);
				$this->request->redirect(['controller'=>'database','action'=>'view','params'=>['dbName'=>$data->database]]);
			}
			$this->request->data = $data;
		}
		$this->view->set(['data'=>$data,'dbName'=>$dbName]);
	}

	public function drop($dbName = ''){
		if(!empty($dbName)){
			$result = $this->Database->dropDatabase($dbName);
			if(isset($result->dropped)){
				$this->FlashMessages->set("The Database $dbName has been dropped",['class' => 'success']);
			}else{
				$this->FlashMessages->set("An error occurred when dropping $dbName",['class' => 'error']);
			}
			$this->request->redirect('/');
		}
	}
}