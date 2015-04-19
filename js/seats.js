$(function(){
	var colNum = 25;
	var money = 0;
	$(".seat-item").each(function(){
		if($(this).attr("state")==1){
			$(this).css("background-color","#888");
		}
	});
	$(".seat-item").click(function(){
		if($(this).attr("state")==0){
			if($(this).attr("select")==0){
				$("#seat-choosen ul").append('<li id="selected-'+$(this).attr("row")+'-'+$(this).attr("col")+'" class="choosen-item">'+$(this).attr("row")+"排"+$(this).attr("col")+"座 ¥"+getSeatPrice($(this).attr("rank"))+'<span><img src='+getDelePic()+'></span></li>');
				$("#buy-form").append('<input type="hidden" id="hidden-'+$(this).attr("row")+'-'+$(this).attr("col")+'" value="'+((parseInt($(this).attr("row"))-1)*colNum + parseInt($(this).attr("col"))-1)+'" name="seats[]">');
				$(this).css("background-color","#E22");
				$(this).attr("select","1");
				/* change money */
				money+=getSeatPrice($(this).attr("rank"));
				$("#total-money #price").text(money.toFixed(2));
				/* you must add its listener after you add choosen-item */
				$(".choosen-item img").click(function(){
					id = $(this).parents("li").attr("id");
					row = id.split('-')[1];
					col = id.split('-')[2];
					$("#seat-"+row+"-"+col).attr("select",0).css("background-color","#FFF");
					/* change money */
					money-=getSeatPrice($("#seat-"+row+"-"+col).attr("rank"));
					$("#total-money #price").text(money.toFixed(2));
					/* end of change money */
					$(this).parents("li").fadeOut("500").setTimeout(remove(),500);
				})
				.mouseenter(function(event){
					$(this).fadeTo("500",0.6);
					event.stopPropagation();
				})
				.mouseleave(function(event){
					$(this).fadeTo("500",0.1);
					event.stopPropagation();
				});
				/* end of choosen-item listener */
			}else if($(this).attr("select")==1){
				$(this).css("background-color","#FFF");
				$(this).attr("select","0");
				/* change money */
				money-=getSeatPrice($(this).attr("rank"));
				$("#total-money #price").text(money.toFixed(2));
				/* end of change money */
				$("#hidden-"+$(this).attr("row")+'-'+$(this).attr("col")).remove();
				/* remove seat-choosen li */
				$("#seat-choosen ul #selected-"+$(this).attr("row")+"-"+$(this).attr("col")).fadeOut("500").setTimeout(remove(),500);
			}
		}
	})
	/* add a tip to display seat number */
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
	/* fade out the tip */
	.mouseleave(function(event){
		$("#seat-tip").fadeOut(10);
		event.stopPropagation();
	});
	/* end of seat-item */
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
	$("#buy-form").validate({
		submitHandler:function(form){ 
			form.submit();
		},
		rules:{
			phone:{
				required:true,phone:true
			},
			name:{
				required:true,minlength:2
			}
		},
		errorPlacement:function(error,element){
			element.parent().next().children(".label").html="";
			error.appendTo(element.parent().next().children(".label"));
		},
		messages:{
			phone:{
				required:"<img src="+getWrongPic()+">",phone:"<img src="+getWrongPic()+">"
			},
			name:{
				required:"<img src="+getWrongPic()+">",minlength:"<img src="+getWrongPic()+">"
			}
		},
		success:function(label){
			label.html("<img src="+getRightPic()+">");
		}
	});
	$("#find-form").validate({
		debug:true,
		rules:{
			phone:{
				required:true,phone:true
			}
		},
		errorPlacement:function(error,element){
			element.parent().next().children(".label").html="";
			error.appendTo(element.parent().next().children(".label"));
		},
		messages:{
			phone:{
				required:"<img src="+getWrongPic()+">",phone:"<img src="+getWrongPic()+">"
			}
		},
		success:function(label){
			label.html("<img src="+getRightPic()+">");
			$.post(getFindUrl(),
			{"phone":$("#find-form #phone").val()},
			function(data){
				$("#find-result").html("<ul></ul>").prepend("<p>购票信息如下</p>");
				res = JSON.parse(data);
				$("#find-result ul li").remove();
				$.each(res,function(index,info){
					$("#find-result ul").append("<li>座号"+info['sid']+" "+info['row']+"排"+info['col']+"列</li>");
				});
				if(res.length==0){
					$("#find-result").append('<p class="none-result">没有相关信息</p>')
				}
			});
		}
	});
});

