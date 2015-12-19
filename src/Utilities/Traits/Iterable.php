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
namespace PHPMyMongoAdmin\Utilities\Traits;


/**
* 
*/
trait Iterable {

	/**
	 * Rewind the Iterator to the first element
	 */
	public function rewind(){
		reset($this->data);
	}

	/**
	 * Return the current element
	 * @return mixed value
	 */
	public function current(){
		$var = current($this->data);
		return $var;
	}

	/**
	 * Return the key of the current element
	 * @return mixed key
	 */
	public function key(){
		$var = key($this->data);
		return $var;
	}

	/**
	 * Move forward to next element
	 * @return mixed value
	 */
	public function next(){
		$var = next($this->data);
		return $var;
	}

	/**
	 * Checks if current position is valid
	 * @return bool valid
	 */
	public function valid(){
		$key = key($this->data);
		$var = ($key !== NULL && $key !== FALSE);
		return $var;
	}
}