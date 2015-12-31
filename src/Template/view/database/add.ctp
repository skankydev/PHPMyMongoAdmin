<?php 
$dbOption = ['label'=>'Database name','required'=>'required'];
$params = [];
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
			<h1><?php echo $dbName; ?></h1>
		<?php else: ?>
			<h1>Create database</h1>
		<?php endif ?>
	</header>
	<?php echo $this->Form->start($this->request->url(['action'=>'add','params'=>$params])); ?>
		<?php echo $this->Form->fieldset([
			'legend'  => ['content'=>'creat a new collection','class'=>'legend'],
			'input'   => [
					'database'       => $dbOption,
					'collection'     => ['label'=>'Collection name','required'=>'required'],
					'autoIndexId'    => ['label'=>'auto index','type'=>'checkbox','checked'=>'checked'],
					'capped'         => ['label'=>'capped','type'=>'checkbox'],
					'size'           => ['label'=>'size','type'=>'number'],
					'max'            => ['label'=>'maximum number of documents','type'=>'number'],
				]
		]); ?>
		<?php echo $this->Form->submit('Send'); ?>
	<?php echo $this->Form->end(); ?>
	<footer>
	<h4>User Manual</h4>
	<ul>
		<li><a href="https://docs.mongodb.org/v3.0/reference/method/db.createCollection/" target="_blank">collection</a></li>
	</ul>
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