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

	function index($myNamespace,$id=''){
		$document = new \stdClass();
		$data = ['myNamespace' => $myNamespace];
		if(!empty($id)){
			$data['doc'] = $this->Document->read($myNamespace,$id);
		}
		$this->view->set($data);
	}

	public function add($myNamespace){
		$this->view->displayLayout = false;
		$fView['myNamespace'] = $myNamespace;
		$fView['message'] = '';
		$fView['result'] = true;
		if($this->request->isPost()){
			try {
				$data = $this->request->getPost('json');
				$data = \MongoDB\BSON\toPHP(\MongoDB\BSON\fromJSON($data));
				$result = $this->Document->insert($myNamespace,$data);
				$data->_id = $result->getInsertedId();
			} catch (\Exception $e) {
				$fView['result'] = false;
				$fView['message'] = $e->getCode().':'.$e->getMessage();
			}
			$fView['data'] = $data;
			$fView['url'] = $this->request->url(['controller'=>'collection','action'=>'index','params'=>['myNamespace'=>$myNamespace]]);
			//reponse en json
			if($fView['result']){
				$this->FlashMessages->set("The Document has been create",['class' => 'success']);
			}
		}
		$this->view->set(['json'=>$fView]);
	}

	public function edit($myNamespace,$id){
		$this->view->displayLayout = false;
		$fView['myNamespace'] = $myNamespace;
		$fView['message'] = '';
		$fView['result'] = true;
		if($this->request->isPost()){
			try {
				$data = $this->request->getPost('json');
				$data = \MongoDB\BSON\toPHP(\MongoDB\BSON\fromJSON($data));
				$result = $this->Document->update($myNamespace,$data,$id);				
			} catch (\Exception $e) {
				$fView['result'] = false;
				$fView['message'] = $e->getCode().':'.$e->getMessage();				
			}
			$fView['data'] = $data;
			$fView['url'] = $this->request->url(['controller'=>'collection','action'=>'index','params'=>['myNamespace'=>$myNamespace]]);
			if($fView['result']){
				$this->FlashMessages->set("The Document has been updated",['class' => 'success']);
			}
		}
		$this->view->set(['json'=>$fView]);
	}

	public function delete($myNamespace,$id){
		$this->Document->delete($myNamespace,$id);
		$this->FlashMessages->set("The Document $id has been dropped",['class' => 'success']);
		$this->request->redirect(['controller'=>'collection','action'=>'index','params'=>['myNamespace'=>$myNamespace]]);
	}

}