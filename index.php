<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Userlist</title>
	
	<link rel="stylesheet" href="jstree/themes/default/style.min.css" />
	<link rel="stylesheet" type="text/css" href="index.css" media="screen" />
	
	<script src="js/jquery-2.1.1.min.js"></script>
	<script src="jstree/jstree.min.js"></script>
	<script src="js/index.js"></script>
	
	<?php 
	$scale = 1;
	if( isset($_GET['scale'])  &&  is_numeric($_GET['scale'])  &&  $_GET['scale'] > 0 ) {
		$scale = $_GET['scale'];
	}
	?>
	<style media="screen" type="text/css">
		html {
			transform: scale(<?= $scale ?>);
			transform-origin: 0 0;
		}
	</style>
	
	
</head>
<body>

<?php

require_once 'functions.inc.php';

$decoration = TRUE;
if(isset($_GET['decoration']) && $_GET['decoration'] === "0") {
	$decoration = FALSE;
}

// display type
$page = basename($_SERVER['PHP_SELF']);
if($decoration) {
	?>
	<a href="<?= $page ?>?displayType=ChannelTree">ChannelTree</a>
	<a href="<?= $page ?>?displayType=ChannelTreeUsers">ChannelTreeUsers</a>
	<a href="<?= $page ?>?displayType=ChannelTreeReduced">ChannelTreeReduced</a>
	<br/>
	<?php
}

?>
	<div id="jstree"></div>

<?php 
if($decoration) {
?>
	<button id="refresh">REFRESH</button>
<?php 
}
?>

</body>
</html>
