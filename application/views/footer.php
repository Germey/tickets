		<!-- 版权 -->
		<div class="foot">
			 Copyright © 2015  托管于 <a href="http://www.aliyun.com/">阿里云主机</a>  
		</div>
		<!-- 版权结束 -->
		<!-- validate -->
		<script src="<?php echo base_url();?>js/jquery.validate.js"></script>
		<!-- validate zh-CN -->
		<script src="<?php echo base_url();?>js/jquery.validate.messages_cn.js"></script>
		<script>
		$(function(){			
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
						required:"<img src=<?php echo base_url();?>images/wrong.png>",phone:"<img src=<?php echo base_url();?>images/wrong.png>"
					},
					name:{
						required:"<img src=<?php echo base_url();?>images/wrong.png>",minlength:"<img src=<?php echo base_url();?>images/wrong.png>"
					}
				},
				success:function(label){
					label.html("<img src=<?php echo base_url();?>images/right.png>");
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
						required:"<img src=<?php echo base_url();?>images/wrong.png>",phone:"<img src=<?php echo base_url();?>images/wrong.png>"
					}
				},
				success:function(label){
					label.html("<img src=<?php echo base_url();?>images/right.png>");
					$.post("<?php echo base_url();?>"+"index.php/welcome/findInfo",
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
		</script>
    </body>
</html>