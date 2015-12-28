<section id="dbList">
	<header>
		<h1>Database</h1>
	</header>
	<table>
		<thead>
			<tr>
				<th>name</th>
				<th>size</th>
				<th>action</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($dbList as $db): ?>
				<tr>
					<td><?php echo $this->link($db['name'],['action'=>'view','params'=>['name'=>$db['name']]]); ?></td>
					<td><?php echo $db['size']; ?></td>
					<td><?php echo $this->link('drop',['action'=>'drop','params'=>['name'=>$db['name']]],['onclick'=>"return confirm('Are you sure?')"]); ?></td>
				</tr>
			<?php endforeach ?>
		</tbody>
		<tfoot>
		</tfoot>
	</table>
	<footer>
	</footer>
</section>
