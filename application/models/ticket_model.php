<?php
/*
 * Created on 2015-4-15
 * 票模型，与座位有关的所有数据库操作
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>
<?php
	class Ticket_model extends CI_Model{
		
		//构造方法
		function __construct(){
			parent::__construct();
			$this->load->database();
		}
		
		//查询已买的票的信息
		public function findInfo($phone){
			$result = array();
			$bought = array();
			$nbought = array();
			$bi = 0;
			$ni = 0;
			$i = 0;
			$sidSql = "select * from orders where phone = '$phone'";
			$sidResult = $this->db->query($sidSql);
			foreach($sidResult->result_array() as $sidItem){
				$sids = unserialize($sidItem['sid']);
				$state = $sidItem['state'];
				while(isset($sids[$i])){
					$seatSql = "select * from seats where sid = ".$sids[$i];
					$seatResult = $this->db->query($seatSql);
					$seatResult = $seatResult->result_array();
					if($state==1){
						$bought[$bi] = $seatResult[0];
						$bi++;
					}else if($state==0){
						$nbought[$ni] = $seatResult[0];
						$ni++;
					}
					$i++;
				}
			}
			$result[0] = $bought;
			$result[1] = $nbought;
			return $result;
		}
		//购票成功。更新订单信息
		public function updateInfo($trade_no){
			$sql = "update orders set state = 1 where oid = '$trade_no'";
			$result = mysql_query($sql);
			return  $result;
		}
		//插入订单信息
		public function insertOrder($order){
			$oid = $order['oid'];
			$phone = $order['phone'];
			$name = $order['name'];
			$state = $order['state'];
			$sid = $order['sid'];
			$sql = "INSERT INTO  `tickets`.`orders` (`oid` ,`phone` ,`name` ,`state` ,`sid`)
					VALUES ('$oid',  '$phone',  '$name',  '$state',  '$sid');";
			$result = $this->db->query($sql);
			return $result;
		}
	}