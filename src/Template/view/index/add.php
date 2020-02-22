<section>
	<header>
		<h1>Create Index <?= $myNamespace; ?></h1>
	</header>
	<nav class="pages-menu">
		<ul>
			<li><span class="btn-menu-save">save</span></li>
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
				<li><a href="https://docs.mongodb.org/manual/core/indexes/" target="_blank">Index Concepts</a></li>
				<li><a href="http://docs.mongodb.org/manual/reference/command/createIndexes/" target="_blank">Create Indexes</a></li>
				<li><a href="http://docs.mongodb.org/manual/reference/method/db.collection.createIndex/" target="_blank">Commende</a></li>
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
		link:<?= '\''.$this->request->url(['action'=>'add','params'=>['namespace'=>$myNamespace]]).'\''; ?>,
		json:[{"key":{"field_name_A": 1,},"name": "index_name","background": true}]
	};
	$('#Editor').initJsonEdit(option);

});
</script>
<?php $this->stopScript() ?>
