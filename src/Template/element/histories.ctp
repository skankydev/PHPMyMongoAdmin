<div id="browsing-history" class="list-history hideaway-list">
	<h2 class='title-history'>Historique</h2>
	<?php foreach ($histories as $history): ?>
	
	<div class="element-history hideaway">
		<header class="history-header">
			<button class="btn-history hideaway-btn"><?php echo $history['url']; ?></button>
		</header>
		<section class="history-information"> 
			<a href="<?php echo $history['url']; ?>" class="hideaway-btn"><?php echo $history['url']; ?></a>
			<br>
			<span class="tag warning"><?php echo $history['method']; ?></span>
			<span class="tag warning"><?php echo $history['direct']?'direct':'redirect'; ?></span>
		</section>
	</div>
	<?php endforeach ?>
	
</div>
