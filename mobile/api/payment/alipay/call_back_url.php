<?php
/* * 
 * 功能：支付宝页面跳转同步通知页面
 */

$_REQUEST['act'] = 'payment';
$_REQUEST['op']	= 'return';
$_REQUEST['payment_code']	= 'alipay';
require_once(dirname(__FILE__).'/../../../index.php');
?>
