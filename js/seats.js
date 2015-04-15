$(function(){
	$(".seat-item").click(function(){
		if($(this).attr("select")==0){
			$("#seat-choosen ul").append('<li id="selected-'+$(this).attr("row")+'-'+$(this).attr("col")+'" class="choosen-item">'+$(this).attr("row")+"排"+$(this).attr("col")+"座"+'</li>');
			$(this).css("background-color","#E22");
			$(this).attr("select","1");
		}else if($(this).attr("select")==1){
			$(this).css("background-color","#FFF");
			$(this).attr("select","0");
			$("#seat-choosen ul #selected-"+$(this).attr("row")+"-"+$(this).attr("col")).remove();
		}
	});
	$(".group-name").click(function(){
		$(".group-names").hide();
		$("#"+$(this).attr("href")).show();
		$(".back").show();
	});
	$(".back").click(function(){
		$(".group-names").show();
		$(".groups:visible").hide();
		$(this).hide();
	});
	
});