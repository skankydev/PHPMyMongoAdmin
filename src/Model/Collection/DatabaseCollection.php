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

use stdClass;

class DatabaseCollection extends MasterCollection {

	var $client;

	function __construct($name){
		parent::__construct($name);
		$this->client = new Client('mongodb://localhost:27017');
	}

	function getDBList(){
		$retour = [];
		$result = $this->client->listDatabases();
		foreach ($result as $key => $value) {
			$retour[$key]['name'] = $value->getName();
			$retour[$key]['size'] = $this->bytesToSize($value->getSizeOnDisk());
			$retour[$key]['empty'] = $value->isEmpty();
		}
		return $retour;
	}

	//TODO je doit caser ca dans un helper!
	function bytesToSize($bytes, $precision = 2){  
		$kilobyte = 1024;
		$megabyte = $kilobyte * 1024;
		$gigabyte = $megabyte * 1024;
		$terabyte = $gigabyte * 1024;

		if (($bytes >= 0) && ($bytes < $kilobyte)) {
			return $bytes . ' B';
		} elseif (($bytes >= $kilobyte) && ($bytes < $megabyte)) {
			return round($bytes / $kilobyte, $precision) . ' KB';
		} elseif (($bytes >= $megabyte) && ($bytes < $gigabyte)) {
			return round($bytes / $megabyte, $precision) . ' MB';
		} elseif (($bytes >= $gigabyte) && ($bytes < $terabyte)) {
			return round($bytes / $gigabyte, $precision) . ' GB';
		} elseif ($bytes >= $terabyte) {
			return round($bytes / $terabyte, $precision) . ' TB';
		} else {
			return $bytes . ' B';
		}
	}
}