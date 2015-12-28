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

class IndexCollection extends MasterCollection {

	var $manager;
	private $defaultQuery = ['query'=>[]];

	public function __construct($name){
		parent::__construct($name);
		$this->manager = new Manager("mongodb://localhost:27017");
	}

	public function getList($namespace){
		$collection = new Collection($this->manager,$namespace);
		return $collection->listIndexes();
	}

	public function createIndex($namespace,$index,$option = []){
		$collection = new Collection($this->manager,$namespace);
		debug($index);die();
		return $collection->createIndexs($index);
	}
}