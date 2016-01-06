<section>
	<header>
		<h1>Database</h1>
	</header>
	<nav class="pages-menu">
		<ul>
			<li><?php echo $this->link('create database', ['controller'=>'database','action'=>'add'],['class'=>'btn-menu-database']);?></li>
		</ul>
	</nav>
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
					<td><?php echo $this->link($db->getName(),['action'=>'view','params'=>['name'=>$db->getName()]]); ?></td>
					<td><?php echo $this->Size->bytesToSize($db->getSizeOnDisk()); ?></td>
					<td><?php echo $this->link('drop',['action'=>'drop','params'=>['name'=>$db->getName()]],['onclick'=>"return confirm('Are you sure?')"]); ?></td>
				</tr>
			<?php endforeach ?>
		</tbody>
		<tfoot>
		</tfoot>
	</table>
	<footer>
	</footer>
</section>
