<?php 
$dbOption = ['label'=>'Database name','required'=>'required'];
$params = ['pattern'=>'[a-zA-Z.]*','title'=>"a-z A-z ."];
 ?>
<section id="create-collection">
	<header>
		<?php if (!empty($dbName)): ?>
			<?php 
				$params['dbName'] = $dbName;
				$dbOption['value'] = $dbName;
				$dbOption['type'] = 'hidden';
				unset($dbOption['label']);
			?>
			<h1><?= $dbName; ?></h1>
		<?php else: ?>
			<h1>Create database</h1>
		<?php endif ?>
	</header>
	<?= $this->Form->start($this->request->url(['action'=>'add','params'=>$params])); ?>
		<?= $this->Form->fieldset([
			'legend'  => ['content'=>'creat a new collection'],
			'input'   => [
					'database'       => $dbOption,
					'collection'     => ['label'=>'Collection name','required'=>'required','pattern'=>'[a-zA-Z.]*','title'=>"a-z A-Z ."],
					'autoIndexId'    => ['label'=>'auto index','type'=>'checkbox','checked'=>'checked'],
					'capped'         => ['label'=>'capped','type'=>'checkbox'],
					'size'           => ['label'=>'size','type'=>'number'],
					'max'            => ['label'=>'maximum number of documents','type'=>'number'],
				]
		]); ?>
		<?= $this->Form->submit('Send'); ?>
	<?= $this->Form->end(); ?>
	<footer>
	<h4>User Manual</h4>
	<nav>
		<ul>
			<li><a href="https://docs.mongodb.org/v3.0/reference/method/db.createCollection/" target="_blank">collection</a></li>
		</ul>
	</nav>
	</footer>
</section>

<?php $this->startScript() ?>
<script type="text/javascript">
$(document).ready(function(){
	$('#capped').on('change',function(event){
		if($(this).is(':checked')){
			$('#size').prop('required','required');
		}else{
			$('#size').removeAttr('required');
		}
	});
	if($('#capped').is(':checked')){
		$('#size').prop('required','required');
	}else{
		$('#size').removeAttr('required');
	}
});
</script>
<?php $this->stopScript() ?>