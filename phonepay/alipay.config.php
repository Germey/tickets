<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//初始化支付宝接口相关参数
//合作身份者id，以2088开头的16位纯数字
$alipay_config['partner']		= '2088911142594680';

//收款支付宝帐户
$alipay_config['seller_email']	= 'wuyun_dc@163.com';

//安全检验码，以数字和字母组成的32位字符
//如果签名方式设置为“MD5”时，请设置该参数
$alipay_config['key']			= 'e1ipax9m3il8fyfshvb4kz2o64cw4o96';

//商户的私钥（后缀是.pem）文件相对路径
//如果签名方式设置为“0001”时，请设置该参数
$alipay_config['private_key_path']	= '/var/www/ticket/phonepay/key/rsa_private_key.pem';

//支付宝公钥（后缀是.pem）文件相对路径
//如果签名方式设置为“0001”时，请设置该参数
$alipay_config['ali_public_key_path']= '/var/www/ticket/phonepay/key/rsa_public_key.pem';

//签名方式 不需修改
$alipay_config['sign_type']    = '0001';

//字符编码格式 目前支持 gbk 或 utf-8
$alipay_config['input_charset']= 'utf-8';

//ca证书路径地址，用于curl中ssl校验
//请保证cacert.pem文件在当前文件夹目录中
$alipay_config['cacert']    = "/var/www/ticket/phonepay/cacert.pem";

//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
$alipay_config['transport']    = 'http';
?>