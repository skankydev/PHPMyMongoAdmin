<section>
	<header>
		<h1>Error</h1>
		<span class="legend"><?= $controller.'/'.$action ?></span>
	</header>
	<section>
		<header>
			<h2><?= $error->getCode().': '.$error->getMessage(); ?></h2>
			<span class="legend"><?= get_class($error); ?></span>		
		</header>
		<div class="liste-trace">
			<?php foreach ($traces as $value): ?>
				<div class="trace">
					<div>
						<div class="trace-file"><?= isset($value['file'])?$value['file']:''; ?></div>
						<div class="trace-line"><?= isset($value['line'])?': '.$value['line']:''; ?></div>
					</div>
					<div class="hideaway">
						<div class="hideaway-btn">
							<div class="trace-class"><?= isset($value['class'])?$value['class']:''; ?></div>
							<div class="trace-type"><?= isset($value['type'])?$value['type']:''; ?></div>
							<div class="trace-function"><?= isset($value['function'])?$value['function']:''; ?>
							(<?= (!empty($value['args']))?'$arg['.count($value['args']).']':'' ; ?>)</div>							
						</div>
						<section class="trace-args"> 
							<?php if (!empty($value['args'])): ?>
								<?php debug($value['args'],' '); ?>
							<?php endif ?>		
						</section>
					</div>
				</div>
			<?php endforeach ?>	
		</div>
	</section>
	<?php if (isset($info)): ?>
		<section class="moreinfo">
			<header>
				<h2>more information</h2>
			</header>
			<dl>
			<?php foreach ($info as $key => $value): ?>
				<?php if (!is_array($value)||!is_object($value)): ?>
					<dt><?= $key; ?></dt>
					<dd><?= $value; ?></dd>					
				<?php endif ?>
			<?php endforeach ?>
			</dl>
		</section>
	<?php endif ?>

	<footer>
		
	</footer>
</section>
