<?php 
$link = ['controller'=>'document'];
$link = ['action'=>'add'];
$link['params']['namespace'] = $namespace;
if(isset($doc)){
	$link['action'] ='edit';
	$link['params']['id'] = $doc->_id.'';
}
?>
<section id="Document">
	<header><h1>Document: <?php echo $namespace; ?></h1></header>
	<nav>
		<ul>
			<li><span class="btn-menu-save info">save</span></li>
			<?php if (!isset($doc)): ?>
				<li><input type="file" id="loadDocument"/><label class="btn-menu-import info" for="loadDocument">import</label></li>
			<?php else: ?>
				<li><span class="btn-menu-delete error">delete</span></li>
			<?php endif ?>
			<li><span class="btn-menu-file info">export</span></li>
			<li><?php echo $this->link('Back', ['controller'=>'collection','action'=>'index','params'=>['namespace'=>$namespace]],['class'=>'btn-menu-back info']);?></li>
		</ul>
	</nav>
	<section>
		<div id="editor"></div>
	</section>
	<footer>
		<h4>User Manual</h4>
		<ul>
			<li><a href="https://docs.mongodb.org/manual/core/crud-introduction/" target="_blank">CRUD Introduction</a></li>
		</ul>
	</footer>
</section>
<?php $this->addCss('/vendor/jsoneditor/jsoneditor.min.css'); ?>
<?php $this->addJs('/vendor/jsoneditor/jsoneditor.min.js'); ?>
<?php $this->startScript() ?>

<script type="text/javascript">
$(document).ready(function(){
	var container = document.getElementById('editor');
	var option = {
		mode: 'code',
		modes:['code','form', 'text', 'tree', 'view'],
		history:1,
		indentation:4,
		error: function (err) {
			alert(err.toString());
		}
	}
	var editor = new JSONEditor(container, option);
	var reader = new FileReader();
	<?php if(isset($doc)): ?>
		var json = <?php echo MongoDB\BSON\toJSON(MongoDB\BSON\fromPHP($doc)); ?>;
		editor.set(json);
	<?php endif ?>
	var link = <?php echo '\''.$this->request->url($link).'\''; ?>;

	reader.onload = function(event){
		console.log(event);
		var text = event.target.result;
		editor.set(JSON.parse(text));
	};

	$('#loadDocument').on('change',function(event){
		reader.readAsText($(this)[0].files[0]);
	});

	$('.btn-menu-save').on('click',function(event){
		var json = editor.get();
		$.post(link,{json:JSON.stringify(json)},function(data){});
	});
});
</script>
<?php $this->stopScript() ?>