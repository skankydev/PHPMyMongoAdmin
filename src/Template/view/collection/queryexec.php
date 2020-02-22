<section>
	<header><h1>Index: <?= $myNamespace; ?></h1> </header>
	<nav class="pages-menu">
		<ul>
			<li><?= $this->link('edite', ['action'=>'query','params'=>['namespace'=>$myNamespace]],['class'=>'btn-menu']);?></li>
			<li><?= $this->link('collection', ['action'=>'index','params'=>['namespace'=>$myNamespace]],['class'=>'btn-menu']);?></li>
		</ul>
	</nav>
	<section>
		<div class="pipeline">
			<?= json_encode($query); ?>
		</div>
	</section>
	<section id="many-editor">
		<?php foreach ($cursor as $value): ?>
		<div class="document">
			<div class="editor">
			<?=  MongoDB\BSON\toJSON(MongoDB\BSON\fromPHP($value)); ?>
			</div>
		</div>
		<?php endforeach ?>
	</section>
	<footer>
		<?= $this->element('paginator',$cursor->getOption()); ?>
	</footer>
</section>
<?php $this->addCss('/vendor/jsoneditor/jsoneditor.min.css'); ?>
<?php $this->addJs('/vendor/jsoneditor/jsoneditor.min.js'); ?>
<?php $this->startScript() ?>

<script type="text/javascript">
$(document).ready(function(){
	var container = document.getElementsByClassName('editor');
	var option = {
		mode: 'view',
		indentation:4,
		search:false,
		error: function (err) {
			alert(err.toString());
		}
	}

	var num = container.length;
	var editor = [];
	for (var i = 0; i < num; i++) {
		var text = $(container[i]).html();
		$(container[i]).html('');
		editor[i] = new JSONEditor(container[i], option);
		editor[i].set(JSON.parse(text));
	};

});
</script>
<?php $this->stopScript() ?>