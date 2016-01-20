<section>
	<header>
		<h1>Query: <?php echo $myNamespace; ?></h1>
	</header>
	<nav class="pages-menu">
		<ul>
			<li><span class="btn-menu-save">execute</span></li>
			<li><input type="file" id="loadDocument"/><label class="btn-menu-import" for="loadDocument">import</label></li>
			<li><span class="btn-menu-file">export</span></li>
		</ul>
	</nav>
	<section>
		<div id="Editor"></div>
	</section>
	<footer>
		<h4>User Manual</h4>
		<nav>
			<ul>
				<li><a href="http://docs.mongodb.org/manual/core/read-operations-introduction/" target="_blank">Query Concepts</a></li>
				<li><a href="http://php.net/manual/fr/mongodb-driver-query.construct.php" target="_blank">MongoDB\Driver\Query</a></li>
				<li><a href="https://docs.mongodb.org/manual/reference/operator/query/" target="_blank">Query Operators</a></li>
			</ul>
		</nav>
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
		link:<?php echo '\''.$this->request->url(['action'=>'query','params'=>['namespace'=>$myNamespace]]).'\''; ?>,
		<?php if(isset($query)): ?>
			json:<?php echo json_encode($query); ?>
		<?php else: ?>
			json:{"filter":{"fieldName":"value"},"options":{"projection": {"fieldName": 1}}}
		<?php endif ?>
	};
	$('#Editor').initJsonEdit(option);
});
</script>
<?php $this->stopScript() ?>