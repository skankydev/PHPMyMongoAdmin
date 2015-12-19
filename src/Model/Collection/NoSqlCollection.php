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
use MongoDB\BSON\ObjectID as MongoId;
use MongoDB\Driver\BulkWrite;
use stdClass;

class NoSqlCollection extends MasterCollection {

	private $manager = false;
	private $defaultQuery = ['query'=>[]];
	protected $db;
	protected $dbName;
	protected $collection;
	protected $collectionName;

	protected $dependOn;
	protected $integrateIn;
	protected $embedded;


	function __construct($name) {
		parent::__construct($name);
		$dbConnect = Config::getDbConf('MongoDB');
		$this->dbName = $dbConnect['database'];
		$this->manager = new Manager('mongodb://'.$dbConnect['host'].':'.$dbConnect['port']);
		$this->collection = new Collection($this->manager, $this->dbName.'.'.$this->collectionName);
	}

	/**
	 * insert or update data 
	 * @param  entity  $entity the data
	 * @return void
	 */
	public function save(&$entity){
		$data = $entity->toArray();
		try {
			if(isset($entity->_id)&&(!empty($entity->_id))){
				$this->update($entity);
			}else{
				$this->insert($entity);
			}
			return true;
		} catch (\Exception $e) {
			if(get_class($e)==='MongoDuplicateKeyException'){
				$var = explode('.', $e->getMessage());
				$var = explode(' ', $var[2]);
				$var = substr($var[0], 1);
				$entity->messageValidate[$var] = 'est deja utiliser';
				return false;
			}
			throw $e;
		}
	}
	
	/**
	 * insert data to database
	 * @param  array $data  the formatede array for database
	 * @return void
	 */
	public function insert($entity){
		try {
			$data = $entity->toArray();
			$this->callBehavior('beforeInsert',$data);
			$this->convertId($data);
			$result = $this->collection->insertOne($data);
			$data['_id'] = $result->getInsertedId();
			$this->doIntegrateIn($data);
			$this->callBehavior('afterInsert',$data);
		} catch (Exception $e) {
			throw $e;
		}
	}

	/**
	 * update data to database
	 * @param  array $data  the formatede array for database
	 * @return void
	 */
	public function update($entity){
		try {
			$data = $entity->toArray();
			$this->updateEmbedded($data,$entity);
			$theId = new MongoId($data['_id']);
			unset($data['_id']);
			$this->callBehavior('beforeUpdate',$data,$entity);
			//$this->collection->updateOne(['_id'=>$theId],$data);
			$bulk = new BulkWrite();
			$bulk->update(['_id'=>$theId],$data);
			$this->manager->executeBulkWrite($this->dbName.'.'.$this->collectionName,$bulk);
			$this->callBehavior('afterUpdate',$data,$entity);
		} catch (Exception $e) {
			throw $e;
		}
	}
	
	public function convertId(&$data){
		foreach ($data as $key => $value) {
			if(preg_match('/[a-zA-Z0-9_-]*_id/', $key)){
				$data[$key] = new MongoId($value);
			}
		}
	}

	public function doIntegrateIn($data){
		if(!empty($this->integrateIn)){
			foreach ($this->integrateIn as $cName => $option) {
				$collection = new Collection($this->manager, $this->dbName.'.'.$cName );
				$cursor = $collection->find(['_id'=>$data[$cName.'_id']]);
				$in = $cursor->toArray()[0];
				$howTo = $option['insert'];
				$in = $howTo($data,$in,$option['options']);
				$bulk = new BulkWrite();
				$bulk->update(['_id'=>$data[$cName.'_id']],$in);
				$this->manager->executeBulkWrite($this->dbName.'.'.$cName,$bulk);
				//$collection->updateOne(['_id'=>$data[$cName.'_id']],$in);
			}
		}
	}
	
	public function doEmbedded(&$data,&$entity){
		if(!empty($this->embedded)){
			foreach ($this->embedded as $value) {
				if(isset($data->{$value})){
					$entity->{$value} = $data->{$value};
				}
			}
		}
	}

	public function updateEmbedded(&$data,&$entity){
		if(!empty($this->embedded)){
			foreach ($this->embedded as $value) {
				if(isset($entity->{$value})){
					$data[$value] = $entity->{$value};//TO DO crée des objet collection embarquer
				}
			}
		}
	}

	public function createEntity($data){
		if(is_array($data)){
			$myData = new stdClass();
			foreach ($data as $key => $value) {
				$myData->{$key} = $value;
			}
		}else{
			$myData = $data;
		}
		$entity = parent::createEntity($myData);
		$this->doEmbedded($myData,$entity);
		return $entity;
	}



	/**
	 * find query
	 * @param  array   $query the query
	 * @return array          entity liste
	 */
	public function find($option = []){
		$option = array_replace_recursive($this->defaultQuery,$option);
		$this->convertId($option['query']);
		$query = $option['query'];
		unset($option['query']);
		$cursor = $this->collection->find($query,$option);
		$retour = [];
		foreach ($cursor as $entityData) {
			$retour[] = $this->createEntity($entityData);
		}
		return $retour;
	}

	/**
	 * find firest result of query
	 * @param  array  $query the query
	 * @return entity     the document
	 */
	public function findOne($query = []){
		$cursor = $this->collection->find($query);
		$retour = $this->createEntity($cursor->toArray()[0]);
		return $retour;
	}

	/**
	 * find a document by id 
	 * @param  string $id the id of document
	 * @return entity     the document
	 */
	public function findById($id =''){
		$id = new MongoId($id);
		$cursor = $this->collection->find(['_id'=>$id]);
		$retour = $this->createEntity($cursor->toArray()[0]);
		return $retour;
	}

	/**
	 * count document in collection
	 * @param  array  $query the query
	 * @return int           the total
	 */
	public function count($query = []){
		//return $this->collection->find($query)->count();
		return $this->collection->count($query);
	}

	/**
	 * prepare query for pagination
	 * @param  array                          $option the option for query
	 * @return PHPMyMongoAdmin\Utilities\Paginator          the paginator object
	 */
	public function paginate($option = []){
		$option = array_replace_recursive($this->defaultQuery,$option);
		$dOption = Config::get('paginator');
		$option = array_replace_recursive($dOption,$option);
		$option['skip'] = $option['limit']*($option['page']-1);
		$option['count'] = $this->count($option['query']);
		$result = $this->find($option);
		$paginator = new Paginator($result);
		unset($option['query']);
		unset($option['skip']);
		$paginator->setOption($option);

		return $paginator;
	}

	/**
	 * delete entity
	 * @param  array  $query the query
	 * @return MongoDB\DeleteResult | false
	 */
	public function delete($query = []){
		if(!empty($query)){
			return $this->collection->deleteOne($query);
		}
		return false;
	}
}
