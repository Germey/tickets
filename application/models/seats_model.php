<?php
/*
 * Created on 2015-3-21
 * 座位模型，与座位有关的所有数据库操作
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php

	class Seats_model extends CI_Model{
		
		//构造方法
		 function __construct(){
			parent::__construct();
			$this->load->database();
		}
		
		//接受数据并插入数据
		public function getSeatsInfo(){
			//插入数据
			$sql = "select * from seats";
			$result = $this->db->query($sql);
			return $result->result_array();
		}
		
		//往数据库插入座位，仅供测试使用，危险！
		public function addSeats(){
			$count=0;
			for($i=1;$i<=20;$i++){
				for($j=1;$j<=25;$j++){
					$count++;
					if($i<=4) 
						$rank=1;
					else 
						$rank=2;
					$sql="insert into seats(sid,rank,row,col,state) values(".$count.",".$rank.",".$i.",".$j.",0)";
					$result = $this->db->query($sql);
					echo "第".$count."条,录入".$result==0?"失败":"成功";
				}
			}
		}
		
		
	}