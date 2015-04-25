$(function(){
	var colNum = 25;
	var money = 0;
	var findPhone = "";
	$(".seat-item").each(function(){
		if($(this).attr("state")==1){
			$(this).css("background-color","#888");
		}
	});
	$(".seat-item").on("touchend click",function(){
		if($(this).attr("state")==0){
			if($(this).attr("select")==0){
				$("#seat-choosen ul").append('<li id="selected-'+$(this).attr("row")+'-'+$(this).attr("col")+'" class="choosen-item">'+$(this).attr("row")+"排"+$(this).attr("col")+"座 ¥"+getSeatPrice($(this).attr("rank"))+'<span><img src='+getDelePic()+'></span></li>');
				$("#buy-form").append('<input type="hidden" id="hidden-'+$(this).attr("row")+'-'+$(this).attr("col")+'" value="'+((parseInt($(this).attr("row"))-1)*colNum + parseInt($(this).attr("col")))+'" name="seats[]">');
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
					$("#hidden-"+row+'-'+col).remove();
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
	/*$("#buy-form").validate({
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
	*/
	/* buy-form validate */
	$("#buy-form #sub").click(function(){
		function checkPhone(value){
			if((value.length != 11) || (!value.match(/^(13[0-9]|14[5|7]|15[0|1|2|3|5|6|7|8|9]|17[0|6|7|8]|18[0-9])\d{8}$/))){
				return false;
			 }else{
				return true;
			}
		}
		function checkName(value){     
			var containSpecial = RegExp(/[(\ )(\~)(\!)(\@)(\#)(\$)(\%)(\^)(\&)(\*)(\()(\))(\-)(\_)(\+)(\=)(\[)(\])(\{)(\})(\|)(\\)(\;)(\:)(\')(\")(\,)(\.)(\/)(\<)(\>)(\?)(\)]+/);      
			if(!containSpecial.test(value)&&value.length>=2){
				return true;
			}else{
				return false;
			}      
		}
		function checkTicket(){
			if($('#buy-form input[type="hidden"]').size()){
				return true;
			}else{
				return false;
			}
		}
		var phone = $("#buy-form #phone").val();
		phoneResult = checkPhone(phone);
		if(!phoneResult){
			$("#buy-form #phone").parent().next().children(".label").html("<img src="+getWrongPic()+">");
		}else{
			$("#buy-form #phone").parent().next().children(".label").html("<img src="+getRightPic()+">");
		}
		var name = $("#buy-form #name").val();
		nameResult = checkName(name);
		if(!nameResult){
			$("#buy-form #name").parent().next().children(".label").html("<img src="+getWrongPic()+">");
		}else{
			$("#buy-form #name").parent().next().children(".label").html("<img src="+getRightPic()+">");
		}
		ticketResult = checkTicket();
		if(!ticketResult){
			$("#mymodal").modal("show");
			$("#mymodal .modal-body p").html("请至少选择一个座位");
			$("#mymodal button").click(function(){
				$("#mymodal").modal("hide");
			});
		}
		if(phoneResult&&nameResult&&ticketResult){
			$("#buy-form").submit();
		}
	});
	/* find-form validate */
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
			$("#find-button").val("查询中请稍后");
			$.post(getFindUrl(),
			{"phone":$("#find-form #phone").val()},
			function(data){
				$("#find-result #bought p").html("已支付");
				$("#find-result #not-bought p").html("未支付");
				$(".none-result").hide();
				findPhone = $("#find-form #phone").val();
				$("#buy-again-form #phone").val($("#find-form #phone").val());
				$('#buy-again-form input.oids').remove();
				$("#find-button").val("查询");
				res = JSON.parse(data);
				$("#find-result ul div").remove();
				$("#find-result ul li").remove();
				$.each(res,function(index,info){
					if(index==0){
						$.each(info,function(i,content){
							$("#find-result #bought ul").append('<li>'+content["row"]+'排'+content['col']+'列</li>');
						});
						if(info.length==0){
							$("#find-result #bought p").append('<p class="none-result">没有相关信息</p>')
						}
					}else if(index==1){
						$.each(info,function(i,content){
							$.each(content,function(name,value){
								console.log(name);
								var li = $("<div></div>").addClass("items").appendTo($("#not-bought ul"));
								if(name=="oid"){
									var oid = $("<div></div>").addClass("oid").text(value).appendTo(li);
									$("<span></span>").html("订单号<br>").prependTo(oid);
									$('<input type="hidden" name="oid[]" class="oids">').val(value).appendTo($("#buy-again-form"));
								}else if(name=="sids"){
									$.each(value,function(i,sid){
										$("<div></div>").addClass("sid").text(Math.floor((sid/colNum+1))+"排"+sid%colNum+"列").appendTo(li);
									 });
								}
							});	
						});
						if(info.length>0){
							$("#again-group").show();
						}
						if(info.length==0){
							$("#find-result #not-bought p").append('<p class="none-result">没有相关信息</p>');
							$("#again-group").hide();
						}
					}
				});
			});
		}
	});
	/* end of find-form validate */
	/* buy-form validate */
	$("#buy-again-form #again-button").click(function(){
		function checkPhone(value){
			if((value.length != 11) || (!value.match(/^(13[0-9]|14[5|7]|15[0|1|2|3|5|6|7|8|9]|17[0|6|7|8]|18[0-9])\d{8}$/))){
				return false;
			 }else{
				return true;
			}
		}
		function checkName(value){     
			var containSpecial = RegExp(/[(\ )(\~)(\!)(\@)(\#)(\$)(\%)(\^)(\&)(\*)(\()(\))(\-)(\_)(\+)(\=)(\[)(\])(\{)(\})(\|)(\\)(\;)(\:)(\')(\")(\,)(\.)(\/)(\<)(\>)(\?)(\)]+/);      
			if(!containSpecial.test(value)&&value.length>=2){
				return true;
			}else{
				return false;
			}      
		}
		var phone = $("#buy-again-form #phone").val();
		/* if user change the form input by Browser */
		phoneResult = checkPhone(phone);
		/* if user change his phone by the input */
		checkPhoneChange = phone==findPhone;
		if(!phoneResult){
			$("#mymodal").modal("show");
			$("#mymodal .modal-body p").html("请输入正确的手机号");
			$("#mymodal button").click(function(){
				$("#mymodal").modal("hide");
			});
		}else if(!checkPhoneChange){
			$("#mymodal").modal("show");
			$("#mymodal .modal-body p").html("请不要更改手机号");
			$("#mymodal button").click(function(){
				$("#mymodal").modal("hide");
			});
		}
		var name = $("#buy-again-form #name").val();
		nameResult = checkName(name);
		if(!nameResult){
			$("#buy-again-form #name").parent().next().children(".label").html("<img src="+getWrongPic()+">");
		}else{
			$("#buy-again-form #name").parent().next().children(".label").html("<img src="+getRightPic()+">");
		}
		if(nameResult&&phoneResult){
			$("#buy-again-form").submit();
		}
	});
});

