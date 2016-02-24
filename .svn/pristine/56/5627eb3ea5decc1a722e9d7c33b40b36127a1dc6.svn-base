<?php
/**
 * 我的商城
 *
 *
 *
 *
 * by 33hao.com 好商城V3 运营版
 */

//use Shopnc\Tpl;

defined('InShopNC') or exit('Access Invalid!');

class member_indexControl extends mobileMemberControl {

	public function __construct(){
		parent::__construct();
	}

    /**
     * 我的商城
     */
	public function indexOp() {
        $member_info = array();
        $member_info['user_name'] = $this->member_info['member_name'];
        $member_info['avator'] = getMemberAvatarForID($this->member_info['member_id']);
        $member_info['point'] = $this->member_info['member_points'];
        $member_info['predepoit'] = $this->member_info['available_predeposit'];
	//v3-b11 显示充值卡
		$member_info['available_rc_balance'] = $this->member_info['available_rc_balance'];

        output_data(array('member_info' => $member_info));
	}
        /*
         * 猜您喜欢商品
         */
       public function guessLikeOp() {       
        $page=  !empty($_REQUEST['num'])?$_REQUEST['num']:20;
        $goodlist=Model('goods_browse')->getGuessLikeGoods($this->member_info['member_id'],20);
        output_data($goodlist);
    }
    
    	/**
	 * 我的资料【用户中心】
	 *
	 * @param
	 * @return
	 */
	public function memberInfoOp() {

		//Language::read('member_home_member');
		//$lang	= Language::getLangContent();

		$model_member	= Model('member');

		//if (chksubmit()){
			$member_array	= array();
			$member_array['member_truename']	= $_REQUEST['member_truename'];
                        $member_array['member_truename']	= $_REQUEST['member_truename'];
                        $member_array['member_nickname']	= $_REQUEST['member_nickname'];
			$member_array['member_sex']			= $_REQUEST['member_sex'];
			$member_array['member_qq']			= $_REQUEST['member_qq'];
			$member_array['member_ww']			= $_REQUEST['member_ww'];
			$member_array['member_areaid']		= $_REQUEST['area_id'];
			$member_array['member_cityid']		= $_REQUEST['city_id'];
			$member_array['member_provinceid']	= $_REQUEST['province_id'];
			$member_array['member_areainfo']	= $_REQUEST['area_info'];
			if (strlen($_REQUEST['birthday']) == 10){
				$member_array['member_birthday']	= $_REQUEST['birthday'];
			}
			$member_array['member_privacy']		= serialize($_REQUEST['privacy']);
			$update = $model_member->editMember(array('member_id'=>$this->member_info['member_id']),$member_array);

			//$message = $update? $lang['nc_common_save_succ'] : $lang['nc_common_save_fail'];
			//showDialog($message,'reload',$update ? 'succ' : 'error');
		//}
                
                        if($update){
                            output_suc('1');
                        }else{
                            output_special_code('10500');
                        }

	}
        
}
