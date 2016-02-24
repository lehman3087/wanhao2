<?php
/**
 * 前台登录 退出操作
 *
 * @copyright  Copyright (c) 2007-2013 ShopNC Inc. (http://www.shopnc.net)
 * @license    http://www.shopnc.net
 * @link       http://www.shopnc.net
 * @since      File available since Release v1.1
 */
defined('InShopNC') or exit('Access Invalid!');

class loginControl extends mobileHomeControl {
	public function __construct(){
		parent::__construct();
	}

	/**
	 * 登录
	 */
	public function indexOp(){
	$post=$this->read_json();
        objectToArrayAndRequest($post);
        if(empty($_REQUEST['username']) || empty($_REQUEST['password']) || !in_array($_REQUEST['client'], $this->client_type_array)) {
            output_error('4045');
        }
        $model_member = Model('member');
        $array = array();
//        $array['member_name']	= $_REQUEST['username'];
//        $array['member_passwd']	= md5(trim($_REQUEST['password']));
        
        $array['member_name|member_email|member_mobile']	= $_REQUEST['username'];
			$array['member_passwd']	= md5(trim($_REQUEST['password']));
//			$member_info = $model_member->getMemberInfo($array);
//			if(is_array($member_info) and !empty($member_info)) {
//				if(!$member_info['member_state']){
//			        showDialog($lang['login_index_account_stop'],''.'error',$script);
//				}
//			}else{361458577
//			    process::addprocess('login');
//			    showDialog($lang['login_index_login_fail'],'','error',$script);
//			}
                        
       // var_dump($array);
        $member_info = $model_member->getMemberInfo($array);
        //var_dump($member_info);
        if(!empty($member_info)) {
            $token = $this->_get_token($member_info['member_id'], $member_info['member_name'], $_REQUEST['client']);
            if($token) {
                output_data($member_info,array('statuCode' => '10200', 'key' => $token));
            } else {
                output_error('104041');
            }
        } else {
            output_error('10404');
        }
    }

    /**
     * 登陆生成token
     */
    private function _get_token($member_id, $member_name, $client) {
        $model_mb_user_token = Model('mb_user_token');

        //重新登陆后以前的令牌失效
        //暂时停用
        //$condition = array();
        //$condition['member_id'] = $member_id;
        //$condition['client_type'] = $_POST['client'];
        //$model_mb_user_token->delMbUserToken($condition);

        //生成新的token
        $mb_user_token_info = array();
        $token = md5($member_name . strval(TIMESTAMP) . strval(rand(0,999999)));
        $mb_user_token_info['member_id'] = $member_id;
        $mb_user_token_info['member_name'] = $member_name;
        $mb_user_token_info['token'] = $token;
        $mb_user_token_info['login_time'] = TIMESTAMP;
        $mb_user_token_info['client_type'] = $_REQUEST['client'];
           
       
        $result = $model_mb_user_token->addMbUserToken($mb_user_token_info);

        if($result) {
            return $token;
        } else {
            return null;
        }

    }
    
      /**
   * 获得短信验证码
   *
   * @param
   * @return
   */
  public function getCodeOp() {
       //global $_SERVER;
    $model_member = Model('member');
    $ret=array();
    $username=$_REQUEST['username'];
    
    if(!empty($username)){
      $statuCode=$model_member->check_is_member($username);
   // Tpl::output('html_title',C('site_name').' - '.$lang['login_register_join_us']);
      if($statuCode=='10200'){
          $code=random(4,1);
         // $_SESSION[$username]=$code;
         // var_dump($_SESSION);
         // $token = $this->_get_token($member_info['member_id'], $member_info['member_name'], $_REQUEST['client']);
          $model_sms = Model('sms');
          $insertsms['username'] = $_REQUEST['username'];
          $insertsms['content'] = $code;
          $insertsms['type'] = 'SMS_GET_REG_CODE';
          $model_sms->insertSMS($insertsms);
          
          $ret=array('code'=>$code);
          //exit($code);
          
          output_data($ret);
          exit();
        }
      
        }else{
        output_error('1040501');
       //$ret['statuCode']='1040501';
    }
    
    output_special_code('10406');
    
  }

    /**
    * 注册
    */
    public function registerOp(){
        //判断验证码是否过期
        $model_sms	= Model('sms');
        if(empty($_REQUEST['username'])||empty($_REQUEST['code'])||empty($_REQUEST['client'])){
            output_error('10408');
        }

        $checkv=$model_sms->smsValidate($_REQUEST['username'],'SMS_GET_REG_CODE',$_REQUEST['code']);  
        if(!$checkv){
            output_error('10413');
        }
        
	$model_member	= Model('member');
        
        $register_info = array();
        $register_info['username'] = $_REQUEST['username'];
        $register_info['password'] = $_REQUEST['password'];
        $register_info['password_confirm'] = $_REQUEST['password_confirm'];
       // $register_info['email'] = $_POST['email'];
        $member_info = $model_member->register($register_info);
        if(!isset($member_info['error'])) {
            $token = $this->_get_token($member_info['member_id'], $member_info['member_name'], $_REQUEST['client']);
//            var_dump($member_info);
//            echo($token.'z');
            if($token) {
                output_data($member_info,array('statuCode' => '10200', 'key' => $token));
            } else {
                output_error('10500');
            }
        } else {
		output_error($member_info['error']);
        }

    }
    
     /**
     * 获取忘记密码的验证码
     */
      public function getPswCodeOp() {
        $model_member = Model('member');
        $param = array();
        $username = $_REQUEST['username'];
        if(empty($username)){
            output_error('10405');
        }
        $checkMember=$model_member->check_is_member($username);
        //判断用户名不存在
        if($checkMember=='10200'){
            output_error('10407');
        }else{
            $code=random(4,1);
            $model_sms = Model('sms');
            $insertsms['username'] = $_REQUEST['username'];
            $insertsms['content'] = $code;
            $insertsms['type'] = 'SMS_GET_FGT_PASS_CODE';
            $model_sms->insertSMS($insertsms);
            $ret=array('code'=>$code);
            output('10200',$ret);
        }
        
        output('10500');
    } 
    
     /**
     * 获取忘记密码的验证码
     */
      public function resetPasswordOp() {
        $model_sms	= Model('sms');
        if(empty($_REQUEST['username'])||empty($_REQUEST['code'])){
            output_error('10405');
        }
        
        $checkv=$model_sms->smsValidate($_REQUEST['username'],'SMS_GET_FGT_PASS_CODE',$_REQUEST['code']);  
        
        if(!$checkv){
            output_error('10413');
        }else{
            $array=array();
            $array['member_name']=$_REQUEST['username'];
            $model_member = Model('member');
            $member_info = $model_member->getMemberInfo($array);
            
            $param['member_passwd']  = $_REQUEST['password'];
            $param['password_confirm']  = $_REQUEST['password_confirm'];
            $update=$model_member->chagePassWord($param, $member_info['member_id']);
            if($update){
              $model_mb_user_token = Model('mb_user_token');
              $condition = array();
              $condition['member_id'] = $member_info['member_id'];
              $condition['client_type'] = $_REQUEST['client'];
              $model_mb_user_token->delMbUserToken($condition);
              $token = $this->_get_token($member_info['member_id'], $member_info['member_name'], $_REQUEST['client']);
             // output_data(''array('')"10200");
              output_data('',array('statuCode' => '10200','key'=>$token));
              }else{
               output_error($update['error'].'10500');
            }
        }
       
   } 
    
   
}
