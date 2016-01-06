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


class CollectionController extends MasterController {

	function index($namespace, $page = 1){
		$option = [
			'page'=>(int)$page,
		];
		$data = $this->Collection->getList($namespace,$option);
		$data->setParams(['collection'=>$namespace]);
		$this->view->set(['data'=>$data,'namespace'=>$namespace]);
	}

	public function import($namespace){
		if($this->request->isPost()){
			$files = $this->request->getFiles();
			$exe = explode('.', $files['import']['name']);
			$exe = end($exe);
			if($exe==='json'){
				$content = file_get_contents($files['import']['tmp_name']);
				$content = json_decode($content,true);
				$result = $this->Collection->insertMany($namespace,$content);
				$this->FlashMessages->set("Your file has been imported",['class' => 'success']);
				$this->request->redirect(['controller'=>'collection','action'=>'view','params'=>['namespace'=>$namespace]]);
			}else{
				$this->FlashMessages->set("your file must be in .json format",['class' => 'error']);
			}
		}
		$this->view->set(['namespace'=>$namespace]);
	}

	public function drop($namespace){
		if(!empty($namespace)){
			$result = $this->Collection->dropCollection($namespace);
			if($result->ok==1){
				$this->FlashMessages->set("The Collection $namespace has been dropped",['class' => 'success']);
			}else{
				$this->FlashMessages->set("An error occurred when dropping $namespace: $result->errmsg",['class' => 'error']);
			}
			$tmp = explode('.',$namespace);
			$this->request->redirect(['controller'=>'database','action'=>'view','params'=>['dbName'=>$tmp[0]]]);
		}
	}
}