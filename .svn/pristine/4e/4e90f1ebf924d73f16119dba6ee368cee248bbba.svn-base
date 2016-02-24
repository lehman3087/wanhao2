<?php
/**
 * 前台登录 退出操作
 *
 *
 *
 *
 * by 33hao.com 好商城V3 运营版
 */

use Shopnc\Tpl;

defined('InShopNC') or exit('Access Invalid!');

class snsControl extends mobileMemberControl {

	public function __construct(){
		parent::__construct();
	}


	/**
	 * 添加评论(访客登录后操作)
	 */
	public function addcommentOp(){
		// 验证用户是否登录
		$stid = intval($_REQUEST['stid']);
		if($stid <= 0){
                    output_error('error');
		}
//		$obj_validate = new Validate();
//		$validate_arr[] = array("input"=>$_REQUEST["commentcontent"], "require"=>"true","message"=>Language::get('sns_comment_null'));
//		$validate_arr[] = array("input"=>$_REQUEST["commentcontent"], "validator"=>'Length',"min"=>0,"max"=>140,"message"=>Language::get('sns_content_beyond'));
//		//评论数超过最大次数出现验证码
//		if(intval(cookie('commentnum'))>=self::MAX_RECORDNUM){
//			$validate_arr[] = array("input"=>$_REQUEST["captcha"], "require"=>"true","message"=>Language::get('wrong_null'));
//		}
//		$obj_validate -> validateparam = $validate_arr;
//		$error = $obj_validate->validate();
//		if ($error != ''){
//			output_error('error');
//		}
//		//发帖数超过最大次数出现验证码
//		if(intval($_REQUEST['commentnum'])>=self::MAX_RECORDNUM){
//                        $_SESSION[$_REQUEST['nchash']]=$_REQUEST['captcha'];
////			if (!checkSeccode($_REQUEST['nchash'],$_REQUEST['captcha'])){
////				showDialog(Language::get('wrong_checkcode'),'','error');
////			}
//		}
// 		//查询会员信息
		$model = Model();
		$member_info = $model->table('member')->where(array('member_state'=>1))->find($_SESSION['member_id']);
		if (empty($member_info)){
                    output_error('404');
			//showDialog(Language::get('sns_member_error'),'','error');
		}
		$insert_arr = array();
		$insert_arr['strace_id'] 			= $stid;
		$insert_arr['scomm_content']		= $_REQUEST['commentcontent'];
		$insert_arr['scomm_memberid']		= $member_info['member_id'];
		$insert_arr['scomm_membername']		= $member_info['member_name'];
		$insert_arr['scomm_memberavatar']	= $member_info['member_avatar'];
		$insert_arr['scomm_time']			= time();
		$result = Model('store_sns_comment')->saveStoreSnsComment($insert_arr);
		if ($result){
			// 原帖增加评论次数
			$where = array('strace_id'=>$stid);
			$update = array('strace_comment'=>array('exp','strace_comment+1'));
			$rs = Model('store_sns_tracelog')->editStoreSnsTracelog($update, $where);
			//建立cookie
			
                        $commentnum=$_REQUEST['commentnum']+1;
			
                        output_data('',array('commentnum'=>$commentnum));
		}
	}
        
        public function shareOp($param) {
            $stid = intval($_REQUEST['stid']);
		if($stid <= 0){
                    output_error('error');
		}
                $model = Model('store_trace_share');
		$member_info = $model->table('member')->where(array('member_state'=>1))->find($_REQUEST['member_id']);
		if (empty($member_info)){
                    output_error('404');
			//showDialog(Language::get('sns_member_error'),'','error');
		}
		$insert_arr = array();
		$insert_arr['ss_strace_id'] 			= $stid;
		$insert_arr['ss_memberid']		= $member_info['member_id'];
		$insert_arr['ss_membername']		= $member_info['member_name'];
		$insert_arr['ss_memberavatar']	= $member_info['member_avatar'];
                $insert_arr['ss_share_comment']	= $_REQUEST['share_comment'];
		$insert_arr['ss_time']			= time();
		$result = Model('store_sns_share')->saveStoreSnsShare($insert_arr);
		if ($result){
                        output_data('',array('sharenum'=>$commentnum));
			//showDialog(Language::get('sns_comment_succ'),'','succ',$js);
		}    
             
        }
        
        public function followOp($param) {
                $stid = intval($_REQUEST['stid']);
		if($stid <= 0){
                    output_error('error');
		}
                $model = Model('store_member');
		$member_info = $model->table('member')->where(array('member_state'=>1))->find($_REQUEST['member_id']);
		if (empty($member_info)){
                    output_error('404');
			//showDialog(Language::get('sns_member_error'),'','error');
		}
		$insert_arr = array();
		$insert_arr['sf_strace_id'] 		= $stid;
		$insert_arr['sf_member_id']		= $member_info['member_id'];
		$insert_arr['sf_membername']		= $member_info['member_name'];
		$insert_arr['sf_memberavatar']	= $member_info['member_avatar'];
		$insert_arr['sf_time']			= time();
		$result = Model('store_sns_follow')->saveStoreSnsFollow($insert_arr);
		if ($result){
			// 原帖增加关注次数
			$where = array('strace_id'=>$stid);
			$update = array('strace_follow'=>array('exp','strace_follow+1'));
			$rs = Model('store_sns_tracelog')->editStoreSnsTracelog($update, $where);
			//建立cookie
			if (cookie('commentnum') != null && intval(cookie('commentnum')) >0){
                                $commentnum=$_REQUEST['sharenum']+1;
			}else{
                                 $commentnum=$_REQUEST['sharenum'];
			}
                        output_data('',array('follownum'=>$commentnum));
		}    
             
        }
        
        public function unfollowOp($param) {
                $stid = intval($_REQUEST['stid']);
		if($stid <= 0){
                    output_error('error');
		}
                $model = Model('store_member');
		$member_info = $model->table('member')->where(array('member_state'=>1))->find($_REQUEST['member_id']);
		if (empty($member_info)){
                    output_error('404');
			//showDialog(Language::get('sns_member_error'),'','error');
		}

                $where['strace_id']=$stid;
		$result = Model('store_sns_follow')->delStoreSnsFollow($where);
		if ($result){
			// 原帖删除关注次数
			$where = array('strace_id'=>$stid);
			$update = array('strace_follow'=>array('exp','strace_follow-1'));
			$rs = Model('store_sns_tracelog')->editStoreSnsTracelog($update, $where);
			//建立cookie
			if (cookie('commentnum') != null && intval(cookie('commentnum')) >0){
                                $commentnum=$_REQUEST['sharenum']-1;
			}else{
                                 $commentnum=$_REQUEST['sharenum'];
			}
                        output_data('',array('follownum'=>$commentnum));
		}
        }
        
        /**
	 * 一条SNS动态及其评论
	 */
	public function straceinfoOp(){
		$stid = intval($_REQUEST['stid']);
		if($stid <= 0){
                    output_error('error');
			//showMessage(Language::get('para_error'),'','','error');
		}
		$model_stracelog = Model('store_sns_tracelog');
		$strace_info = $model_stracelog->getStoreSnsTracelogInfo(array('strace_id' => $stid));
		if(!empty($strace_info)){
			if($strace_info['strace_content'] == ''){
				$content = $model_stracelog->spellingStyle($strace_info['strace_type'], json_decode($strace_info['strace_goodsdata'],true));
				$strace_info['strace_content'] = str_replace("%siteurl%", SHOP_SITE_URL.DS, $content);
			}
		}
                output_data('strace_info', $strace_info);
	}
        
}