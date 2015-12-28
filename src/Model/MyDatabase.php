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

use MongoDB\Driver\Manager;
use MongoDB\Client;
use MongoDB\Database;

class MyDatabase
{
	var $manager;
	var $database;
	
	function __construct($dbName){
		$this->manager = new Manager("mongodb://localhost:27017");
		$this->database = new Database($this->manager,$dbName);
	}

	function getCollectionList(){
		$retour = [];
		$result = $this->database->listCollections();
		foreach ($result as $key => $value) {
			$retour[$key] = $value;
		}
		return $retour;
	}
}