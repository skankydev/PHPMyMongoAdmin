<section id="DocumentList">
	<header>
		<h1><?php echo $cName; ?></h1>
	</header>
	<section>
		<?php foreach ($data as $value): ?>
<div class="document">
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