<?php
/**
 * 微信支付通知地址
 *
 * 
 * by 33hao.com 好商城V3 运营版
 */
$_REQUEST['act']	= 'payment';
$_REQUEST['op']		= 'notify';
$_REQUEST['payment_code'] = 'wxpay';
require_once(dirname(__FILE__).'/../../../index.php');
