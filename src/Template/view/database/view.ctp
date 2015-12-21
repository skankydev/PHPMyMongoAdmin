<section id="CollectionList">
	<headder><h1><?php echo $dbName; ?></h1></headder>
	<table>
		<thead>
			<tr>
				<th>name</th>
				<th>size</th>
				<th>action</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($collectionList as $collection): ?>
				<tr>
					<td><?php echo $this->link($collection->getName(),['controller'=>'collection', 'action'=>'index','params'=>['name'=> $dbName.'.'.$collection->getName()]]); ?></td>
					<td><?php echo $collection->getCappedSize( ); ?></td>
					<td>
					<?php echo $this->link('drop',
						['controller'=>'collection', 'action'=>'drop','params'=>['name'=> $dbName.'.'.$collection->getName()]],
						['onclick'=>"return confirm('Are you sure?')"]
						); ?></td>
				</tr>
			<?php endforeach ?>
		</tbody>
		<tfoot>
		</tfoot>
	</table>
	<footer>
	</footer>
</section>
