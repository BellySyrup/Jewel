<? require_once("./inc/pages/header.php"); ?>
<? require_once("./inc/pages/secondintro.php"); ?>
<? require_once("./inc/pages/quotes.php");?>
</div><!-- close header -->
<div id="contentWrapper">
<div id="content">
	<h1>Manufacturers<a id="resetPage" href="./manufacturers.php">View All</a></h1>
	
	<div id="alphabet">
		<?
			for ($i=65; $i<=90; $i++) {
				$x = chr($i);
				print "<a href=\"./manufacturers.php?alpha=$x\">$x</a>";
			}
		?>
	</div>
	<br />
	<div id="colLeft">
	<?	
		if(isset($_GET['alpha']))
		{
			$alpha=$_GET['alpha'];
			$manufacturers=$oJewel->grabAlphaManufacturerInfo($alpha);
		}
		else
		{
			$manufacturers=$oJewel->grabManufacturerInfo();
		}
		
		if(empty($manufacturers)){
			print("<div id='test' class='manuSpan'>There are currently no manufacturers that start with $alpha</div>");
		}
		else{
			foreach($manufacturers as $key=>$x){
			$id = $x['id'];
			$name = $x['name'];
			$phone_num = $x['phone_num'];
			$link = $x['link'];
			$image = $x['image'];
			$productType = $x['productType'];
			$letter = $name[0];
					
					if($name[0] != $oldName[0]){
						if($key > 0){
							echo "</div>";
						}
						echo "<div id=".$name[0]." class='manuSpan'><h5>".$name[0]."<div class='line'></div></h5>";
					}
					
	?>
		<!-- container with id of manufacturer-->
		
		
		<div id="manu<? echo $id; ?>" class="manu">
			<!-- name of manufacturer -->
				<div class="headingWrapper"><h3><? echo $name; ?></h3></div>
				<!-- image/logo for manufacturer with alt of name of manufacturer -->
				<div class="manuImgDiv"><img src="./images/manufacturers/<? echo $image; ?>" alt="<? echo $name; ?>" /></div>
			<!-- link for manufacturer support site -->
			<div class='contactWrapper'>
			
			<? 
				if($link !=""){echo "<a href=".$link.">Web Support</a><br />";} // only post web support link if it exists
				if($phone_num != ""){echo "Phone:".$phone_num;} 				// only post phone number if it exists
			?>
			
			</div>
			<div class="productHover">
				<h6><? echo $name; ?></h6>
				<ul>
					<?
						foreach($productType as $key=>$type){	
					
						echo "<a href='./products.php#product".$type."'><li>".$oJewel->getProductTypeName($type)."</li></a>";
					}?>
				</ul>
			</div>
		</div>
		
	<?
		 $oldName = $name;
		 }//ends foreach
		 }//ends else
	
	if(!empty($manufacturers))
	{?>
		</div>
	<?}?>
	</div>
	
	<div id="colRight" class="glanceAdjust">
		<h2>At a Glance</h2>
		<ul>
		<?
			if(empty($manufacturers)){
				print("<li>Nothing to Display</li>");
			}
			else{
				foreach($manufacturers as $x){
					$id = $x['id'];
					$name = $x['name'];
					$letter = $name[0];
					
					if($name[0] != $oldName[0]){

		?>
			<a href="#<? echo $name[0]; ?>"><li class="listHeader"><? echo $letter; ?></li></a>
		<?}?>
			
			<a href="#manu<? echo $id?>"><li class="listItem"><? echo $name; ?></li></a>
			
		<?	
					
				$oldName = $name;
				}
			}
		?>
		</ul>
	</div>
</div>
<? require_once("./inc/pages/footer.php"); ?>	