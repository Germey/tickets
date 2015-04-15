<!DOCTYPE html>
<html lang="zh-CN">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>演唱会选座支付页面</title>   
        <!-- Bootstrap -->
        <link href="<?php echo base_url();?>css/bootstrap.min.css" rel="stylesheet">
		<link href="<?php echo base_url();?>css/style2.css" rel="stylesheet">   		
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>font-awesome/css/font-awesome.min.css" />
        <!--[if lt IE 9]>
			<script src="js/html5shiv.js"></script>
			<script src="js/respond.min.js"></script>
        <![endif]-->
        <script src="http://libs.baidu.com/jquery/1.10.2/jquery.min.js"></script>
        <script src="<?php echo base_url();?>js/bootstrap.min.js"></script> 
		
    </head>
    <body>
		<!-- 座位 -->
		<div id="seats" name="seats">
			<div class="container">
				<div id="stage" name="stage">
					舞台
				</div>
				<div class="row">
					<div class="col-sm-4 col-xs-12">
						<div class="side">
							<?php 
								for($i=1;$i<=20;$i++){
									for($j=1;$j<=7;$j++){
									?>
										<div class="seat-item" onclick="choose(<?php echo $i;?>,<?php echo $j;?>)"><i class="fa fa-user"></i></div>
										<?php 
										 if($j==7){
										?>
											<div class="clear"></div>
										<?php
										}
									}
								}
							?>
						</div>
					</div>
					<div class="col-sm-4 col-xs-12">
						<div class="middle">
							<?php 
								for($i=1;$i<=20;$i++){
									for($j=1;$j<=11;$j++){
									?>
										<div class="seat-item" onclick="choose(<?php echo $i;?>,<?php echo $j;?>)"><i class="fa fa-user"></i></div>
										<?php 
										 if($j==11){
										?>
											<div class="clear"></div>
										<?php
										}
									}
								}
							?>
						</div>
					</div>
					<div class="col-sm-4 col-xs-12">
						<div class="side">
							<?php 
								for($i=1;$i<=20;$i++){
									for($j=1;$j<=7;$j++){
									?>
										<div class="seat-item" onclick="choose(<?php echo $i;?>,<?php echo $j;?>)"><i class="fa fa-user"></i></div>
										<?php 
										 if($j==7||$j==18){
										?>
											<div class="clear"></div>
										<?php
										}
									}
								}
							?>
						</div>
					</div>
				</div>
				</div>
			</div>
		</div>
		<!-- 座位结束 -->
		<!-- 版权 -->
		<div class="foot">
			 Copyright © 2015  托管于 <a href="http://www.aliyun.com/">阿里云主机</a>  
		</div>
		<!-- 版权结束 -->
    </body>
</html>