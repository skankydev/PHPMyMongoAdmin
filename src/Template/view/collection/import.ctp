<section id="Import">
	<header>
		<h1>Import: <?php echo $namespace ?></h1>
	</header>
		<?php echo $this->Form->start($this->request->url(['action'=>'import','params'=>['namespace'=>$namespace]]),['enctype'=>"multipart/form-data"]); ?>
		<?php echo $this->Form->fieldset([
			'legend'  => ['content'=>'import json file'],
			'input'   => [
					'namespace'      => ['type'=>'hidden','value'=>$namespace],
					'import'         => ['label'=>'json document','type'=>'file'],
				]
		]); ?>
		<?php echo $this->Form->submit('Send'); ?>
	<?php echo $this->Form->end(); ?>
	<footer>
		
	</footer>
</section>