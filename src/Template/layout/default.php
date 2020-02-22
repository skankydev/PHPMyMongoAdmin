<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>PHP My Mongo Admin</title>
	<link rel="stylesheet" media="screen" type="text/css" href="/css/style.css" />
	<script type="text/javascript" src="/js/jquery-2.1.4.min.js"></script>
	<script type="text/javascript" src="/js/PHPMyMongoAdmin.js"></script>
	<?php echo $this->getHeader(); ?>
</head>
<body>
	<section id="Container">
		<header id="Header">
			<h1>PHP My Mongo Admin</h1><?php echo $this->element('menu'); ?>
		</header>
		<section class="layout-content">
		<?php echo $this->element('db-list'); ?>
		<section id="Contents">
			<section id="Flash-Message"><?php echo $this->FlashMessages->display(); ?></section>
				<?php echo $this->fetch('content'); ?>
			</section>
		</section>
		<footer id="Footer">
			<?php 
				$starttime = $_SERVER['REQUEST_TIME_FLOAT'];
				$endtime = microtime(true);
				$time = ($endtime-$starttime)*1000;
				$time = (int)$time;
			?>
			<span class="debug-time"><?php echo $time; ?> ms</span><br>
			<span>powered by <a href="https://github.com/skank" target="_blank">skank</a>.</span>
		</footer>
	</section>
	<?php echo $this->getScript(); ?>
</body>
</html>