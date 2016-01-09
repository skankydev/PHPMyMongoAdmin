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
namespace PHPMyMongoAdmin\Model;

use PHPMyMongoAdmin\MasterModel;
use PHPMyMongoAdmin\Config\Config;
use PHPMyMongoAdmin\Utilities\Paginator;

use MongoDB\Driver\Manager;
use MongoDB\Collection;

use stdClass;

class Collection extends MasterModel {

	var $manager;
	private $defaultQuery = ['query'=>[]];

	public function getList($collectionName,$option = []){
		$collection = new Collection($this->manager,$collectionName);
		$option = array_replace_recursive($this->defaultQuery,$option);
		$dOption = Config::get('paginator');
		$option = array_replace_recursive($dOption,$option);
		$option['skip'] = $option['limit']*($option['page']-1);
		$query = $option['query'];
		unset($option['query']);
		$option['count'] = $collection->count($query);
		$result = $collection->find($query,$option);
		$retour = [];
		foreach ($result as $data) {
			$retour[]=$data;
		}
		$paginator = new Paginator($retour);
		unset($option['skip']);
		$paginator->setOption($option);

		return $paginator;
		
	}

	public function dropCollection($collectionName){
		$collection = new Collection($this->manager,$collectionName);
		return $collection->drop();
	}

	public function insertMany($collectionName,$document){
		$collection = new Collection($this->manager,$collectionName);
		return $collection->insertMany($document);
	}

	public function aggregate($collectionName,$pipeline){
		$collection = new Collection($this->manager,$collectionName);
		$result = $collection->aggregate($pipeline);
		return $result;
	}
}