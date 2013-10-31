var banana = 960;

$(document).ready(function(){
	setInterval(slider,5000);
});

function slider(){
	var limit = $("#slider li").length * 960;
	if(-banana > -limit){
		$("#slider").animate({left:-banana},1000);
		banana = banana += 960;
	} else{
		$("#slider").animate({left:0},1000);
		banana = 960;
	}
}