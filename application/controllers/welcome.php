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
	function __construct(){
		parent::__construct();
		$this->load->helper("url");
		$this->load->model("seats_model","seats");
		$this->load->model("ticket_model","ticket");
		
	}
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
	
	//获得已支付的座位,测试使用
	private function getSeatsSaled(){
		$this->seats->getSeatsSaled();
	}

	//获得已经预定的座位,测试使用
	private function getSeatsOrdered(){
		$this->seats->getSeatsOrdered();
	}

	//获得座位信息
	public function loadSeats(){
		$this->load->model("seats_model","seats");
		$seatsInfo = $this->seats->getSeatsInfo();
		$getSeatsSaled = $this->seats->getSeatsSaled();
		$getSeatsOrdered = $this->seats->getSeatsOrdered();
		$info['seatsInfo'] = $seatsInfo;
		$info['getSeatsSaled'] = $getSeatsSaled;
		$info['getSeatsOrdered'] = $getSeatsOrdered;
		$this->load->view('seats',$info);
	}
	
	//往数据库插入座位接口，危险！仅供测试！
	private function addseats(){
		
		$this->seats->addSeats();
	}
	
	//查询买到的票的信息
	public function findInfo(){
		//$phone = $_POST['phone'];
		$phone = $_POST['phone'];
		$result = $this->ticket->findInfo($phone);
		echo json_encode($result);
	} 
	
	//提交订单
	public function pay(){
		/*下单页面
			完成功能：
			1.更新seats表相应座位的state(状态码：1)
			2.向订单表插入订单信息
		*/
		$seats = @$_POST['seats'];
		$phone = $_POST['phone'];
		$name = $_POST['name'];
		
		if(!($this->judgeSeat($seats))){
			echo "<a href='http://shiyida.net:8080/ticket/'>亲！有人在你之前选定该座位了哟！请您点击这里重新选座..</a>";
			return;
		}
		//得到支付总额；
		$money = $this->getTotalFee($seats);
		
		//获取token需要的各种参数
		$data['format'] = "xml";
		$data['v'] = "2.0";
		$data['reqId'] = @date('Ymdhis');
		$data['notifyUrl'] = "http://shiyida.net:8080/ticket/phonepay/notify_url.php";
		$data['callBackUrl'] = "http://shiyida.net:8080/ticket/index.php/welcome/callBack";
		$data['merchantUrl'] = "http://shiyida.net:8080/ticket/phonepay/out.php";
		$data['outTradNo'] = $phone.time();
		$data['subject'] = "pay for tickets";
		$data['totalFee'] = $money;
		//参数配置结束
		
		//向订单表插入订单信息
		$order['oid'] = $phone.time();
		$order['phone'] = $phone;
		$order['name'] = $name;
		$order['money'] = $money;
		$order['sid'] = serialize($seats);
		$order['state'] = 0;
		//订单失效时间
		$order['failTime'] = time()+60*45;
 		$this->ticket->insertOrder($order);
		//开始交易
		$this->doTrade($data);
	}
	
	//支付成功回调页面
	public function callBack(){
		/*支付成功返回页面
			完成功能：更新订单状态（状态码：1）
					 更新座位表状态(状态码:1)
		*/
		require_once("/var/www/ticket/phonepay/alipay.config.php");
		require_once("/var/www/ticket/phonepay/lib/alipay_notify.class.php");
		
		$alipayNotify = new AlipayNotify($alipay_config);
		$verify_result = $alipayNotify->verifyReturn();
		if($verify_result) {
			//更新订单状态,支付成功
			$out_trade_no = $_GET['out_trade_no'];
			$this->ticket->updateInfo($out_trade_no);
			//更新座位表信息；锁定已被订购座位
			$this->seats->updateInfo($out_trade_no);
			
			$this->load->view('success');
		}
		else {
			$this->load->view('fail');
		}
	}

	//根据授权码token调用交易接口alipay.wap.auth.authAndExecute
	public function doTrade($data){
		require_once("./phonepay/alipay.config.php");
		require_once("./phonepay/lib/alipay_submit.class.php");
		//请求业务参数详细
		$req_data = '<direct_trade_create_req><notify_url>' . $data['notifyUrl'] . '</notify_url><call_back_url>' . $data['callBackUrl'] . '</call_back_url><seller_account_name>' . trim($alipay_config['seller_email']) . '</seller_account_name><out_trade_no>' . $data['outTradNo'] . '</out_trade_no><subject>' . $data['subject'] . '</subject><total_fee>' . $data['totalFee'] . '</total_fee><merchant_url>' . $data['merchantUrl'] . '</merchant_url></direct_trade_create_req>';
		
		$para_token = array(
				"service" => "alipay.wap.trade.create.direct",
				"partner" => trim($alipay_config['partner']),
				"sec_id" => trim($alipay_config['sign_type']),
				"format"	=> $data['format'],
				"v"	=> $data['v'],
				"req_id"	=> $data['reqId'],
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
		
		$request_token = $para_html_text['request_token'];
	
		$req_data = '<auth_and_execute_req><request_token>' . $request_token . '</request_token></auth_and_execute_req>';
		
		$parameter = array(
				"service" => "alipay.wap.auth.authAndExecute",
				"partner" => trim($alipay_config['partner']),
				"sec_id" => trim($alipay_config['sign_type']),
				"format"	=> $data['format'],
				"v"	=> $data['v'],
				"req_id"	=> $data['reqId'],
				"req_data"	=> $req_data,
				"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
		);
		//建立请求
		$alipaySubmit = new AlipaySubmit($alipay_config);
		$html_text = $alipaySubmit->buildRequestForm($parameter, 'get', '确认');
		echo $html_text;
	}
	
	
	//支付失败重新支付页面
	public function payAgain(){
		//传递订单号（数组）；
		$order = $_POST['oid'];
		//判断是否合法
		for($i=0;$i<count($order);$i++){
			$orderMoney = $this->ticket->getMoney($order[$i]);
			if($orderMoney){
				//获取token需要的各种参数
				$data['format'] = "xml";
				$data['v'] = "2.0";
				$data['reqId'] = @date('Ymdhis');
				$data['notifyUrl'] = "http://shiyida.net:8080/ticket/phonepay/notify_url.php";
				$data['callBackUrl'] = "http://shiyida.net:8080/ticket/index.php/welcome/callBack";
				$data['merchantUrl'] = "http://shiyida.net:8080/ticket/phonepay/out.php";
				$data['outTradNo'] = $order[$i];
				$data['subject'] = "pay for tickets";
				$data['totalFee'] = $orderMoney;
				$this->doTrade($data);
			}
			else{
				echo "请求错误!";
				return;
			}
		}
	}
	private function getTotalFee($seats){
		$totalFee = $this->seats->getTotalFee($seats);
		return $totalFee;
	}
	private function judgeSeat($seats){
		$result = $this->seats->judgeSeat($seats);
		return $result;
	}
	//各种测试....
	public function test(){
		foreach (getallheaders() as $name => $value) {  
			echo "$name: $value\n";  
		}  
	}
}
