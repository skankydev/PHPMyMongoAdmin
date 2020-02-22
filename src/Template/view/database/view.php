<section id="CollectionList">
	<headder>
		<h1><?php echo $dbName; ?></h1>
		<nav class="pages-menu">
			<ul>
				<li><?php echo $this->link('create collection', ['controller'=>'database','action'=>'add','params'=>['dbName'=>$dbName]],['class'=>'btn-menu-collection']); ?></li>
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
						<?php echo $this->link($collection->getName(),['controller'=>'collection', 'action'=>'index','params'=>['name'=> $dbName.'.'.$collection->getName()]]); ?>
					</td>
					<td>
						<?php if ($collection->getCappedSize()):
							echo $this->Size->bytesToSize($collection->getCappedSize());
						endif ?>
					</td>
					<td>
						<?php echo $collection->getCappedMax(); ?>
					</td>
					<td>
					<?php echo $this->link('drop',
						['controller'=>'collection', 'action'=>'drop','params'=>['name'=> $dbName.'.'.$collection->getName()]],
						['onclick'=>"return confirm('Are you sure?')"]
						); ?></td>
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>
	<footer>
	</footer>
</section>
