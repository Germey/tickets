<?php
//��ʼ��֧�����ӿ���ز���
//���������id����2088��ͷ��16λ������
$alipay_config['partner']		= '2088911142594680';

//�տ�֧�����ʻ�
$alipay_config['seller_email']	= 'wuyun_dc@163.com';

//��ȫ�����룬�����ֺ���ĸ��ɵ�32λ�ַ�
//���ǩ����ʽ����Ϊ��MD5��ʱ�������øò���
$alipay_config['key']			= 'e1ipax9m3il8fyfshvb4kz2o64cw4o96';

//�̻���˽Կ����׺��.pem���ļ����·��
//���ǩ����ʽ����Ϊ��0001��ʱ�������øò���
$alipay_config['private_key_path']	= '/var/www/ticket/phonepay/key/rsa_private_key.pem';

//֧������Կ����׺��.pem���ļ����·��
//���ǩ����ʽ����Ϊ��0001��ʱ�������øò���
$alipay_config['ali_public_key_path']= '/var/www/ticket/phonepay/key/rsa_public_key.pem';
//ǩ����ʽ �����޸�
$alipay_config['sign_type']    = '0001';

//�ַ������ʽ Ŀǰ֧�� gbk �� utf-8
$alipay_config['input_charset']= 'utf-8';

//ca֤��·����ַ������curl��sslУ��
//�뱣֤cacert.pem�ļ��ڵ�ǰ�ļ���Ŀ¼��
$alipay_config['cacert']    = "/var/www/ticket/phonepay/cacert.pem";

//����ģʽ,�����Լ��ķ������Ƿ�֧��ssl���ʣ���֧����ѡ��https������֧����ѡ��http
$alipay_config['transport']    = 'http';
?>