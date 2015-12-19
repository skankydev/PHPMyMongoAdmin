<?php $aClass = 'btn-paging'; ?>
<nav>
	<ul class="paging">
		<?php $class = $aClass; if($first==$prev) $class .= ' paging-disabled'; ?>	
		<li class="<?php echo $class ?>">
			<?php echo $this->link('<<',['params'=>['page'=>$first]]); ?>
		</li>
		<?php $class = $aClass; if($page==$prev) $class .= ' paging-disabled'; ?>
		<li class="<?php echo $class ?>">
			<?php echo $this->link('<',['params'=>['page'=>$prev]]); ?>
		</li>
		<?php for ($i=$start; $i < $stop; ++$i): ?> 
			<?php $class = $aClass; if($i==$page) $class .= ' paging-current'; ?>	
			<li class="<?php echo $class; ?>">
				<?php echo $this->link($i,['params'=>['page'=>$i]]); ?>
			</li>
		<?php endfor ?>
		<?php $class = $aClass; if($page==$next) $class .= ' paging-disabled'; ?>	
		<li class="<?php echo $class; ?>">
			<?php echo $this->link('>',['params'=>['page'=>$next]]); ?>
		</li>
		<?php $class = $aClass; if($last==$next) $class .= ' paging-disabled'; ?>	
		<li class="<?php echo $class; ?>">
			<?php echo $this->link('>>',['params'=>['page'=>$last]]); ?>
		</li>
	</ul>
</nav>