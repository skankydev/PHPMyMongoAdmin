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


class IndexController extends MasterController {

	function index($myNamespace){
		$list = $this->Index->getList($myNamespace);
		$this->view->set(['list' => $list,'myNamespace'=>$myNamespace]);
	}

	public function add($myNamespace){
		if($this->request->isPost()){
			$fView['myNamespace'] = $myNamespace;
			$fView['message'] = '';
			$fView['result'] = true;
			$this->view->displayLayout = false;
			$data = $this->request->getPost('json');
			$data = json_decode($data,true);
			debug($myNamespace);
			debug($data);die();
			try {
				$result = $this->Index->createIndexes($myNamespace,$data);
			} catch (\Exception $e) {
				$fView['result'] = false;
				$fView['message'] = $e->getCode().':'.$e->getMessage();
			}
			$fView['url'] = $this->request->url(['controller'=>'index','action'=>'index','params'=>['myNamespace'=>$myNamespace]]);
			if($fView['result']){
				$this->FlashMessages->set("The index has been create",['class' => 'success']);
			}
			echo json_encode($fView);die();
		}
		$this->view->set(['myNamespace'=>$myNamespace]);
	}

	public function edit($myNamespace){
		
	}

	public function drop($myNamespace,$index){
		$this->Index->dropIndex($myNamespace,$index);
		$this->FlashMessages->set("The index $id has been dropped",['class' => 'success']);
		$this->request->redirect(['controller'=>'index','action'=>'index','params'=>['myNamespace'=>$myNamespace]]);
	}

}