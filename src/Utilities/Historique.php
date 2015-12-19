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

use PHPMyMongoAdmin\Utilities\Session;
use PHPMyMongoAdmin\Config\Config;
use PHPMyMongoAdmin\Request;

/**
 * 
 */
class Historique
{
	private $history = [];
	private $limit;

	/**
	 * get the historique and the limit 
	 */
	function __construct(){
		$this->history = Session::get('request.history');
		$this->limit   = Config::get('request.historyLimit');
	}

	/**
	 * add the 
	 * @param  Request $request the Request
	 * @return void
	 */
	function updateHistorique(Request $request){
		if(!$this->history){
			$this->history = [];
		}
		$hData['url']                = $request->sheme.'://'.$request->host.$request->uri;
		$hData['direct']             = true;
		$hData['sheme']              = $request->sheme;
		$hData['method']             = $request->method;
		$hData['uri']                = $request->uri;
		$hData['link']['namespace']  = $request->namespace;
		$hData['link']['controller'] = $request->controller;
		$hData['link']['action']     = $request->action;
		$hData['link']['params']     = $request->params;
		$count = array_unshift($this->history, $hData);
		if($count>$this->limit){
			unset($this->history[$this->limit]);
		}
		Session::set('request.history',$this->history);
	}

	/**
	 * get historique
	 * @return array the historique
	 */
	function getHistorique(){
		return $this->history;
	}

	/**
	 * return the last direct request
	 * @return array the last request
	 */
	function getLastDirect(){
		$retour = false;
		$i = 1;
		$c = count($this->history);
		while ( ($i<$c) && ($this->history[$i]['direct'] == false) ){$i++;}
		if($i<$c){
			$retour = $this->history[$i];
		}
		return $retour;
	}


	/**
	 * set the last
	 * @return [type] [description]
	 */
	function notDirect(){
		$this->history[0]['direct'] = false;
		Session::set('request.history.0.direct',false);
	}
}