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
namespace PHPMyMongoAdmin\Utilities;

use PHPMyMongoAdmin\Utilities\Traits\Iterable;
use PHPMyMongoAdmin\Config\Config;
use Iterator;

/**
* Paginator
*/
class Paginator implements Iterator {
	
	use Iterable;

	var $data = [];
	var $option = ['params'=>[]];
	
	/**
	 * construct
	 * @param array $data thes iterable data 
	 */
	function __construct($data){
		$this->data = $data;
		
	}

	/**
	 * get option for pagination
	 * @return array the option
	 */
	function getOption(){
		return $this->option;
	}
	/**
	 * set parametre for link in paginator
	 * @param array $params the params
	 */
	function setParams($params){
		$this->option['params'] = $params;
	}
	/**
	 * set option for pagination
	 * @param array $option new option
	 */
	function setOption($option){
		$this->option = array_merge($this->option,$option);
		$this->option['pages'] = floor($this->option['count']/$this->option['limit'])+(($this->option['count']%$this->option['limit'])?1:0);
		$this->option['first'] = 1;
		$this->option['last'] = $this->option['pages'];
		$next = $this->option['page']+1;
		$this->option['next'] = ($next>$this->option['last'])? $this->option['last'] : $next;
		$prev = $this->option['page']-1;
		$this->option['prev'] = ($prev<$this->option['first'])? $this->option['first'] : $prev;
		$start = $this->option['page'] - floor($this->option['range']/2);
		$this->option['start'] = ($start<$this->option['first'])?$this->option['first'] : $start;
		$stop = floor($this->option['range']/2) + $this->option['page'] + (($this->option['range']%2)?1:0);
		$this->option['stop'] = ($stop>$this->option['last'])?($this->option['last']+1):$stop;
	}
}
