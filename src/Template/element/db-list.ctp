<?php 	use PHPMyMongoAdmin\Model\MyManager; ?>
<aside id="SideBar">
	<?php 
		$manager = new MyManager();
		$dbList = $manager->getDBList();
		echo $this->link('creat database',['controller'=>'database','action'=>'add'],['class'=>'btn-creatdb']);
	?>
	<ul>
	<?php foreach ($dbList as $db): ?>
		<li class="db-list">
			<span class="db-name">
				<?php echo $db['name']; ?>
			</span>
			<span class="db-size">
			<?php if (!$db['empty']): ?>
				<?php echo $db['size']; ?>
			<?php else: ?>
				empty
			<?php endif ?>
			</span>
		</li>
	<?php endforeach ?>
	</ul>
</aside>