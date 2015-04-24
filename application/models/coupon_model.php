<?php
class Coupon_model extends CI_Model{
	var $mysql;
	public function __construct(){
		parent::__construct();
		include_once("mysql.class.php");
		$this->mysql = new mysql();
		$config['dbhost'] = 'localhost';
		$config['dbuser'] = 'root';
		$config['dbpsw'] = 'houlaoshi';
		$config['dbname'] = 'tickets';
		$config['dbcharset'] = 'utf8';
		$this->mysql->connect($config);
	}
	public function getyhm(){
		$sql_count = "select count(value) from coupon where state=0";
		$num = $this->mysql->query($sql_count);
		$i = mt_rand()%$num;
		$j = $i+1;
		$sql = "select value from coupon where state=0 limit $i,$j";
		$res = $this->mysql->query($sql);
		return $this->mysql->findOne($res);
	}
}
?>