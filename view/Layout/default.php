<!DOCTYPE html>
<html>
<head>
	<!-- LOAD Bootstrap -->
	<link href="res/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">
	<link href="res/plugins/bootstrap/css/bootstrap-theme.css" rel="stylesheet">
	<title><?php echo $this->getTitle() ?></title>
</head>
<body>
	<?php $this->fetchElement('header'); 
	$this->fetchContent(); ?>
</body>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script type="text/javascript" src='res/plugins/bootstrap/js/bootstrap.js'></script>
</html>