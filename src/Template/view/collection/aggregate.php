<section>
	<header>
		<h1>Aggregate: <?= $myNamespace; ?></h1>
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
				<li><a href="https://docs.mongodb.org/manual/core/aggregation-introduction/" target="_blank">Aggregation Concepts</a></li>
				<li><a href="https://docs.mongodb.org/manual/meta/aggregation-quick-reference/" target="_blank">Quick Reference</a></li>
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
		link:<?= '\''.$this->request->url(['action'=>'aggregate','params'=>['namespace'=>$myNamespace]]).'\''; ?>,
		<?php if(isset($pipeline)): ?>
			json:<?= json_encode($pipeline); ?>
		<?php else: ?>
			json:[{"$match":{"fieldName": "value"}}]
		<?php endif ?>
	};
	$('#Editor').initJsonEdit(option);
});
</script>
<?php $this->stopScript() ?>
