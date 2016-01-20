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
use PHPMyMongoAdmin\Utilities\Session;


class CollectionController extends MasterController {

	function index($myNamespace, $page = 1){
		$option = [
			'page'=>(int)$page,
		];
		$data = $this->Collection->getList($myNamespace,$option);
		$data->setParams(['collection'=>$myNamespace]);
		$this->view->set(['data'=>$data,'myNamespace'=>$myNamespace]);
	}

	public function import($myNamespace){
		if($this->request->isPost()){
			$files = $this->request->getFiles();
			$exe = explode('.', $files['import']['name']);
			$exe = end($exe);
			if($exe==='json'){
				$content = file_get_contents($files['import']['tmp_name']);
				$content = json_decode($content,true);
				$result = $this->Collection->insertMany($myNamespace,$content);
				$this->FlashMessages->set("Your file has been imported",['class' => 'success']);
				$this->request->redirect(['controller'=>'collection','action'=>'index','params'=>['myNamespace'=>$myNamespace]]);
			}else{
				$this->FlashMessages->set("your file must be in .json format",['class' => 'error']);
			}
		}
		$this->view->set(['myNamespace'=>$myNamespace]);
	}

	public function drop($myNamespace){
		if(!empty($myNamespace)){
			$result = $this->Collection->dropCollection($myNamespace);
			if($result->ok==1){
				$this->FlashMessages->set("The Collection $myNamespace has been dropped",['class' => 'success']);
			}else{
				$this->FlashMessages->set("An error occurred when dropping $myNamespace: $result->errmsg",['class' => 'error']);
			}
			$tmp = explode('.',$myNamespace);
			$this->request->redirect(['controller'=>'database','action'=>'view','params'=>['dbName'=>$tmp[0]]]);
		}
	}

	public function aggregate($myNamespace){
		if ($this->request->isPost()) {
			$data = $this->request->getPost('json');
			$data = json_decode($data,true);
			//$data = \MongoDB\BSON\toPHP(\MongoDB\BSON\fromJSON($data));//error with external $oid
			Session::set('pipeline',$data);
			$retour['result'] = true;
			$retour['url'] = $this->request->url(['action'=>'run','params'=>['myNamespace'=>$myNamespace]]);
			echo json_encode($retour);die();
		}
		$pipeline = Session::get('pipeline');
		if($pipeline){
			$fV['pipeline']  = $pipeline;
		}
		$fV['myNamespace'] = $myNamespace;
		$this->view->set($fV);
	}

	public function run($myNamespace){
		$pipeline = Session::get('pipeline');
		if(!$pipeline){
			$this->request->redirect(['action'=>'aggregate','params'=>['myNamespace'=>$myNamespace]]);
		}
		$result = $this->Collection->aggregate($myNamespace,$pipeline);
		$fV['myNamespace'] = $myNamespace;
		$fV['pipeline']  = $pipeline;
		$fV['cursor']    = $result;
		$this->view->set($fV);
	}

	public function query($myNamespace){
		if ($this->request->isPost()) {
			$data = $this->request->getPost('json');
			$data = json_decode($data,true);
			if(!isset($data['filter'])){$data['filter']=[];}
			if(!isset($data['options'])){$data['options']=[];}
			Session::set('query',$data);
			$retour['result'] = true;
			$retour['url'] = $this->request->url(['action'=>'queryexec','params'=>['myNamespace'=>$myNamespace]]);
			echo json_encode($retour);die();
		}
		$query = Session::get('query');
		if($query){
			$fV['query']  = $query;
		}
		$fV['myNamespace'] = $myNamespace;
		$this->view->set($fV);	
	}

	public function queryexec($myNamespace, $page = 1){
		$query = Session::get('query');
		if(!$query){
			$this->request->redirect(['action'=>'query','params'=>['myNamespace'=>$myNamespace]]);
		}
		$query['options']['page'] = (int)$page;
		$result = $this->Collection->find($myNamespace,$query);
		unset($query['options']['page']);
		$result->setParams(['collection'=>$myNamespace]);
		$fV['myNamespace'] = $myNamespace;
		$fV['cursor']    = $result;
		$fV['query']     = $query;
		$this->view->set($fV);
	}
}
