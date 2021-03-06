<?php
/**
 * 购买
 *
 *
 *
 *
 * by 33hao.com 好商城V3 运营版
 */

//use Shopnc\Tpl;

defined('InShopNC') or exit('Access Invalid!');

class member_buyControl extends mobileMemberControl {

	public function __construct() {
		parent::__construct();
	}

    /**
     * 购物车、直接购买第一步:选择收获地址和配置方式
     */
    public function buy_step1Op() {
        
        $cart_id = explode(',', $_REQUEST['cart_ids']);
      //  var_dump($cart_id);
        $logic_buy = logic('buy');
        
        //得到购买数据
        $result = $logic_buy->buyStep1($cart_id, $_REQUEST['ifcart'], $this->member_info['member_id'], $this->member_info['store_id']);
        
        
        if(!$result['state']) {
           // var_dump($result['msg']);
            output_error($result['msg']);
        } else {
            $result = $result['data'];
        }
        
        //整理数据
        $store_cart_list = array();
        foreach ($result['store_cart_list'] as $key => $value) {
            $store_cart_list[$key]['goods_list'] = $value;
            $store_cart_list[$key]['store_goods_total'] = $result['store_goods_total'][$key];
            if(!empty($result['store_premiums_list'][$key])) {
                $result['store_premiums_list'][$key][0]['premiums'] = true;
                $result['store_premiums_list'][$key][0]['goods_total'] = 0.00;
                $store_cart_list[$key]['goods_list'][] = $result['store_premiums_list'][$key][0];
            }
            $store_cart_list[$key]['store_mansong_rule_list'] = $result['store_mansong_rule_list'][$key];
            $store_cart_list[$key]['store_voucher_list'] = $result['store_voucher_list'][$key];
            if(!empty($result['cancel_calc_sid_list'][$key])) {
                $store_cart_list[$key]['freight'] = '0';
                $store_cart_list[$key]['freight_message'] = $result['cancel_calc_sid_list'][$key]['desc'];
            } else {
                $store_cart_list[$key]['freight'] = '1';
            }
            $store_cart_list[$key]['store_name'] = $value[0]['store_name'];
            $store_cart_list[$key]['store_id'] = $value[0]['store_id'];
             
        }
        
        foreach ($store_cart_list as $key => $value) {
            $store_cart_list[$key]['store_voucher_list']=  array_values($value['store_voucher_list']);
        }
        
        $buy_list = array();
        $buy_list['store_cart_list'] = array_values($store_cart_list);
        
        $buy_list['freight_hash'] = $result['freight_list'];
        $buy_list['address_info'] = !empty($result['address_info'])?$result['address_info']:(object)array();
        $buy_list['ifshow_offpay'] = $result['ifshow_offpay'];
        $buy_list['vat_hash'] = $result['vat_hash'];
        $buy_list['inv_info'] = $result['inv_info'];
        $buy_list['available_predeposit'] = $result['available_predeposit'];
        $buy_list['available_rc_balance'] = $result['available_rc_balance'];
        
        output_data($buy_list);
    }

    /**
     * 购物车、直接购买第二步:保存订单入库，产生订单号，开始选择支付方式
     *
     */
    public function buy_step2Op() {
        $param = array();
        $param['ifcart'] = $_REQUEST['ifcart'];
        $param['cart_id'] = explode(',', $_REQUEST['cart_ids']);
        $param['address_id'] = $_REQUEST['address_id'];
        $param['vat_hash'] = $_REQUEST['vat_hash'];
        $param['offpay_hash'] = $_REQUEST['offpay_hash'];
        $param['offpay_hash_batch'] = $_REQUEST['offpay_hash_batch'];
        $param['pay_name'] = $_REQUEST['pay_name'];
        $param['invoice_id'] = $_REQUEST['invoice_id'];

        //处理代金券
        $voucher = array();
        $post_voucher = explode(',', $_REQUEST['voucher']);
        if(!empty($post_voucher)) {
            foreach ($post_voucher as $value) {
                list($voucher_t_id, $store_id, $voucher_price) = explode('|', $value);
                $voucher[$store_id] = $value;
            }
        }
        
        
        $param['voucher'] = $voucher;
        //手机端暂时不做支付留言，页面内容太多了
        //$param['pay_message'] = json_decode($_REQUEST['pay_message']);
        $param['pd_pay'] = $_REQUEST['pd_pay'];
        $param['rcb_pay'] = $_REQUEST['rcb_pay'];
        $param['password'] = $_REQUEST['password'];
        $param['fcode'] = $_REQUEST['fcode'];
        $param['order_from'] = 2;
        $logic_buy = logic('buy');
        
        
        $result = $logic_buy->buyStep2($param, $this->member_info['member_id'], $this->member_info['member_name'], $this->member_info['member_email']);
        if(!$result['state']) {
           // var_dump($result);
            output_error($result['msg']);
        }

        output_data(array('pay_sn' => $result['data']['pay_sn']));
    }

    /**
     * 验证密码
     */
    public function check_passwordOp() {
        if(empty($_REQUEST['password'])) {
            output_error('参数错误');
        }

        $model_member = Model('member');

        $member_info = $model_member->getMemberInfoByID($this->member_info['member_id']);
        if($member_info['member_paypwd'] == md5($_REQUEST['password'])) {
            output_data('1');
        } else {
            output_error('密码错误');
        }
    }

    /**
     * 更换收货地址
     */
    public function change_addressOp() {
        $logic_buy = Logic('buy');

        $data = $logic_buy->changeAddr($_REQUEST['freight_hash'], $_REQUEST['city_id'], $_REQUEST['area_id'], $this->member_info['member_id']);
        if(!empty($data) && $data['state'] == 'success' ) {
            output_data($data);
        } else {
            output_error('地址修改失败');
        }
    }


}

