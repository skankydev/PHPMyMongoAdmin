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
namespace PHPMyMongoAdmin\Controller\Tools;

use PHPMyMongoAdmin\Controller\Tools\MasterTool;
use PHPMyMongoAdmin\Utilities\Session;
/**
* 
*/
class FlashMessagesTool extends MasterTool {

	private $default = [
		'tags' => ['div','span'],
		'attr' => ['class'=>'sucsse']
	];

	private $messages;

	public function __construct(){
		$this->messages = Session::get('FlashMessage');
	}

	public function set($message, $attr = []){
		$this->messages[] = ['messages' => $message,'attr' => $attr];
		Session::set('FlashMessage',$this->messages);
	}
}