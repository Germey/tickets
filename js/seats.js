$(function(){
	var colNum = 25;
	$(".seat-item").each(function(){
		if($(this).attr("state")==1){
			$(this).css("background-color","#888");
		}
	});
	$(".seat-item").click(function(){
		if($(this).attr("state")==0){
			if($(this).attr("select")==0){
				$("#seat-choosen ul").append('<li id="selected-'+$(this).attr("row")+'-'+$(this).attr("col")+'" class="choosen-item">'+$(this).attr("row")+"排"+$(this).attr("col")+"座"+'</li>');
				$("#buy-form").append('<input type="hidden" id="hidden-'+$(this).attr("row")+'-'+$(this).attr("col")+'" value="'+((parseInt($(this).attr("row"))-1)*colNum + parseInt($(this).attr("col"))-1)+'" name="seats[]">');
				$(this).css("background-color","#E22");
				$(this).attr("select","1");
			}else if($(this).attr("select")==1){
				$(this).css("background-color","#FFF");
				$(this).attr("select","0");
				$("#hidden-"+$(this).attr("row")+'-'+$(this).attr("col")).remove();
				$("#seat-choosen ul #selected-"+$(this).attr("row")+"-"+$(this).attr("col")).remove();
			}
		}
	})
	.mousemove(function(event){
		var y=10,x=20;
		$("#seat-tip").show().css({
			"display":"block",
			"top":event.pageY+y+"px",
			"left":event.pageX-x+"px"
		}).html("<p>"+$(this).attr("row")+"排"+$(this).attr("col")+"座</p>");
		if($(this).attr("state")==1){
			$("#seat-tip").html("<p>已售</p>");
		}
		event.stopPropagation();
	})
	.mouseout(function(event){
		$("#seat-tip").fadeOut(10);
		event.stopPropagation();
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
