<section id="debug" class="hideaway">
	<header class="debug-btn-containe-master">
		<button class="btn-debug-master hideaway-btn">DEBUG</button>
	</header><br>
	<section class="widget-debug-list hideaway-list">
		<div class="widget-debug hideaway">
			<header class="debug-btn-containe">
				<button class="btn-debug hideaway-btn">Historique</button>
			</header>
			<section class="widget-debug-content">
				<?php echo $this->element('histories',$this->request->getHistories()); ?>
			</section>
		</div>
		<div class="widget-debug hideaway">
			<header class="debug-btn-containe">
				<button class="btn-debug hideaway-btn">Session</button>
			</header>
			<section class="widget-debug-content">
			<pre>
				<code>
					<?php debug($_SESSION); ?>
				</code>
			</pre>
			</section>
		</div>
	</section>
</section>
<!-- see you soon script -->