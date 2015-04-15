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
		$("#find-button").click(function(){
			$.post("<?php echo base_url();?>"+"index.php/welcome/findInfo",
			{"phone":$("#find-form #phone").val()},
			function(data){
				res = JSON.parse(data);
				var strHTML = "";
				$.each(res,function(index,info){
					strHTML += info['sid'];
				});
				$("#find-result p").html(strHTML);
			});
		});
		</script>
    </body>
</html>