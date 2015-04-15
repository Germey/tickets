
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
			for($i=1;$i<=10;$i++){
				for($j=1;$j<=7;$j++){ ?>
					<div id="seat-<?php echo $i;?>-<?php echo $j;?>" select="0" row="<?php echo $i;?>" col="<?php echo $j;?>" class="seat-item"><i class="fa fa-user"></i></div>	
					<?php if($j==7){?>
					<div class="clear"></div>
					<?php } 
				}
			} 
		?>
		</div>
		<div id="group-2" class="groups middle" style="display:none;">
		<?php 
			for($i=1;$i<=10;$i++){
				for($j=8;$j<=18;$j++){ ?>
					<div id="seat-<?php echo $i;?>-<?php echo $j;?>" select="0" row="<?php echo $i;?>" col="<?php echo $j;?>" class="seat-item"><i class="fa fa-user"></i></div>	
					<?php if($j==18){?>
					<div class="clear"></div>
					<?php }
				}
			} 
		?>
		</div>
		<div id="group-3" class="groups side" style="display:none;">
		<?php 
			for($i=1;$i<=10;$i++){
				for($j=19;$j<=25;$j++){ ?>
					<div id="seat-<?php echo $i;?>-<?php echo $j;?>" select="0" row="<?php echo $i;?>" col="<?php echo $j;?>" class="seat-item"><i class="fa fa-user"></i></div>	
					<?php if($j==25){?>
					<div class="clear"></div>
					<?php } 
				}
			} 
		?>
		</div>
		<div id="group-4" class="groups side" style="display:none;">
		<?php 
			for($i=11;$i<=20;$i++){
				for($j=1;$j<=7;$j++){ ?>
					<div id="seat-<?php echo $i;?>-<?php echo $j;?>" select="0" row="<?php echo $i;?>" col="<?php echo $j;?>" class="seat-item"><i class="fa fa-user"></i></div>	
					<?php if($j==7){?>
					<div class="clear"></div>
					<?php } 
				}
			} 
		?>
		</div>
		<div id="group-5" class="groups middle" style="display:none;">
		<?php 
			for($i=11;$i<=20;$i++){
				for($j=8;$j<=18;$j++){ ?>
					<div id="seat-<?php echo $i;?>-<?php echo $j;?>" select="0" row="<?php echo $i;?>" col="<?php echo $j;?>" class="seat-item"><i class="fa fa-user"></i></div>	
					<?php if($j==18){?>
					<div class="clear"></div>
					<?php } 
				}
			} 
		?>
		</div>
		<div id="group-6" class="groups side" style="display:none;">
		<?php 
			for($i=11;$i<=20;$i++){
				for($j=19;$j<=25;$j++){ ?>
					<div id="seat-<?php echo $i;?>-<?php echo $j;?>" select="0" row="<?php echo $i;?>" col="<?php echo $j;?>" class="seat-item"><i class="fa fa-user"></i></div>	
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
					<form action="" method="post">
						<p>未购票者入口</p>
						<input type="text" class="form-control text" placeholder="手机号">
						<input type="text" class="form-control text" placeholder="姓名">
						<input type="button" class="btn btn-primary button" value="去支付">
					</form>
				</div>
				<div class="col-sm-6 col-xs-12">
					<div class="find-ticket">
						<p>已购票者查询</p>
						<input type="text" class="form-control text" placeholder="手机号">
						<input type="button" class="btn btn-primary button" value="查询">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- 座位结束 -->
