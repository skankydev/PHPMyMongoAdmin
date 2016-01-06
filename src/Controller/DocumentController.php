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


class DocumentController extends MasterController {

	function index($namespace,$id=''){
		$document = new \stdClass();
		$data = ['namespace' => $namespace];
		if(!empty($id)){
			$data['doc'] = $this->Document->read($namespace,$id);
		}
		$this->view->set($data);
	}

	public function add($namespace){
		$this->view->displayLayout = false;
		$fView['namespace'] = $namespace;
		$fView['message'] = '';
		$fView['result'] = true;
		if($this->request->isPost()){
			try {
				$data = $this->request->getPost('json');
				$data = \MongoDB\BSON\toPHP(\MongoDB\BSON\fromJSON($data));
				$result = $this->Document->insert($namespace,$data);
				$data->_id = $result->getInsertedId();
			} catch (\Exception $e) {
				$fView['result'] = false;
				$fView['message'] = $e->getCode().':'.$e->getMessage();
			}
			$fView['data'] = $data;
			$fView['url'] = $this->request->url(['controller'=>'collection','action'=>'index','params'=>['namespace'=>$namespace]]);
			//reponse en json
			if($fView['result']){
				$this->FlashMessages->set("The Document has been create",['class' => 'success']);
			}
		}
		$this->view->set(['json'=>$fView]);
	}

	public function edit($namespace,$id){
		$this->view->displayLayout = false;
		$fView['namespace'] = $namespace;
		$fView['message'] = '';
		$fView['result'] = true;
		if($this->request->isPost()){
			try {
				$data = $this->request->getPost('json');
				$data = \MongoDB\BSON\toPHP(\MongoDB\BSON\fromJSON($data));
				$result = $this->Document->update($namespace,$data,$id);				
			} catch (\Exception $e) {
				$fView['result'] = false;
				$fView['message'] = $e->getCode().':'.$e->getMessage();				
			}
			$fView['data'] = $data;
			$fView['url'] = $this->request->url(['controller'=>'collection','action'=>'index','params'=>['namespace'=>$namespace]]);
			if($fView['result']){
				$this->FlashMessages->set("The Document has been updated",['class' => 'success']);
			}
		}
		$this->view->set(['json'=>$fView]);
	}

	public function delete($namespace,$id){
		$this->Document->delete($namespace,$id);
		$this->FlashMessages->set("The Document $id has been dropped",['class' => 'success']);
		$this->request->redirect(['controller'=>'collection','action'=>'index','params'=>['namespace'=>$namespace]]);
	}

}