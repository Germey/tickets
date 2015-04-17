<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	
	//加载主界面
	public function index(){
		$this->loadHeader();
		$this->load->view('carousel');
		$this->load->view('intro');
		$this->loadSeats();
		$this->loadFooter();
	}
	
	//加载头部
	function loadHeader(){
		$this->load->view('header');
		$this->load->view('menubar');
	}
	
	//加载尾部
	function loadFooter(){
		$this->load->view('footer');
	}
	
	//优惠券界面
	public function coupon(){
		$this->load->view('coupon');
	}
	
	//获得座位信息
	public function loadSeats(){
		$this->load->model("seats_model","seats");
		$seatsInfo = $this->seats->getSeatsInfo();
		$info['seatsInfo'] = $seatsInfo;
		$this->load->view('seats',$info);
	}
	
	//往数据库插入座位接口，危险！仅供测试！
	private function addseats(){
		$this->load->model("seats_model","seats");
		$this->seats->addSeats();
	}
	//查询买到的票的信息
	public function findInfo(){
		$phone = $_POST['phone'];
		$this->load->model("ticket_model","ticket");
		$result = $this->ticket->findInfo($phone);
		echo json_encode($result);
	}
	
	public function getSeats(){
		$seats = @$_POST['seats'];
		$phone = $_POST['phone'];
		$name = $_POST['name'];
		var_dump($seats);
		var_dump($phone);
	}
	
}
