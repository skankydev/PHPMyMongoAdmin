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

function dd($data,$message = ''){
	debug($data,$message = '');
	die();

}

function debug($data,$message = ''){
	echo '<div class="debug-message">';
	if(!empty($message)){
		echo $message;
	}else{
		$backtrace = debug_backtrace();
		$type = gettype($backtrace[0]['args'][0]);
		if($type === 'object'){
			$type = get_class($backtrace[0]['args'][0]);
		}
		$source = '';
		if(isset($backtrace[1]['class'])){
			$source = 'class: <span class="debug-keyword">'.$backtrace[1]['class'].'</span> method: <span class="debug-keyword"> '.$backtrace[1]['function'].'</span>';
		}else{
			$source = 'file: <span class="debug-keyword">'.$backtrace[0]['file'].'</span> line: <span class="debug-keyword">'.$backtrace[0]['line'].'</span>';
		}
		echo 'debug : <span class="debug-keyword">'.$type.'</span> from '.$source;
	}
	ob_start();
	print_r($data);
	$output = ob_get_clean();

	echo "<pre><code>".$output."</code></pre>";
	echo '</div>';
	
}
