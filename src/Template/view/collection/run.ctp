<section>
	<header><h1>Index: <?php echo $namespace; ?></h1> </header>
	<nav class="pages-menu">
		<ul>
			<li><?php echo $this->link('edite', ['action'=>'aggregate','params'=>['namespace'=>$namespace]],['class'=>'btn-menu']);?></li>
			<li><?php echo $this->link('collection', ['action'=>'index','params'=>['namespace'=>$namespace]],['class'=>'btn-menu']);?></li>
		</ul>
	</nav>
	<section>
		<div class="pipeline">
			<?php echo json_encode($pipeline); ?>
		</div>
	</section>
	<section id="many-editor">
		<?php foreach ($cursor as $value): ?>
		<div class="document">
			<div class="editor">
			<?php echo  MongoDB\BSON\toJSON(MongoDB\BSON\fromPHP($value)); ?>
			</div>
		</div>
		<?php endforeach ?>
	</section>

	<footer>
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