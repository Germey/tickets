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
			$sql = "SELECT * FROM orders,seats WHERE phone = ? and orders.sid = seats.sid";
			$result = $this->db->query($sql,array($phone));
			return $result->result_array();
		}
		//购票成功。更新订单信息
		public function updateInfo($trade_no){
			$sql = "update orders set state = 1 where ";
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