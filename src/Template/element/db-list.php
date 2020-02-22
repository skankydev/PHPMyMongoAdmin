<?php $dbList = new \PHPMyMongoAdmin\View\DbListMaker() ?>
<aside id="SideBar">
	<?= $this->link('create database',['controller'=>'database','action'=>'add'],['class'=>'btn-creatdb']); ?>
	<ul>
	<?php foreach($dbList as $key => $db): ?>
		<li class="db-list">
			<div class="db-link-wrapper">
				<span class="btn-show-collection">+</span>
				<?php ob_start(); ?>
					<span class="db-name">
						<?= $db['name']; ?>
					</span>
					<span class="db-size">
						<?= $this->Size->bytesToSize($db['size']); ?>
					</span>
				<?php $content = ob_get_clean(); ?>
				<?= $this->link($content, ['controller'=>'database','action'=>'view','params'=>['dbName'=>$db['name']]],['class'=>'db-link']);?>
			</div>
			<?php 
			if(isset($this->request->params[0])){
				$class = '';
				$name = $this->request->params[0];
				$name = explode('.', $name);
				if($name[0] === $db['name']){
					$class = 'open';
				}
			}
			?>
			<div class="db-collections-wrapper <?= $class ?>">
				<ul>
					<?php foreach ($db['collections'] as $collection): ?>
						<li>
							<?= $this->link($collection,['controller'=>'collection', 'action'=>'index','params'=>['name'=>$db['name'].'.'.$collection]],['class'=>'db-link-mini']); ?>
						</li>
					<?php endforeach ?>
				</ul>
			</div>
		</li>
	<?php endforeach ?>
	</ul>
</aside>