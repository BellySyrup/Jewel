$(document).ready(function(){
		
		checkPage();
		readMore();
		//manufacturer hover function
		$(".manu").hover(function(){
		
			$(".productHover",this).css({display:'block'});
		
		},function(){
			
			$(".productHover",this).css({display:'none'});
		
		});
		
		//home large links hover function
		$(".homeTeasers").each(function(){
			$(this).hover(function(){
				$(this).find('p').css({opacity:'.8'});
				$(this).find('img').css({opacity:'.75'});
				$(this).find('h1').css({opacity:'.60'});
			},function(){
				$(this).find('p').css({opacity:'1'});
				$(this).find('img').css({opacity:'1'});
				$(this).find('h1').css({opacity:'1'});
			});
		});
});

function checkPage()
{
	curPage=window.location.pathname;
	
	$("#nav a").each(function() {
		if(curPage=="/jewel/"+$(this).attr('name')+".php")
		{	
			$(this).css({color: "#a80532"});
		}
		else
		{
			$(this).css({color: "#FFF"});
		}
	});
}

function readMore()
{

	$.expander.defaults.slicePoint = 120;

	$(document).ready(function() {

	  $('div.expandable p').expander();

	});
}