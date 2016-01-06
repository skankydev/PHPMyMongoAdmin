<section>
	<header><h1>Index: <?php echo $namespace; ?></h1> </header>
	<nav class="pages-menu">
		<ul>
			<li><?php echo $this->link('create Index', ['action'=>'add','params'=>['namespace'=>$namespace]],['class'=>'btn-menu']);?></li>
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
				<td><?php echo $index->getName(); ?></td>
				<td><?php echo json_encode($index->getKey(),JSON_PRETTY_PRINT); ?></td>
				<td><?php echo $index->isSparse()?'yes':'no'; ?></td>
				<td><?php echo $index->isTtl()?'yes':'no'; ?></td>
				<td><?php echo $index->isUnique()?'yes':'no'; ?></td>
				<td><?php echo $index->getVersion(); ?></td>
				<td><?php echo $this->link('drop', ['action'=>'drop','params'=>['namespace'=>$namespace,'index'=>$index->getName()]]);?></td>
			</tr>
			<?php endforeach ?>			
		</tbody>
	</table>
	<footer>
	</footer>
</section>