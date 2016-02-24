<?php
/**
 * 商城板块初始化文件
 *
 *
 * * by 33hao www.33hao.com 运营版 */

define('BASE_PATH',str_replace('\\','/',dirname(__FILE__)));
if (!@include(dirname(dirname(__FILE__)).'/global.php')) exit('global.php isn\'t exists!');
if (!@include(BASE_CORE_PATH.'/33hao.php')) exit('33hao.php isn\'t exists!');
define('TPL_NAME',TPL_ADMIN_NAME);
define('ADMIN_TEMPLATES_URL',ADMIN_SITE_URL.'/templates/'.TPL_NAME);
define('BASE_TPL_PATH',BASE_PATH.'/templates/'.TPL_NAME);
define('SHOP_TEMPLATES_URL',SHOP_SITE_URL.'/templates/'.TPL_NAME);
define('SHOP_RESOURCE_SITE_URL',SHOP_SITE_URL.DS.'resource');
define('ACTIVITY_R_PATH', '/mobile/index.php?act=activity&op=sa_activity');//活动请求地址
///mobile/index.php?act=goods&op=goods_detai&goods_id=
define('GOODS_R_PATH', '/mobile/index.php?act=goods&op=goods_detai&goods_id=');//商品详情请求地址
define('SNS_R_PATH', '/mobile/index.php?act=sns&op=straceinfo&stid=');//sns详情请求地址
define('YOUHUI_R_PATH', '/mobile/index.php?act=activity_pub&op=youhuis&activity_type=');//促销详情请求地址
define('XIANSHI_R_PATH', '/mobile/index.php?act=activity_pub&op=xianshi&xianshi_id=');//限时折扣详情请求地址
define('PG_R_PATH', '/mobile/index.php?act=goods&op=goods_list');//平台商品活动请求地址
if (!@include(BASE_PATH.'/control/control.php')) exit('control.php isn\'t exists!');

Base::run();
?>