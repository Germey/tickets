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
	public $time = 30;

	function __construct(){
		//10分钟后过期
		session_start(600);
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
	
	public function getCode(){
		require_once(APPPATH."third_party/code.class.php");
		$code=new Code(80, 30, 4);
		$code->showImage();   //输出到页面中供 注册或登录使用
		$_SESSION["code"]=$code->getCheckCode();  //将验证码保存到服务器中
	} 

	//判断验证码是否正确
	public function checkCode(){
		$code = $_POST['checkcode'];
		$sessionCode = $_SESSION["code"];
		//不区分大小写比较验证码
		if(strcasecmp($code,$sessionCode)==0){
			echo 1;
		}else{
			echo 0;
		}
	}

	//判断手机验证码是否正确
	public function checkPhoneCode(){
		$code = $_POST['phonecode'];
		$sessionPhoneCode = $_SESSION["phonecode"];
		//不区分大小写比较验证码
		if(strcasecmp($code,$sessionPhoneCode)==0){
			echo 1;
		}else{
			echo 0;
		}
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
	private  function getSeatsSaled(){
		$this->seats->getSeatsSaled();
	}

	//创建随机手机验证码
	private function createCode(){
		$code="1234567890";
		$string='';
		//从字符串中取出随机的字符
		for($i=0; $i < 6; $i++){
			$char=$code{rand(0, strlen($code)-1)};
			$string.=$char;
		}
		//返回字符内容
		return $string;
	}

	//发送手机验证码
	public function sendPhoneCode(){
		require_once(APPPATH."third_party/phone.class.php");
		$phonecode = new PhoneCode();
		//$phone = "15153173902";
		$phone = $_POST["phone"];
		$checkcode = $_POST["checkcode"];
		if(strcasecmp($checkcode,$_SESSION['code'])!=0){
			//验证码不正确
			echo "2";
			return;
		}
		$code = $this->createCode();
		$_SESSION['phonecode'] = $code;
		$url = "http://open.bizapp.com/api/sms/templateSend";
		$param="appId=F0000036&tpId=2029158&customerId=C1012422&userId=U1013951&password=CQCcqc123&phones=".$phone."&fields=选票支付系统||".$code."||5分钟内||大乘五蕴文化传媒";
		$gbkparam = iconv("UTF-8","GBK//TRANSLIT",$param);
		$result = $phonecode->postSend($url,$gbkparam);
		//正则表达式匹配
		$pattern="/\<resultcode\>(.*)\<\/resultcode\>/i";
		if(preg_match($pattern, $result, $arr)){
			//如果状态码为1，发送成功
			if($arr[1]="100"){
				echo "1";
			}else{
				echo "0";
			}
		}else{
			echo "0";
		}
	}

	//获得已经预定的座位,测试使用
	private function getSeatsOrdered(){
		$this->seats->getSeatsOrdered();
	}

	//删除订单
	public function deleteOrder(){
		$id=$_POST['id'];
		$result = $this->ticket->deleteOrder($id);
		if($result){
			echo "1";
		}else{
			echo "0";
		}
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
		$phone = htmlspecialchars($_POST['phone']);
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
		$phone = htmlspecialchars($_POST['phone']);
		$name = htmlspecialchars($_POST['name']);
		$code = htmlspecialchars($_POST['checkcode']);
		$session_code = $_SESSION["code"];
		$phoneCode = htmlspecialchars($_POST['phonecode']);
		if(!empty($seats) && !empty($phone) && !empty($name) && (strcasecmp($code,$session_code)==0) && ($_SESSION['phonecode']==$phoneCode)){
			//得到支付总额；
			$money = $this->getTotalFee($seats);
			//获取token需要的各种参数
			$data['format'] = "xml";
			$data['v'] = "2.0";
			$data['reqId'] = @date('Ymdhis');
			$data['notifyUrl'] = "http://shiyida.net:8080/ticket/index.php/welcome/notify";
			$data['callBackUrl'] = "http://shiyida.net:8080/ticket/index.php/welcome/callBack";
			$data['merchantUrl'] = "http://shiyida.net:8080/ticket/phonepay/fail.php";
			$data['outTradNo'] = $phone.time();
			$data['subject'] = "李政军演唱会门票";
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
	}
	
	//支付成功回调页面
	public function callBack(){
		/*支付成功返回页面
			完成功能：更新订单状态（状态码：1）
					 更新座位表状态(状态码:1)
		*/
		require_once(APPPATH."../phonepay/alipay.config.php");
		require_once(APPPATH."../phonepay/lib/alipay_notify.class.php");
		
		$alipayNotify = new AlipayNotify($alipay_config);
		$verify_result = $alipayNotify->verifyReturn();
		if($verify_result) {
			//更新订单状态,支付成功
			$out_trade_no = $_GET['out_trade_no'];
			$this->ticket->updateInfo($out_trade_no);
			//更新座位表信息；锁定已被订购座位
			$this->seats->updateInfo($out_trade_no);
			$this->sendSuccessMsg($out_trade_no);
			$this->load->view('success');
		}
		else {
			$this->load->view('fail');
		}
	}

	public function viewSuccess() {
		$this->load->view('success');
	}

	//发送购买成功的短信
	public function sendSuccessMsg($oid){
		require_once(APPPATH."third_party/phone.class.php");
		$msg = $this->ticket->getInfoByOrder($oid);
		$phonesend = new PhoneCode();
		require_once(APPPATH."third_party/phone.class.php");
		$url = "http://open.bizapp.com/api/sms/templateSend";
		$param="appId=F0000036&tpId=2194304&customerId=C1012422&userId=U1013951&password=CQCcqc123&phones=".$msg['phone']."&fields=".$msg['name']."||李政军个人演唱会支付||世易大微信公众号，入场请携带有效身份证件||大乘五蕴文化传媒";
		$gbkparam = iconv("UTF-8","GBK//TRANSLIT",$param);
		$result = $phonesend->postSend($url,$gbkparam);
	}

	//支付宝异步通知页面
	public function notify(){
		require_once(APPPATH."../phonepay/alipay.config.php");
		require_once(APPPATH."../phonepay/lib/alipay_notify.class.php");
		$alipayNotify = new AlipayNotify($alipay_config);
		$verify_result = $alipayNotify->verifyNotify();
		if($verify_result) {//验证成功
			$doc = new DOMDocument();	
			if ($alipay_config['sign_type'] == 'MD5') {
				$doc->loadXML($_POST['notify_data']);
			}
	
			if ($alipay_config['sign_type'] == '0001') {
				$doc->loadXML($alipayNotify->decrypt($_POST['notify_data']));
			}
			if( ! empty($doc->getElementsByTagName( "notify" )->item(0)->nodeValue) ) {
				//得到商户订单号
				$out_trade_no = $doc->getElementsByTagName( "out_trade_no" )->item(0)->nodeValue;
				//支付宝交易号
				$trade_no = $doc->getElementsByTagName( "trade_no" )->item(0)->nodeValue;
				//交易状态
				$trade_status = $doc->getElementsByTagName( "trade_status" )->item(0)->nodeValue;
				if($trade_status == 'TRADE_FINISHED') {						
					$this->ticket->updateInfo($out_trade_no);
					//更新座位表信息；锁定已被订购座位
					$this->seats->updateInfo($out_trade_no);
					echo "success";		//请不要修改或删除
				}
				else if ($trade_status == 'TRADE_SUCCESS') {
					$this->ticket->updateInfo($out_trade_no);
					//更新座位表信息；锁定已被订购座位
					$this->seats->updateInfo($out_trade_no);
					
					echo "success";		//请不要修改或删除
				}
			}
		}
		else {
			//验证失败
			echo "fail";
		}
	}
	//根据授权码token调用交易接口alipay.wap.auth.authAndExecute
	public function doTrade($data){
		require_once(APPPATH."../phonepay/alipay.config.php");
		require_once(APPPATH."../phonepay/lib/alipay_submit.class.php");
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
				$data['notifyUrl'] = "http://shiyida.net:8080/ticket/index.php/welcome/notify";
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
	//判断座位是否被占用
	public function judgeSeat(){
		$seats = @$_POST['seats'];
		$seatsArray = explode(",", $seats);
		$result = $this->seats->judgeSeat($seatsArray);
		if($result){
			//座位已经被占
			echo 0;
		}
		else{
			//座位可以选择
			echo 1;
		}
	}
	//各种测试....
	public function test(){
		$seats[0]=1;
		$seats[1]=2;
		$seats[2]=3;
		$seatIds1[0]=2;
		$seatIds1[1]=4;
		$a = serialize($seatIds1);
		$seatIds2[0]=12;
		$seatIds2[0]=13;
		$b = serialize($seatIds2);
		$arrs['a']=$a;
		$arrs['b']=$b;
		for($i=0;$i<count($seats);$i++){
			foreach($arrs as $arr){
			
				$temp = unserialize($arr);
				if(in_array($seats[$i],$temp))
					echo $seats[$i];
				else
					echo "NO"."</br>";
			}
		}
		
	}
}
