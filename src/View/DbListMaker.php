<?php 

namespace PHPMyMongoAdmin\View;

use PHPMyMongoAdmin\Model\Database;
use PHPMyMongoAdmin\Utilities\Traits\IterableData;
use Iterator;

class DbListMaker implements Iterator  {

	use IterableData;

	private $manager;
	private $data;
	
	public function __construct(){
		$this->manager = new Database('DataBase');
		$dbList = $this->manager->getDBList();
		$tmp = [];
		foreach ($dbList as $db) {
			$tmp[] = [
				'name'        => $db->getName(),
				'size'        => $db->getSizeOnDisk(),
				'collections' => $this->getCollections($db->getName()),
			];
		}

		usort($tmp,function($a,$b) {
			return strnatcmp($a['name'], $b['name']);
		});

		$this->data = $tmp;
	}

	public function getCollections($dbName){
		$collectionList = $this->manager->getCollectionList($dbName);
		$retour = [];
		foreach ($collectionList as $key => $collection) {
			$retour[] = $collection->getName();
		}
		asort($retour);
		return $retour;
	}

}