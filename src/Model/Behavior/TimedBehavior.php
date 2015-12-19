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
namespace PHPMyMongoAdmin\Model\Behavior;

use PHPMyMongoAdmin\Model\Behavior\MasterBehavior;
use MongoDB\BSON\UTCDateTime as MongoDate;
use DateTime;
class TimedBehavior extends MasterBehavior {
	
	private $collection;

	public function __construct(&$collection){
		$this->collection = $collection;
	}
	public function beforeInsert(&$data,&$entity=null){
		$data['created'] = new MongoDate(time());
		$data['updated'] = new MongoDate(time());
	}


	public function afterInsert(&$data,&$entity=null){

	}

	public function beforeUpdate(&$data,&$entity=null){
		$data['updated'] = new MongoDate(time());
		$data['created'] = isset($entity->created)?$this->toMongoDate($entity->created):new MongoDate(time());
	}

	public function afterUpdate(&$data,&$entity=null){

	}

	public function beforeCreateEntity(&$data,&$entity=null){

	}

	public function afterCreateEntity(&$data,&$entity=null){
		if(isset($data->created)){
			$date = $data->created;
			if(is_array($date)){
				$date = new DateTime($date['date']);
				$entity->created = $date;
			}else{
				$date = $data->created;
				$myDate = new DateTime();
				$ts = (int)$date->__toString();
				$myDate->setTimestamp($ts);
				$entity->created = $myDate;
			}
		}
		if(isset($data->updated)){
			$date = $data->created;
			$myDate = new DateTime();
			$ts = (int)$date->__toString();
			$myDate->setTimestamp($ts);
			$entity->updated = $myDate;
		}
	}

	public function toMongoDate(DateTime $date){
		return new MongoDate(strtotime($date->format("Y-m-d H:i:s")));
	}

	//TO DO un gestionnaire pour les date 

}