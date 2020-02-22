<section>
	<header><h1>Index: <?= $myNamespace; ?></h1> </header>
	<nav class="pages-menu">
		<ul>
			<li><?= $this->link('create Index', ['action'=>'add','params'=>['namespace'=>$myNamespace]],['class'=>'btn-menu']);?></li>
		</ul>
	</nav>
	<table>
		<thead>
			<tr>
				<th>name</th>
				<th>key</th>
				<th>sparse</th>
				<th>Ttl</th>
				<th>Unique</th>
				<th>version</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($list as $index): ?>
			<tr>
				<td><?= $index->getName(); ?></td>
				<td><?= json_encode($index->getKey(),JSON_PRETTY_PRINT); ?></td>
				<td><?= $index->isSparse()?'yes':'no'; ?></td>
				<td><?= $index->isTtl()?'yes':'no'; ?></td>
				<td><?= $index->isUnique()?'yes':'no'; ?></td>
				<td><?= $index->getVersion(); ?></td>
				<td><?= $this->link('drop', ['action'=>'drop','params'=>['namespace'=>$myNamespace,'index'=>$index->getName()]]);?></td>
			</tr>
			<?php endforeach ?>			
		</tbody>
	</table>
	<footer>
	</footer>
</section>