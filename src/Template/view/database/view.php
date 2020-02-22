<section id="CollectionList">
	<headder>
		<h1><?= $dbName; ?></h1>
		<nav class="pages-menu">
			<ul>
				<li><?= $this->link('create collection', ['controller'=>'database','action'=>'add','params'=>['dbName'=>$dbName]],['class'=>'btn-menu-collection']); ?></li>
			</ul>
		</nav>
	</headder>
	<table>
		<thead>
			<tr>
				<th>name</th>
				<th>size</th>
				<th>number</th>
				<th>action</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($collectionList as $collection): ?>
				<tr>
					<td>
						<?= $this->link($collection['name'],['controller'=>'collection', 'action'=>'index','params'=>['name'=> $dbName.'.'.$collection['name']]]); ?>
					</td>
					<td>
						<?= $collection['size'] ? $this->Size->bytesToSize($collection['size']) : '';?>
					</td>
					<td>
						<?= $collection['size']; ?>
					</td>
					<td>
					<?= $this->link('drop',
						['controller'=>'collection', 'action'=>'drop','params'=>['name'=> $dbName.'.'.$collection['name']]],
						['onclick'=>"return confirm('Are you sure?')"]
						); ?></td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
	<footer>
	</footer>
</section>
