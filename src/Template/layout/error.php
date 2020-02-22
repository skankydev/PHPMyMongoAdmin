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
			<h1>PHP My Mongo Admin</h1>
			<?php echo $this->element('menu'); ?>
		</header>
		<section id="Error">
			<?php echo $this->FlashMessages->display(); ?>
			<?php echo $this->fetch('content'); ?>
		</section>
		<footer id="Footer">
			<span>application realiser par <a class="mailto" href="mailto:simon.schenck@gmail.com">skank</a>.</span>
			<?php 
				$starttime = $_SERVER['REQUEST_TIME_FLOAT'];
				$endtime = microtime(true);
				$time = ($endtime-$starttime)*1000;
				$time = (int)$time;
			?>
			<br>
			<span class="debug-time"><?php echo $time; ?> ms</span>
		</footer>
	</section>
	<?php echo $this->getScript(); ?>

</body>
</html>