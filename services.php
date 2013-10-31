<? require_once("./inc/pages/header.php"); ?>
<? require_once("./inc/pages/secondintro.php"); ?>
<? require_once("./inc/pages/quotes.php");?>
</div><!-- close header -->
<div id="contentWrapper">
<div id="content">
	<h1>Services</h1>
	<div id="colLeft">
	<?
		foreach($oJewel->grabServiceInfo() as $x){
			$id = $x['id'];
			$name = $x['name'];
			$description = $x['description'];
			$image = $x['image'];
	?>
		<div class="services" id="service<? echo $id;?>">
			<h2><li><? echo $name;?></li></h2>
			<p><? echo $description;?></p>
			<img src="./images/services/<? echo $image;?>" alt="<? echo $name;?>" />
		</div>
	<?}?>
	</div>
	<div id="colRight">
		<h2>At a Glance</h2>
		<ul>
		<?
			foreach($oJewel->grabServiceInfo() as $x){
				$id = $x['id'];
				$name = $x['name'];
		?>
			<a href="#service<? echo $id?>"><li class="listItem"><? echo $name; ?></li></a>
		<?}?>
		</ul>
		<hr />
	</div>
</div>
</div>
<? require_once("./inc/pages/footer.php"); ?>	