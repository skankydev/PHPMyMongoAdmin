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

class Index extends MasterModel {

	var $manager;
	private $defaultQuery = ['query'=>[]];

	public function getList($myNamespace){
		$collection = new Collection($this->manager,$myNamespace);
		return $collection->listIndexes();
	}

	public function createIndexes($myNamespace,$index){
		$collection = new Collection($this->manager,$myNamespace);
		return $collection->createIndexes($index);
	}

	public function dropIndex($myNamespace,$index){
		$collection = new Collection($this->manager,$myNamespace);
		return $collection->dropIndex($index);
	}
}