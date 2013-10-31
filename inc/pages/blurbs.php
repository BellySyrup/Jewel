<div id="blurbs">
	<div id="blurbContent">
	
		<?
			foreach($oJewel->grabHomeInfo() as $x){
				$blurbtitle = $x['title'];
				$blurbtext = $x['text'];
				$blurbimage =$x['image'];
		?>
		<div class="blurb">
			<h3><? echo $blurbtitle ?></h3>
			<img class="blurbimg" src="./images/home_info/<? echo $blurbimage ?>" alt="<? echo $blurbtitle ?> image"/>
			<p class="blurbp"><? echo $blurbtext ?></p>
			
		</div>
		<?}?>

	</div>
</div>