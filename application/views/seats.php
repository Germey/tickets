
<!-- 座位 -->
<div id="seats" name="seats">
	<div id="stage" name="stage">
		舞台
	</div>
	<div class="group-names">
		<div class="container">
			<div class="row">
				<div class="group-name" href="group-1">
					<p>左侧前方</p>
				</div>
				<div class="aside"></div>
				<div class="group-name" href="group-2">
					<p>中间前方</p>
				</div>
				<div class="aside"></div>
				<div class="group-name" href="group-3">
					<p>右侧前方</p>
				</div>
			</div>
			<div class="row">
				<div class="group-name" href="group-4">
					<p>左侧后方</p>
				</div>
				<div class="aside"></div>
				<div class="group-name" href="group-5">
					<p>中间后方</p>
				</div>
				<div class="aside"></div>
				<div class="group-name" href="group-6">
					<p>右侧后方</p>
				</div>
			</div>
		</div>
	</div>
	<div id="seats-container" name="seats-container">
		<div id="group-1" class="groups side" style="display:none;">
		<?php 
			//前面部分排数，后面部分排数，左边部分列数，中间列数，右边列数
			$row1=10;$row2=10;$col1=7;$col2=11;$col3=7;
			$rowSum=$row1+$row2;$colSum=$col1+$col2+$col3;
		?>
		<?php 
			for($i=1;$i<=$row1;$i++){
				for($j=1;$j<=$col1;$j++){ ?>
					<div id="seat-<?php echo $i;?>-<?php echo $j;?>" select="0" sid="<?php echo ($i-1)*$colSum+$j;?>" rank="<?php echo $seatsInfo[($i-1)*$colSum+$j-1]['rank'];?>" state="<?php echo in_array((($i-1)*$colSum+$j),$getSeatsSaled)?1:(in_array((($i-1)*$colSum+$j),$getSeatsOrdered)?2:0);?>" row="<?php echo $i;?>" col="<?php echo $j;?>" class="seat-item"><i class="fa fa-user"></i></div>	
					<?php if($j==7){?>
					<div class="clear"></div>
					<?php } 
				}
			} 
		?>
		</div>
		<div id="group-2" class="groups middle" style="display:none;">
		<?php 
			for($i=1;$i<=$row1;$i++){
				for($j=$col1+1;$j<=$col1+$col2;$j++){ ?>
					<div id="seat-<?php echo $i;?>-<?php echo $j;?>" select="0" sid="<?php echo ($i-1)*$colSum+$j;?>" rank="<?php echo $seatsInfo[($i-1)*$colSum+$j-1]['rank'];?>" state="<?php echo in_array((($i-1)*$colSum+$j),$getSeatsSaled)?1:(in_array((($i-1)*$colSum+$j),$getSeatsOrdered)?2:0);?>" row="<?php echo $i;?>" col="<?php echo $j;?>" class="seat-item"><i class="fa fa-user"></i></div>	
					<?php if($j==18){?>
					<div class="clear"></div>
					<?php }
				}
			} 
		?>
		</div>
		<div id="group-3" class="groups side" style="display:none;">
		<?php 
			for($i=1;$i<=$row1;$i++){
				for($j=$col1+$col2+1;$j<=$col1+$col2+$col3;$j++){ ?>
					<div id="seat-<?php echo $i;?>-<?php echo $j;?>" select="0" sid="<?php echo ($i-1)*$colSum+$j;?>" rank="<?php echo $seatsInfo[($i-1)*$colSum+$j-1]['rank'];?>" state="<?php echo in_array((($i-1)*$colSum+$j),$getSeatsSaled)?1:(in_array((($i-1)*$colSum+$j),$getSeatsOrdered)?2:0);?>"  row="<?php echo $i;?>" col="<?php echo $j;?>" class="seat-item"><i class="fa fa-user"></i></div>	
					<?php if($j==25){?>
					<div class="clear"></div>
					<?php } 
				}
			} 
		?>
		</div>
		<div id="group-4" class="groups side" style="display:none;">
		<?php 
			for($i=$row1+1;$i<=$row1+$row2;$i++){
				for($j=1;$j<=$col1;$j++){ ?>
					<div id="seat-<?php echo $i;?>-<?php echo $j;?>" select="0" sid="<?php echo ($i-1)*$colSum+$j;?>" rank="<?php echo $seatsInfo[($i-1)*$colSum+$j-1]['rank'];?>" state="<?php echo in_array((($i-1)*$colSum+$j),$getSeatsSaled)?1:(in_array((($i-1)*$colSum+$j),$getSeatsOrdered)?2:0);?>" row="<?php echo $i;?>" col="<?php echo $j;?>" class="seat-item"><i class="fa fa-user"></i></div>	
					<?php if($j==7){?>
					<div class="clear"></div>
					<?php } 
				}
			} 
		?>
		</div>
		<div id="group-5" class="groups middle" style="display:none;">
		<?php 
			for($i=$row1+1;$i<=$row1+$row2;$i++){
				for($j=$col1+1;$j<=$col1+$col2;$j++){ ?>
					<div id="seat-<?php echo $i;?>-<?php echo $j;?>" select="0" sid="<?php echo ($i-1)*$colSum+$j;?>" rank="<?php echo $seatsInfo[($i-1)*$colSum+$j-1]['rank'];?>" state="<?php echo in_array((($i-1)*$colSum+$j),$getSeatsSaled)?1:(in_array((($i-1)*$colSum+$j),$getSeatsOrdered)?2:0);?>"  row="<?php echo $i;?>" col="<?php echo $j;?>" class="seat-item"><i class="fa fa-user"></i></div>	
					<?php if($j==18){?>
					<div class="clear"></div>
					<?php } 
				}
			} 
		?>
		</div>
		<div id="group-6" class="groups side" style="display:none;">
		<?php 
			for($i=$row1+1;$i<=$row1+$row2;$i++){
				for($j=$col1+$col2+1;$j<=$col1+$col2+$col3;$j++){ ?>
					<div id="seat-<?php echo $i;?>-<?php echo $j;?>" select="0" sid="<?php echo ($i-1)*$colSum+$j;?>" rank="<?php echo $seatsInfo[($i-1)*$colSum+$j-1]['rank'];?>" state="<?php echo in_array((($i-1)*$colSum+$j),$getSeatsSaled)?1:(in_array((($i-1)*$colSum+$j),$getSeatsOrdered)?2:0);?>"  row="<?php echo $i;?>" col="<?php echo $j;?>" class="seat-item"><i class="fa fa-user"></i></div>	
					<?php if($j==25){?>
					<div class="clear"></div>
					<?php } 
				}
			} 
		?>
		</div>
	</div>
	<div class="back" style="display:none;">
		返回
	</div>
	<div id="seat-tip" class="seat-tip" style="display:none">
		<p>提示<p>
	</div>
	<div id="seat-choosen">
		<div class="container">
			<p>已选座位</p>
			<ul>
			</ul>
		</div>
	</div>
	<div id="personal-info">
		<div class="container">
			<div class="row">
				<div class="col-sm-6 col-xs-12">
					<form id="buy-form" action="<?php echo base_url();?>index.php/welcome/pay" method="post">
						<p>未购票者入口</p>
						<div class="form-item">
							<div class="form-input">
								<input type="text" class="form-control text" placeholder="手机号" name="phone" id="phone">
							</div>
							<div class="form-label">
								<div class="label"></div>
							</div>
						</div>
						<div class="form-item">
							<div class="form-input">
								<input type="text" class="form-control text" placeholder="预留姓名" name="name" id="name">
							</div>
							<div class="form-label">
								<div class="label"></div>
							</div>
						</div>
						<input type="text" name="money" hidden="true" value="0.01"> 
						<div id="total-money"><span>¥ <span><span id="price">0.00</span></div>
						<input type="button" class="btn btn-primary button" value="去支付" name="sub" id="sub">
					</form>
				</div>
				<div class="col-sm-6 col-xs-12">
					<form id="find-form">
						<p>已购票者查询</p>
						<div class="form-item">
							<div class="form-input">
								<input type="text" class="form-control text" placeholder="手机号" name="phone" id="phone">
							</div>
							<div class="form-label">
								<div class="label"></div>
							</div>
						</div>
						<input type="submit" class="btn btn-primary button" id="find-button" value="查询">
					</form>
					<div id="find-result">
						<ul></ul>
						<div id="bought">
							<p></p>
							<ul>
							</ul>
						</div>
						<form id="buy-again-form" action="<?php echo base_url();?>index.php/welcome/payAgain" method="post">
							<input type="hidden" class="form-control text"  name="phone" id="phone">
							<div id="not-bought">
								<p></p>
								<ul>
								</ul>
								<div id="again-group" style="display:none">
									<input type="button" class="btn btn-primary button" id="again-button"  value="重新支付">
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- 提示框 -->
	<div class="modal" id="mymodal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title">温馨提示</h4>
				</div>
				<div class="modal-body">
					<p>请至少选择一个座位</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary">确定</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	<!-- 提示框结束 -->
	<!-- 确认弹出窗内容 -->
	<div class="modal" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	    <div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title">温馨提示</h4>
				</div>
				<div class="modal-body">
					<p>确认要删除订单吗？</p>
				</div>
				<div class="modal-footer">
					<button type="button" id="cancel" class="btn btn-default" data-dismiss="modal">取消</button>
					<button type="button" id="yes" class="btn btn-primary">确认</button>
				</div>
			</div>
		</div>
	</div>
	<!-- 弹出框结束 -->
</div>
<!-- 座位结束 -->
