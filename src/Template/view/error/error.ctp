<section>
	<header>
		<h1>Error</h1>
		<span class="legend"><?php echo $controller.'/'.$action ?></span>
	</header>
	<section>
		<header>
			<h2><?php echo $error->getCode().': '.$error->getMessage(); ?></h2>
			<span class="legend"><?php echo get_class($error); ?></span>		
		</header>
		<div class="liste-trace">
			<?php foreach ($traces as $value): ?>
				<div class="trace">
					<div>
						<div class="trace-file"><?php echo isset($value['file'])?$value['file']:''; ?></div>
						<div class="trace-line"><?php echo isset($value['line'])?': '.$value['line']:''; ?></div>
					</div>
					<div class="hideaway">
						<div class="hideaway-btn">
							<div class="trace-class"><?php echo isset($value['class'])?$value['class']:''; ?></div>
							<div class="trace-type"><?php echo isset($value['type'])?$value['type']:''; ?></div>
							<div class="trace-function"><?php echo isset($value['function'])?$value['function']:''; ?>
							(<?php echo (!empty($value['args']))?'$arg['.count($value['args']).']':'' ; ?>)</div>							
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
					<dt><?php echo $key; ?></dt>
					<dd><?php echo $value; ?></dd>					
				<?php endif ?>
			<?php endforeach ?>
			</dl>
		</section>
	<?php endif ?>

	<footer>
		
	</footer>
</section>
