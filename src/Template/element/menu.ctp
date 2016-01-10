<?php 
$params = $this->request->params;
$controller = $this->request->controller;
$action = $this->request->action;
?>
<nav id="Menu">
	<ul>
		<li><a href="/">Database</a></li><?php 
		if (isset($params[0])){
			$name = $params[0];
			$name = explode('.',$name);
			if (isset($name[1])){
				echo '<li>'.$this->link($name[0], ['controller'=>'database','action'=>'view','params'=>['name'=>$name[0]]]).'</li>';
				if($controller!=='collection' || $action!=='index'){
					$text = $name;
					unset($text[0]);
					$text = join($text);
					echo '<li>'.$this->link($text, ['controller'=>'collection','action'=>'index','params'=>['namespace'=>$params[0]]]).'</li>';
				}
			}
		} ?>
	</ul>
</nav>
