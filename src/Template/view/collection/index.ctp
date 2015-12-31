<section id="DocumentList">
	<header>
		<h1><?php echo $cName; ?></h1>
	</header>
	<nav>
		<ul>
			<li><?php echo $this->link('add', ['controller'=>'document','action'=>'index','params'=>['namespace'=>$cName]],['class'=>'btn-menu info']);?></li>
			<li><?php echo $this->link('index', ['controller'=>'index','action'=>'index','params'=>['namespace'=>$cName]],['class'=>'btn-menu info']);?></li>
			<li><?php echo $this->link('drop',
						['controller'=>'collection', 'action'=>'drop','params'=>['name'=>$cName]],
						['onclick'=>"return confirm('Are you sure?')",'class'=>'btn-menu error']
						); ?></li>
		</ul>
	</nav>
	<section>
		<?php foreach ($data as $value): ?>
<div class="document">
<nav>
	<ul>
		<li><?php echo $this->link('e', ['controller'=>'document','action'=>'index','params'=>['namespace'=>$cName,'id'=>$value->_id]],['class'=>'btn-action-edit']);?></li>
		<li><?php echo $this->link('d', ['controller'=>'document','action'=>'drop','params'=>['namespace'=>$cName,'id'=>$value->_id]],['class'=>'btn-action-drop','onclick'=>"return confirm('Are you sure?')"]);?></li>
	</ul>
</nav>
<pre>
<code>
<?php 
//we bon c'est un peux moche tout ca 
$value =  MongoDB\BSON\toJSON(MongoDB\BSON\fromPHP($value));
$value = json_decode($value);
$value =  json_encode($value,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
print_r($value);
?>
</code>
</pre>
</div>
		<?php endforeach ?>
	</section>
	<footer>
		<?php echo $this->element('paginator',$data->getOption()); ?>
	</footer>
</section>