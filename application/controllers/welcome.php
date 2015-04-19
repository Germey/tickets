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
		require_once("phonepay/alipay.config.php");
		require_once("phonepay/lib/alipay_submit.class.php");
		$seats = @$_POST['seats'];
		$phone = $_POST['phone'];
		$name = $_POST['name'];
		$money = $_POST['money'];
		/**************************调用授权接口alipay.wap.trade.create.direct获取授权码token**************************/
		//返回格式
		$format = "xml";
		//必填，不需要修改

		//返回格式
		$v = "2.0";
		//必填，不需要修改

		//请求号
		$req_id = @date('Ymdhis');
		//必填，须保证每次请求都是唯一

		//**req_data详细信息**

		//服务器异步通知页面路径
		$notify_url = "http://shiyida.net:8080/ticket/phonepay/notify_url.php";
		//需http://格式的完整路径，不允许加?id=123这类自定义参数

		//页面跳转同步通知页面路径
		$call_back_url = "http://shiyida.net:8080/ticket/phonepay/call_back_url.php";
		//需http://格式的完整路径，不允许加?id=123这类自定义参数

		//操作中断返回地址
		$merchant_url = "http://shiyida.net:8080/ticket/phonepay/out.php";
		//用户付款中途退出返回商户的地址。需http://格式的完整路径，不允许加?id=123这类自定义参数

		//商户订单号:手机号码+时间戳组成唯一订单号
		$out_trade_no = $phone.time();
		//商户网站订单系统中唯一订单号，必填

		//订单名称：
		$subject = "pay for tickets";
		//必填

		//付款金额
		$total_fee = $money;
		//必填

		//请求业务参数详细
		$req_data = '<direct_trade_create_req><notify_url>' . $notify_url . '</notify_url><call_back_url>' . $call_back_url . '</call_back_url><seller_account_name>' . trim($alipay_config['seller_email']) . '</seller_account_name><out_trade_no>' . $out_trade_no . '</out_trade_no><subject>' . $subject . '</subject><total_fee>' . $total_fee . '</total_fee><merchant_url>' . $merchant_url . '</merchant_url></direct_trade_create_req>';
		//必填
		/************************************************************/

		//构造要请求的参数数组，无需改动
		$para_token = array(
				"service" => "alipay.wap.trade.create.direct",
				"partner" => trim($alipay_config['partner']),
				"sec_id" => trim($alipay_config['sign_type']),
				"format"	=> $format,
				"v"	=> $v,
				"req_id"	=> $req_id,
				"req_data"	=> $req_data,
				"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
		);

		//建立请求
		$alipaySubmit = new AlipaySubmit($alipay_config);
		$html_text = $alipaySubmit->buildRequestHttp($para_token);

		//URLDECODE返回的信息
		$html_text = urldecode($html_text);
		
		//解析远程模拟提交后返回的信息
		$para_html_text = $alipaySubmit->parseResponse($html_text);
		//获取request_token
		$request_token = $para_html_text['request_token'];
		//echo $request_token;
		/**************************根据授权码token调用交易接口alipay.wap.auth.authAndExecute**************************/

		//业务详细
		$req_data = '<auth_and_execute_req><request_token>' . $request_token . '</request_token></auth_and_execute_req>';
		//必填

		//构造要请求的参数数组，无需改动
		$parameter = array(
				"service" => "alipay.wap.auth.authAndExecute",
				"partner" => trim($alipay_config['partner']),
				"sec_id" => trim($alipay_config['sign_type']),
				"format"	=> $format,
				"v"	=> $v,
				"req_id"	=> $req_id,
				"req_data"	=> $req_data,
				"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
		);
		//建立请求
		$alipaySubmit = new AlipaySubmit($alipay_config);
		$html_text = $alipaySubmit->buildRequestForm($parameter, 'get', '确认');
		echo $html_text;
	}
}
