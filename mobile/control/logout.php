<?php
/**
 * 注销
 *
 *
 *
 *
 * by 33hao.com 好商城V3 运营版
 */

//use Shopnc\Tpl;

defined('InShopNC') or exit('Access Invalid!');

class logoutControl extends mobileMemberControl {

	public function __construct(){
		parent::__construct();
	}

    /**
     * 注销
     */
	public function indexOp(){
        if(empty($_REQUEST['username']) || !in_array($_REQUEST['client'], $this->client_type_array)) {
            output_error('参数错误'.$_REQUEST['username'].$_REQUEST['client']);
        }
        $model_mb_user_token = Model('mb_user_token');

     //   if($this->member_info['member_name'] == $_REQUEST['username']) {
            $condition = array();
            $condition['member_id'] = $this->member_info['member_id'];
            $condition['client_type'] = $_REQUEST['client'];
            $model_mb_user_token->delMbUserToken($condition);
            output_data('1');
//        } else {
//            output_error('参数错误'.$this->member_info['member_name'].$_REQUEST['username']);
//        }
	}

}
