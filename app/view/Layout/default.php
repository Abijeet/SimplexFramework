<!DOCTYPE html>
<html lang="en">
<head>	
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="<?php echo Router::getURL('res') ?>js/bootstrap/css/bootstrap.css" rel="stylesheet">
	<link href="<?php echo Router::getURL('res') ?>js/bootstrap/css/bootstrap-theme.css" rel="stylesheet">
	<link href="<?php echo Router::getURL('res') ?>css/styles.css" rel="stylesheet">
	<title><?php echo $this->getTitle() ?></title>
</head>
<body class="med-width">
	<?php $this->fetchElement('header'); ?>
	<div class="container-fluid main">
	<?php 		
		$this->fetchContent(); 
	?>
	</div>
	<?php $this->fetchElement('footer'); ?>
</body>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript" src='<?php echo Router::getURL('res') ?>js/bootstrap/js/bootstrap.js'></script>
</html>