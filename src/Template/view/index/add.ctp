<section>
	<header>
		<h1>Create Index <?php echo $namespace; ?></h1>
	</header>
	<nav class="pages-menu">
		<ul>
			<li><span class="btn-menu-save info">save</span></li>
			<li><input type="file" id="loadDocument"/><label class="btn-menu-import info" for="loadDocument">import</label></li>
		</ul>
	</nav>
	<section>
		<div id="editor"></div>
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
	var link = <?php echo '\''.$this->request->url(['action'=>'add','params'=>['namespace'=>$namespace]]).'\''; ?>;

	//c'est la meme chose que l autre. a grouper!
	$('.btn-menu-save').on('click',function(event){
		var json = editor.get();
		$.post(link,{json:JSON.stringify(json)},function(data){
			if(data.result){
				window.location.replace(data.url);
			}else{
				console.log(data);
			}
		},'json');
	});

	var reader = new FileReader();

	<?php $indexes = [
			[ 'key' => [ 'text' => 1 ], 'name'=>'tire', 'unique' => true ],
			[ 'key' => [ 'list' => 1 ], 'name'=>'list','background'=>true],
		];
	?>
	var json = <?php echo json_encode($indexes); ?>;
	editor.set(json);


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
<div class="list">

</div>