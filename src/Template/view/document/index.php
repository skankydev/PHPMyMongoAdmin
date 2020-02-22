<?php 
$link = ['controller'=>'document'];
$link = ['action'=>'add'];
$link['params']['namespace'] = $myNamespace;
if(isset($doc)){
	$link['action'] ='edit';
	$link['params']['id'] = $doc->_id.'';
}
?>
<section id="Document">
	<header><h1>Document: <?= $myNamespace;?></h1></header>
	<nav>
		<ul>
			<li><span class="btn-menu-save">save</span></li>
			<?php if (!isset($doc)): ?>
				<li><input type="file" id="loadDocument"/><label class="btn-menu-import" for="loadDocument">import</label></li>
			<?php else: ?>
				<li><span class="btn-menu-delete error">delete</span></li>
			<?php endif ?>
			<li><span class="btn-menu-file">export</span></li>
			<li></li>
		</ul>
	</nav>
	<section>
		<div id="Editor"></div>
	</section>
	<footer>
		<div>
			<h4>User Manual</h4>
			<nav>
				<ul>
					<li><a href="https://docs.mongodb.org/manual/core/crud-introduction/" target="_blank">CRUD Introduction</a></li>
				</ul>
			</nav>
		</div>
		<div>
			<h4><a href="http://php.net/manual/en/book.bson.php" target="_blank">MongoDB\BSON</a></h4>
			<dl class='bson-type'>
				<dt>ObjectID</dt><dd>{ "$oid": "5690010baba47e1f98007e7f" }</dd>
				<dt>Timestamp</dt><dd>{ "$timestamp":{ "t": 1452278027,"i": 0 } }</dd>
				<dt>UTCDateTime</dt><dd>{ "$date": 1452278027 }</dd>
				<dt>... </dt><dd>...</dd>
			</dl>
		</div>
	</footer>
</section>
<?php $this->addCss('/vendor/jsoneditor/jsoneditor.min.css'); ?>
<?php $this->addJs('/vendor/jsoneditor/jsoneditor.min.js'); ?>
<?php $this->startScript() ?>

<script type="text/javascript">
$(document).ready(function(){
	
	var option = {
		editOption : {
			mode: 'code',
			history:1,
			indentation:4,
			error: function (err) {alert(err.toString());}
		},
		container:'Editor',
		link:<?= '\''.$this->request->url($link).'\''; ?>,
		<?php if(isset($doc)): ?>
			json:<?= MongoDB\BSON\toJSON(MongoDB\BSON\fromPHP($doc)); ?>
		<?php else: ?>
			json:{}
		<?php endif ?>
	};
	$('#Editor').initJsonEdit(option);
});
</script>
<?php $this->stopScript() ?>