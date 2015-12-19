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

	$output = preg_replace("/\n[    ]*\(/", " (", $output);
	$output = preg_replace_callback("/\[[a-zA-Z0-9:_$ ]*\]/",function($result){
		return preg_replace("/[a-zA-Z0-9:_$]+/", "<span class=\"debug-var\">$0</span>", $result[0]);
	}, $output);
	$output = preg_replace_callback("/ [A-Z][a-zA-Z\ ]+ \(/",function($result){
		return preg_replace("/[A-Z][a-zA-Z0-9\ ]+/", "<span class=\"debug-source\">$0</span>", $result[0]);
	}, $output);
	$output = preg_replace_callback("/ \=\> [\w ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ'\-\+:]+/",function($result){
		if(preg_match("/\=\> [0-9]+$/", $result[0])){
			return preg_replace("/ [0-9]+$/", "<span class=\"debug-integer\">$0</span>", $result[0]);
		}
		$result = substr($result[0],-strlen($result[0])+4);//we je sais ca bug
		return ' => <span class="debug-text">'.$result.'</span>';
	}, $output);

	echo "<pre><code>".$output."</code></pre>";
	echo '</div>';
	
}
