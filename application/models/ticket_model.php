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
			date_default_timezone_set('PRC');
		}
		
		//查询已买的票的信息
		public function findInfo($phone){
			$result = array();
			$bought = array();
			//oid which are not bought
			$nbought = array();
			$bi = 0;
			$ni = 0;
			$time = time();
			//and (( 
			$sidSql = "select * from orders where phone = '$phone' and state=1";
			$sidResult = $this->db->query($sidSql);
			foreach($sidResult->result_array() as $sidItem){
				$sids = unserialize($sidItem['sid']);
				$state = $sidItem['state'];
				foreach($sids as $sid){
					$seatSql = "select * from seats where sid = ".$sid;
					$seatResult = $this->db->query($seatSql);
					$seatResult = $seatResult->result_array();
					$bought[$bi] = $seatResult[0];
					$bi++;
				}
			}
			$nboughtSql = "select * from orders where phone = '$phone' and fail_time > $time and state = 0";
			$nboughtRes = $this->db->query($nboughtSql)->result_array();
			foreach($nboughtRes as $item){
				$res=array();
				$sids = unserialize($item['sid']);
				$res['oid']=$item['oid'];
				$res['sids']=$sids;
				$res['fail_time']= date("Y-m-d H:i:s",$item['fail_time']);
				$res['money']=$item['money'];
				$nbought[$ni]=$res;
				$ni++;
			}
			$result[0] = $bought;
			$result[1] = $nbought;
			return $result;
		}
		
		//删除订单
		public function deleteOrder($id){
			$sql = "delete from orders where oid = '$id'";
			$result = mysql_query($sql);
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
			$failTime = $order['failTime'];
			$money = $order['money'];
			$sql = "INSERT INTO  `tickets`.`orders` (`oid` ,`phone` ,`name` ,`state` ,`sid`,`fail_time`,`money`)
					VALUES ('$oid',  '$phone',  '$name',  '$state',  '$sid','$failTime','$money');";
			$result = $this->db->query($sql);
			return $result;
		}
		//返回订单号和订单金额,在重新支付页面使用
		public function getMoney($order){
			$sql = "select money,state,fail_time from orders where oid = '$order'";
			
			$moneyResult = $this->db->query($sql);
			$result = $moneyResult->result_array();
			if(empty($result))
				return false;
			else{
				foreach($result as $resultItem)
					if(($resultItem['state'] == 1) || ($resultItem['fail_time']<time()))
						return false;
					else
						return $resultItem['money'];
			}
			
		}
	}
