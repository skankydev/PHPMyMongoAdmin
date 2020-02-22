<?php 	use PHPMyMongoAdmin\Model\Database; //c'est la fete du slip ! ?>
<aside id="SideBar">
	<?php 
		$manager = new Database('DataBase');
		$dbList = $manager->getDBList();
		echo $this->link('create database',['controller'=>'database','action'=>'add'],['class'=>'btn-creatdb']);
	?>
	<ul>
	<?php foreach ($dbList as $db): ?>
		<li class="db-list">
			<?php ob_start(); ?>
				<span class="db-name">
					<?php echo $db->getName(); ?>
				</span>
				<span class="db-size">
					<?php echo $this->Size->bytesToSize($db->getSizeOnDisk()); ?>
				</span>
			<?php $content = ob_get_clean(); ?>
			<?php echo $this->link($content, ['controller'=>'database','action'=>'view','params'=>['dbName'=>$db->getName()]],['class'=>'db-link']);?>
			<?php if(isset($this->request->params[0])):?>
			<?php 
				$name = $this->request->params[0];
				$name = explode('.', $name);
				$collectionList = [];
				if($name[0] === $db->getName()){
					$collectionList = $manager->getCollectionList($name[0]);
				}
			?>
			<ul>
				<?php foreach ($collectionList as $collection): ?>
					<li>
						<?php echo $this->link($collection->getName(),['controller'=>'collection', 'action'=>'index','params'=>['name'=>$name[0].'.'.$collection->getName()]],['class'=>'db-link-mini']); ?>
					</li>
				<?php endforeach ?>
			</ul>
			<?php endif ?>
			
		</li>
	<?php endforeach ?>
	</ul>
</aside>