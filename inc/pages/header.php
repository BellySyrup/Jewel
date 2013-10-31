<!DOCTYPE html>
<html>

	<head>
	
		<title>Jewel Computer Brokers Inc.</title>
		
		<link rel="icon" type="image/png" href="./images/tab_logo.png" />
		<link rel="stylesheet" type="text/css" href="./css/theme.css" />
		
		<script type="text/javascript" src="./js/jquery.js"></script>
		<script type="text/javascript" src="./js/jquery.expander.js"></script>
		<script type="text/javascript" src="./js/various.js"></script>
		<script type="text/javascript" src="./js/slider.js"></script>
		
		<link href='http://fonts.googleapis.com/css?family=Antic+Slab' rel='stylesheet' type='text/css'/>

	</head>
	
	<body>
	
		<div id="wrapper">
		
			<div id="header">
			
				<? require_once("menu.php") ?>
				<? require_once("./inc/php/jewel.class.php"); ?>
				<? $oJewel = new Jewel(); ?>