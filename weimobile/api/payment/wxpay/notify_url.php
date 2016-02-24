<?php
/**
 * 微信支付通知地址
 *
 * 
 * by 33hao.com 万豪购 运营版
 */
$_GET['act']	= 'payment';
$_GET['op']		= 'notify';
$_GET['payment_code'] = 'wxpay';
require_once(dirname(__FILE__).'/../../../index.php');
