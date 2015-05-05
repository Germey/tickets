		<!-- 版权 -->
		<div class="foot" id="foot">
			 <p>Copyright © 2015 济南大乘五蕴文化传媒有限公司</p>
			 <p>鲁ICP备15010888号</p>
		</div>
		<!-- 版权结束 -->
		<!-- validate -->
		<script src="<?php echo base_url();?>js/jquery.validate.js"></script>
		<!-- validate zh-CN -->
		<script src="<?php echo base_url();?>js/jquery.validate.messages_cn.js"></script>
		<!-- modal -->
		<script src="<?php echo base_url();?>js/bootstrap-modal.js"></script>
		<script>
		function getDelePic(){
			return '<?php echo base_url();?>images/delete.png';
		}
		function getWrongPic(){
			return '<?php echo base_url();?>images/wrong.png';
		}
		function getRightPic(){
			return '<?php echo base_url();?>images/right.png';
		}
		function getFindUrl(){
			return '<?php echo base_url();?>index.php/welcome/findInfo';
		}
		function getDeleteUrl(){
			return '<?php echo base_url();?>index.php/welcome/deleteOrder';
		}
		function getCheckCodeUrl(){
			return '<?php echo base_url();?>index.php/welcome/checkCode';
		}
		function getCheckPhoneCodeUrl(){
			return '<?php echo base_url();?>index.php/welcome/checkPhoneCode';
		}
		function getjudgeSeatUrl(){
			return '<?php echo base_url();?>index.php/welcome/judgeSeat';
		}
		function getPhoneCodeUrl(){
			return '<?php echo base_url();?>index.php/welcome/sendPhoneCode';
		}
		function getSeatPrice(rank){
			var price = 0;
			switch(rank){
				case 1:
					price = 0.01;
					break;
				case 2:
					price = 0.01;
					break;
				case 3:
					price = 0.01;
					break;
				default:
					price = 0.01;
					break;
			}
			return price;
		}
		</script>
    </body>
</html>