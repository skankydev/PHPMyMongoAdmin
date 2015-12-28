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
namespace PHPMyMongoAdmin\Model\Collection;

use PHPMyMongoAdmin\MasterCollection;
use PHPMyMongoAdmin\Config\Config;
use PHPMyMongoAdmin\Utilities\Paginator;

use MongoDB\Driver\Manager;
use MongoDB\Collection;

use stdClass;

class DocumentCollection extends MasterCollection {

	var $manager;
	private $defaultQuery = ['query'=>[]];

	public function __construct($name){
		parent::__construct($name);
		$this->manager = new Manager("mongodb://localhost:27017");
	}

	public function getList($collectionName,$option = []){
		$collection = new collection($this->manager,$collectionName);
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
		$collection = new collection($this->manager,$collectionName);
		return $collection->drop();
	}

}