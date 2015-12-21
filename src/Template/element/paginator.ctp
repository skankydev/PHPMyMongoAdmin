<?php $aClass = 'btn-paging'; ?>
<nav>
	<ul class="paging">
		<?php $class = $aClass; if($first==$prev) $class .= ' paging-disabled'; ?>	
		<li class="<?php echo $class ?>">
			<?php 
				$params['page'] = $first;
				echo $this->link('<<',['params'=>$params]); 
			?>
		</li>
		<?php $class = $aClass; if($page==$prev) $class .= ' paging-disabled'; ?>
		<li class="<?php echo $class ?>">
			<?php
			$params['page'] = $prev;
			echo $this->link('<',['params'=>$params]); ?>
		</li>
		<?php for ($i=$start; $i < $stop; ++$i): ?> 
			<?php $class = $aClass; if($i==$page) $class .= ' paging-current'; ?>	
			<li class="<?php echo $class; ?>">
				<?php 
				$params['page'] = $i;
				echo $this->link($i,['params'=>$params]); ?>
			</li>
		<?php endfor ?>
		<?php $class = $aClass; if($page==$next) $class .= ' paging-disabled'; ?>	
		<li class="<?php echo $class; ?>">
			<?php 
			$params['page'] = $next;
			echo $this->link('>',['params'=>$params]);
			?>
		</li>
		<?php $class = $aClass; if($last==$next) $class .= ' paging-disabled'; ?>	
		<li class="<?php echo $class; ?>">
			<?php
			$params['page'] = $last;
			echo $this->link('>>',['params'=>$params]); ?>
		</li>
	</ul>
</nav>