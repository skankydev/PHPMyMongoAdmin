<section>
	<header>
		<h1>Aggregate: <?php echo $namespace; ?></h1>
	</header>
	<nav class="pages-menu">
		<ul>
			<li><span class="btn-menu-save">execute</span></li>
		</ul>
	</nav>
	<section>
		<div id="editor"></div>
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
	
	var container = document.getElementById('editor');
	var option = {
		mode: 'code',
		history:1,
		indentation:4,
		error: function (err) {
			alert(err.toString());
		}
	}
	var editor = new JSONEditor(container, option);
	var link = <?php echo '\''.$this->request->url(['action'=>'aggregate','params'=>['namespace'=>$namespace]]).'\''; ?>;
	var reader = new FileReader();
	<?php if(isset($pipeline)): ?>
		var json = <?php echo json_encode($pipeline); ?>;
	<?php else: ?>
		var json = [{"$match":{"first_name": "Sandra"}}];
	<?php endif ?>
	editor.set(json);

	//c'est la meme chose que l autre. a grouper!
	$('.btn-menu-save').on('click',function(event){
		var json = editor.get();
		$.post(link,{json:JSON.stringify(json)},function(data){
			if(data.result){
				window.location.replace(data.url);
			}else{
				//create aletre
				var text = '<div class="flash-message error">'+data.message+'<div>';
				$("#Flash-Message").html(text);
			}
		},'json');
	});
	reader.onload = function(event){
		var text = event.target.result;
		editor.set(JSON.parse(text));
	};

	$('#loadDocument').on('change',function(event){
		reader.readAsText($(this)[0].files[0]);
	});

	$('.btn-menu-file').on('click',function(event){
		var blob = new Blob([editor.getText()], {type: 'application/json;charset=utf-8'});
		var url = URL.createObjectURL(blob);
		window.open(url);
	});
});
</script>
<?php $this->stopScript() ?>
