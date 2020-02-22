<section id="Import">
	<header>
		<h1>Import: <?= $myNamespace ?></h1>
	</header>
		<?= $this->Form->start($this->request->url(['action'=>'import','params'=>['namespace'=>$myNamespace]]),['enctype'=>"multipart/form-data"]); ?>
		<?= $this->Form->fieldset([
			'legend'  => ['content'=>'import json file'],
			'input'   => [
					'namespace' => ['type'=>'hidden','value'=>$myNamespace],
					'import'    => ['label'=>'json document','type'=>'file'],
				]
		]); ?>
		<?= $this->Form->submit('Send'); ?>
	<?= $this->Form->end(); ?>
	<footer>
		<h4>Data Generator</h4>
		<nav>
			<ul>
				<li><a href="https://www.mockaroo.com/" target="_blank">mockaroo</a></li>
			</ul>
		</nav>
	</footer>
	</footer>
</section>