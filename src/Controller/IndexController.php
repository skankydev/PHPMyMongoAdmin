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

	function index($namespace){
		$list = $this->Index->getList($namespace);
		$this->view->set(['list' => $list,'namespace'=>$namespace]);
	}

	public function add($namespace){
		if($this->request->isPost()){
			$fView['namespace'] = $namespace;
			$fView['message'] = '';
			$fView['result'] = true;
			$this->view->displayLayout = false;
			$data = $this->request->getPost('json');
			$data = json_decode($data,true);
			try {
				$result = $this->Index->createIndexes($namespace,$data);
			} catch (\Exception $e) {
				$fView['result'] = false;
				$fView['message'] = $e->getCode().':'.$e->getMessage();
			}
			$fView['url'] = $this->request->url(['controller'=>'index','action'=>'index','params'=>['namespace'=>$namespace]]);
			if($fView['result']){
				$this->FlashMessages->set("The Index has been create",['class' => 'success']);
			}
			echo json_encode($fView);die();
		}
		$this->view->set(['namespace'=>$namespace]);
	}

	public function edit($namespace){
		
	}
/*


try {
	$data = $this->request->getPost('json');
	$data = \MongoDB\BSON\toPHP(\MongoDB\BSON\fromJSON($data));
	$result = $this->Document->insert($namespace,$data);
	$data->_id = $result->getInsertedId();
} catch (Exception $e) {
	$fView['result'] = false;
	$fView['message'] = $e->message;
}
*/
	public function drop($namespace,$index){
		$this->Index->dropIndex($namespace,$index);
		$this->FlashMessages->set("The index $id has been dropped",['class' => 'success']);
		$this->request->redirect(['controller'=>'index','action'=>'index','params'=>['$namespace'=>$namespace]]);
	}

}