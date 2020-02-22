<section>
	<header>
		<h1><?= $myNamespace; ?></h1>
	</header>
	<nav class="pages-menu">
		<ul>
			<li>
				<?= $this->link('add', ['controller'=>'document','action'=>'index','params'=>['namespace'=>$myNamespace]],['class'=>'btn-menu']);?>
			</li>
			<li>
				<?= $this->link('index', ['controller'=>'index','action'=>'index','params'=>['namespace'=>$myNamespace]],['class'=>'btn-menu']);?>
			</li>
			<li>
				<?= $this->link('query', ['action'=>'query','params'=>['namespace'=>$myNamespace]],['class'=>'btn-menu']);?>
			</li>
			<li>
				<?= $this->link('aggregate', ['action'=>'aggregate','params'=>['namespace'=>$myNamespace]],['class'=>'btn-menu']);?>
			</li>
			<li>
				<?= $this->link('import', ['action'=>'import','params'=>['namespace'=>$myNamespace]],['class'=>'btn-menu']);?>
			</li>
			<li>
				<?= $this->link('drop',
					['controller'=>'collection', 'action'=>'drop','params'=>['name'=>$myNamespace]],
					['onclick'=>"return confirm('Are you sure?')",'class'=>'btn-menu error'] ); ?>
			</li>
		</ul>
	</nav>
	
	<section id="many-editor">
		<?php foreach ($data as $value): ?>
		<div class="document">
			<?php if (isset($value->_id)): ?>
			<nav class="action-menu">
				<ul>
					<li>
						<?= $this->link('E',
							['controller'=>'document','action'=>'index','params'=>['namespace'=>$myNamespace,'id'=>$value->_id]],
							['class'=>'btn-action-edit']);?>
					</li>
					<li>
						<?= $this->link('D',
							['controller'=>'document','action'=>'delete','params'=>['namespace'=>$myNamespace,'id'=>$value->_id]],
							['class'=>'btn-action-drop','onclick'=>"return confirm('Are you sure?')"]);?>
					</li>
				</ul>
			</nav>
			<?php endif ?>
			<div class="editor">
			<?php 
				//we bon c'est un peux moche tout ca 
				echo  htmlentities(MongoDB\BSON\toJSON(MongoDB\BSON\fromPHP($value)));
			?>
			</div>
		</div>
		<?php endforeach ?>
	</section>
	<footer>
		<?= $this->element('paginator',$data->getOption()); ?>
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