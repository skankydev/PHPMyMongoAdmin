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
namespace PHPMyMongoAdmin;

use PHPMyMongoAdmin\Config\Config;

use MongoDB\Driver\Manager;
use MongoDB\Driver\BulkWrite;

use MongoDB\BSON\ObjectID;

use MongoDB\Collection;
use MongoDB\Client;
use MongoDB\Database;
/**
* 
*/
class MasterCollection
{
	protected $collectionName;
	protected $behavior = [];
	

	/**
	 * construct
	 * @param string $name the name of the collection
	 */
	function __construct($name){
		$this->collectionName = strtolower($name);
		$dbConnect = Config::getDbConf('MongoDB');
		$uri = 'mongodb://'.$dbConnect['host'].':'.$dbConnect['port'];
		$this->manager = new Manager($uri);
		$this->client = new Client($uri);
	}

	/**
	 * load a Collection 
	 * @param  string $name the name
	 * @return mixed        a collection
	 */
	static function load($name){
		$tmp = explode('\\', $name);
		$collection = str_replace('Collection','',$tmp[3]);
		
		$cName = $tmp[0].'\\Model\\Collection\\'.$collection.'Collection';
		unset($tmp);
		
		return new $name($collection);
	}
}