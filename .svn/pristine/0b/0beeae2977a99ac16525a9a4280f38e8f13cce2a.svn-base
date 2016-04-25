<?php
/**
 * 我的代金券
 *
 *
 *
 *
 * by 33hao.com 好商城V3 运营版
 */

//use Shopnc\Tpl;

defined('InShopNC') or exit('Access Invalid!');

class member_voucherControl extends mobileMemberControl {

	public function __construct() { 
		parent::__construct();
	}

    /**
     * 个人代金券列表
     */
    public function voucher_listOp() {
	$model_voucher = Model('voucher');
        $voucher_list = $model_voucher->getMemberVoucherList($this->member_info['member_id'], $_REQUEST['voucher_state'], $this->page);
        $page_count = $model_voucher->gettotalpage();

        output_data(array('voucher_list' => $voucher_list), mobile_page($page_count));
    }
        /**
	 * 代金券详情
	 */
	public function voucherdetailOp(){
		$vid = intval($_REQUEST['vid']);
		$result = true;
		$message = "";
		if ($vid <= 0){
                    output_special_code('10500');
		}

			//查询可兑换代金券模板信息
		$template_info = Model('voucher')->getCanChangeTemplateInfo($vid,$this->member_info['member_id'],intval($_REQUEST['store_id']));
                
                if(!empty($template_info)){
                    output_data($template_info);
                }else{
                    output_special_code('10500');
                }
	}
	/**
	 * 兑换代金券保存信息
	 *
	 */
	public function voucherexchangeOp(){
              
		$vid = intval($_REQUEST['vid']);
		if ($vid <= 0){
                    
                    output_special_code('10500');
		}
		$model_voucher = Model('voucher');
		//验证是否可以兑换代金券
		$data = $model_voucher->getCanChangeTemplateInfo($vid,$this->member_info['member_id']);
		if ($data['state'] == false){
                    output_special_code('10500',$data['msg']);
		}
		//添加代金券信息
		$data = $model_voucher->exchangeVoucher($data['info'],$this->member_info['member_id'],$this->member_info['member_name']);
		if ($data['state'] == true){
                    output_suc('1');
		} else {
                    output_special_code('10500');
		}
	}
    
}
