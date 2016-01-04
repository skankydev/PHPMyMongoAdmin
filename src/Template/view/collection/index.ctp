<section>
	<header>
		<h1><?php echo $cName; ?></h1>
	</header>
	<nav class="pages-menu">
		<ul>
			<li>
				<?php echo $this->link('add', ['controller'=>'document','action'=>'index','params'=>['namespace'=>$cName]],['class'=>'btn-menu info']);?>
			</li>
			<li>
				<?php echo $this->link('index', ['controller'=>'index','action'=>'index','params'=>['namespace'=>$cName]],['class'=>'btn-menu info']);?>
			</li>
			<li>
				<?php echo $this->link('drop',
					['controller'=>'collection', 'action'=>'drop','params'=>['name'=>$cName]],
					['onclick'=>"return confirm('Are you sure?')",'class'=>'btn-menu error'] ); ?>
			</li>
		</ul>
	</nav>
	<section id="many-editor">
		<?php foreach ($data as $value): ?>
		<div class="document">
			<?php if (isset($value->_id)): ?>
			<nav>
				<ul>
					<li>
						<?php echo $this->link('e',
							['controller'=>'document','action'=>'index','params'=>['namespace'=>$cName,'id'=>$value->_id]],
							['class'=>'btn-action-edit']);?>
					</li>
					<li>
						<?php echo $this->link('d',
							['controller'=>'document','action'=>'delete','params'=>['namespace'=>$cName,'id'=>$value->_id]],
							['class'=>'btn-action-drop','onclick'=>"return confirm('Are you sure?')"]);?>
					</li>
				</ul>
			</nav>
			<?php endif ?>
			<div class="editor">
			<?php 
				//we bon c'est un peux moche tout ca 
				echo  MongoDB\BSON\toJSON(MongoDB\BSON\fromPHP($value));
			?>
			</div>
		</div>
		<?php endforeach ?>
	</section>
	<footer>
		<?php echo $this->element('paginator',$data->getOption()); ?>
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
	console.log(container);
	console.log(container.length);
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