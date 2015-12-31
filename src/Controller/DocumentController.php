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
		if($this->request->isPost()){
			$data = $this->request->getPost('json');
			$data = json_decode($data);
			$result = $this->Document->insert($namespace,$data);
			$id = $result->getInsertedId();
			//reponse en json
			//$this->FlashMessages->set("The Document has been create",['class' => 'success']);
			//$this->request->url(['controller'=>'collection','action'=>'index','params'=>['namespace'=>$namespace]]);
		}
	}

	public function edit($namespace,$id){
		if($this->request->isPost()){
			$data = $this->request->getPost('json');
			$data = json_decode($data);
			$result = $this->Document->update($namespace,$data,$id);
		}
	}

	public function delete(){
		//findOneAndDelete( array|object $filter, array $options = [] )
	}

}