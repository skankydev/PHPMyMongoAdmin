<?php 
/**
 * Copyright (c) 2015 SCHENCK Simon
 * 
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) SCHENCK Simon
 * @since         0.0.1
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 *
 */
namespace PHPMyMongoAdmin\Collection;

use PHPMyMongoAdmin\MasterCollection;
use PHPMyMongoAdmin\Config\Config;
use PHPMyMongoAdmin\Utilities\Paginator;

use MongoDB\Driver\Manager;
use MongoDB\Collection;
use MongoDB\BSON\ObjectID;
use MongoDB\Driver\BulkWrite;

use stdClass;

class DocumentCollection extends MasterCollection {

	var $manager;
	private $defaultQuery = ['query'=>[]];

	public function read($namespace,$id){
		$result = [];
		$collection = new Collection($this->manager,$namespace);
		$id = new ObjectID($id);
		$result = $collection->findOne(['_id'=>$id]);
		return $result;
	}

	public function update($namespace,$data,$id){
		$result = [];
		$collection = new Collection($this->manager,$namespace);
		$id = new ObjectID($id);
		unset($data->_id);
		$bulk = new BulkWrite();
		$bulk->update(['_id'=>$id],$data);
		$this->manager->executeBulkWrite($namespace,$bulk);//delete unset value
		
		//$result = $collection->updateOne(['_id'=>$id],['$set'=>$data]);//keep unset value
		return $result;
	}

	public function insert($namespace,$data){
		$result = [];
		$collection = new Collection($this->manager,$namespace);
		$result = $collection->insertOne($data);
		
		return $result;
	}

	public function delete($namespace,$id){
		$result = [];
		$collection = new Collection($this->manager,$namespace);
		$id = new ObjectID($id);
		$result = $collection->findOneAndDelete(['_id'=>$id]);
		return $result;
	}

}