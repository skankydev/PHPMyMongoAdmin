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

	function index($cName, $page = 1){
		$option = [
			'page'=>(int)$page,
		];
		$data = $this->Collection->getList($cName,$option);
		$data->setParams(['collection'=>$cName]);
		$this->view->set(['data'=>$data,'cName'=>$cName]);
	}

	public function view($_id = ''){

	}

	public function add($dbName){

	}

	public function edit(){

	}

	public function delete(){

	}
}