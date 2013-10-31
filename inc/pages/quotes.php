<div id="quotes">
	<div id="quotesWrapper">
		<div id="quotesContent">
			<div id="slider">
				<ul>
				<?
					foreach($oJewel->grabTestimonialInfo() as $x){
						$quote = $x['text'];
						$author = $x['author'];
				?>
				<li>"<? echo $quote ?>" - <? echo $author ?></li>
				<?}?>
				</ul>
			</div>
		</div>
	</div>
</div>

