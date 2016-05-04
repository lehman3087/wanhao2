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
        
        public function traceOp(){
		$this->get_visitor();	// 获取访客
		$this->sns_messageboard();	// 留言版
		$is_owner = false;//是否为主人自己
		if ($_SESSION['member_id'] == intval($_GET['mid'])){
		    $is_owner = true;
		}
		Tpl::output('is_owner',$is_owner);
		Tpl::output('menu_sign','snstrace');
		Tpl::showpage('sns_hometrace');
	}
	/**
	 * 某会员的SNS动态列表
	 */
	public function tracelistOp(){
		$tracelog_model = Model('sns_tracelog');
		$condition = array();
		$condition['trace_memberid'] = $this->master_id;
		switch ($this->relation){
			case 3:
				$condition['trace_privacyin'] = "";
				break;
			case 2:
				$condition['trace_privacyin'] = "0','1";
				break;
			case 1:
				$condition['trace_privacyin'] = "0";
				break;
			default:
				$condition['trace_privacyin'] = "0";
				break;
		}
		$condition['trace_state'] = "0";
                
                
		$count = $tracelog_model->countTrace($condition);
		//分页
		$page	= new Page();
		$page->setEachNum(30);
		$page->setStyle('admin');
		$page->setTotalNum($count);
		$delaypage = intval($_GET['delaypage'])>0?intval($_GET['delaypage']):1;//本页延时加载的当前页数
		$lazy_arr = lazypage(10,$delaypage,$count,true,$page->getNowPage(),$page->getEachNum(),$page->getLimitStart());
		//动态列表
		$condition['limit'] = $lazy_arr['limitstart'].",".$lazy_arr['delay_eachnum'];
		$tracelist = $tracelog_model->getTracelogList($condition);
		if (!empty($tracelist)){
			foreach ($tracelist as $k=>$v){
				if ($v['trace_title']){
					$v['trace_title'] = str_replace("%siteurl%", SHOP_SITE_URL.DS, $v['trace_title']);
					$v['trace_title_forward'] = '|| @'.$v['trace_membername'].Language::get('nc_colon').preg_replace("/<a(.*?)href=\"(.*?)\"(.*?)>@(.*?)<\/a>([\s|:|：]|$)/is",'@${4}${5}',$v['trace_title']);
				}
				if(!empty($v['trace_content'])){
					//替换内容中的siteurl
					$v['trace_content'] = str_replace("%siteurl%", SHOP_SITE_URL.DS, $v['trace_content']);
				}
				$tracelist[$k] = $v;
			}
		}
		Tpl::output('hasmore',$lazy_arr['hasmore']);
		Tpl::output('tracelist',$tracelist);
		Tpl::output('show_page',$page->show());
		Tpl::output('type','home');
		//验证码
		Tpl::output('nchash',substr(md5(SHOP_SITE_URL.$_GET['act'].$_GET['op']),0,8));
		Tpl::output('menu_sign', 'snstrace');
		Tpl::showpage('sns_tracelist','null_layout');
	}
        
}