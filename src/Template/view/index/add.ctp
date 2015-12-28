<section>
	<header><h1>Create Index <?php echo $namespace; ?></h1></header>
	<?php echo $this->Form->start($this->request->url(['action'=>'add','params'=>['namespace'=>$namespace]])); ?>
		<?php echo $this->Form->fieldset([
			'legend'  => ['content'=>'creat a new index','class'=>'legend'],
			'input'   => [
					'name'         => ['label'=>'name','required'=>'required'],
					'key[0][name]' => ['label'=>'key','required'=>'required'],
					'key[0][type]' => ['label'=>'type','type'=>'select','option'=>['1','-1']],
					'key[1][name]' => ['label'=>'key','required'=>'required'],
					'key[1][type]' => ['label'=>'type','type'=>'select','option'=>['1','-1']],
					'unique'       => ['label'=>'unique','type'=>'checkbox'],
					'sparse'       => ['label'=>'sparse','type'=>'checkbox'],
					'ttl'          => ['label'=>'ttl','type'=>'number'],
				]
		]); ?>
		<?php echo $this->Form->submit('Send'); ?>
	<?php echo $this->Form->end(); ?>
	<footer>
		
	</footer>
</section>
<?php $this->startScript() ?>
<script type="text/javascript">
$(document).ready(function(){
//quand je per le focuse sur un name et que j ai un truc je crée un nouveau combo key name value
});
</script>
<?php $this->stopScript() ?>