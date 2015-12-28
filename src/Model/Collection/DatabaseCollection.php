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
use MongoDB\Driver\Manager;
use MongoDB\Client;
use MongoDB\Database;

use stdClass;

class DatabaseCollection extends MasterCollection {

	var $client;
	var $manager;
	var $database;

	function __construct($name){
		parent::__construct($name);
		$this->manager = new Manager("mongodb://localhost:27017");
		$this->client = new Client('mongodb://localhost:27017');
	}

	function getDBList(){
		$retour = [];
		$result = $this->client->listDatabases();
		return $result;
	}

	function getCollectionList($dbName){
		$database = new Database($this->manager,$dbName);
		$retour = [];
		$result = $database->listCollections();
		return $result;
	}

	function dropDatabase($dbName){
		$database = new Database($this->manager,$dbName);
		return $database->drop();
	}

	function createCollection($dbName,$cName,$option = []){
		$database = new Database($this->manager,$dbName);
		$result = $database->createCollection($cName,$option);//trow exception if not valide
		return true;
	}
}