<?php
/**
 * 支付
 *
 *
 *
 *
 * by 33hao.com 好商城V3 运营版
 */

//use Shopnc\Tpl;

defined('InShopNC') or exit('Access Invalid!');

class member_paymentControl extends mobileMemberControl {

    private $payment_code = 'alipay';

	public function __construct() {
		parent::__construct();
                $this->payment_code = isset($_REQUEST['payment_code']) && trim($_REQUEST['payment_code']) != '' ? trim($_REQUEST['payment_code']) :'alipay';
	}

    /**
     * 实物订单支付
     */
    public function payOp() {
        
	$pay_sn = $_REQUEST['pay_sn'];

        $model_mb_payment = Model('mb_payment');
        $logic_payment = Logic('payment');

        $condition = array();
        $condition['payment_code'] = $this->payment_code;
        $mb_payment_info = $model_mb_payment->getMbPaymentOpenInfo($condition);
        if(!$mb_payment_info) {
            output_error('系统不支持选定的支付方式');
        }

        //重新计算所需支付金额
        $result = $logic_payment->getRealOrderInfo($pay_sn, $this->member_info['member_id']);

        if(!$result['state']) {
            output_error($result['msg']);
        }

        //第三方API支付
        $this->_api_pay($result['data'], $mb_payment_info);
    }
    
    //在线支付统一返回
    public function app_payOp($param) {
        
        if($this->payment_code=='wxpay'){
            $this->getpWpayOp();
        }else if($this->payment_code=='alipay'){
            
            $this->getpAlipayOp();
        }
    }
    
     public function getpWpayOp() {
         
        $pay_sn = $_REQUEST['pay_sn'];
        
        //$payment_api = $this->_get_payment_api();
        
        $inc_file = BASE_PATH.DS.'api'.DS.'payment'.DS.'wxpay'.DS.'wxpay.php';

    	if(!is_file($inc_file)){
              //  var_dump($inc_file);
            output_error($inc_file);
    	}
        require($inc_file);
        $payment_api = new wxpay();
        
       $payment_api->getpWpay($pay_sn);
        //var_dump($return);
       // $array=array();
       // $array=$payment_api->parameters;
       // $array['api_key']='55f0c2ffb28f1597fa77ad56dc055d0c';
        //return $return;
        //output_data($return);
        
    }
    
    
    
 
    public function getpAlipayOp() {
	$pay_sn = $_REQUEST['pay_sn'];

        $model_mb_payment = Model('mb_payment');
        $logic_payment = Logic('payment');

        $condition = array();
        $condition['payment_code'] = $this->payment_code;
        $mb_payment_info = $model_mb_payment->getMbPaymentOpenInfo($condition);
        
      //  var_dump($mb_payment_info);
        if(!$mb_payment_info) {
            output_error('10400');
        }
       
        //重新计算所需支付金额
        $result = $logic_payment->getRealOrderInfo($pay_sn, $this->member_info['member_id']);
        
        // var_dump($this->member_info['member_id']);
        
        if(!$result['state']) {
            
            output_error($result['msg']);
        }

        //第三方API支付
        $this->_api_ali_pay($result['data'], $mb_payment_info);
        
        
    }

//    public function functionName($param) {
//        $pay_sn = $_REQUEST['pay_sn'];
//        $condition = array();
//        $condition['payment_code'] = $this->payment_code;
//        $mb_payment_info = $model_mb_payment->getMbPaymentOpenInfo($condition);
//        if(!$mb_payment_info) {
//            output_error('系统不支持选定的支付方式');
//        }
//        $payment_api = new $this->payment_code();
//        $return = $payment_api->returnParam($pay_sn);
//        
//    }
    
//    public function getpWpayOp() {
//
//        $pay_sn = $_REQUEST['pay_sn'];
//        
//        $inc_file = BASE_PATH.DS.'api'.DS.'payment'.DS.'wxpay'.DS.'wpay.php';
//
//    	if(!is_file($inc_file)){
//            output_error('支付接口不存在');
//    	}
//        
//        $payment_api = new wpay();
//        $return = $payment_api->returnAliParam($pay_sn);
//        
//        var_dump($return);
//    }
    
    /**
     * 实物订单支付
     */
    public function payWxOp() {
	$pay_sn = $_REQUEST['pay_sn'];

        $model_mb_payment = Model('mb_payment');
        $logic_payment = Logic('payment');

        $condition = array();
        $condition['payment_code'] = $this->payment_code;
        $mb_payment_info = $model_mb_payment->getMbPaymentOpenInfo($condition);
        if(!$mb_payment_info) {
            output_error('系统不支持选定的支付方式');
    }

        //重新计算所需支付金额
        $result = $logic_payment->getRealOrderInfo($pay_sn, $this->member_info['member_id']);

        if(!$result['state']) {
            output_error($result['msg']);
        }

        //第三方API支付
        $this->_api_pay($result['data'], $mb_payment_info);
    }
    
    

    /**
     * 虚拟订单支付
     */
    public function vr_payOp() {
        $order_sn = $_REQUEST['pay_sn'];
    
        $model_mb_payment = Model('mb_payment');
        $logic_payment = Logic('payment');
    
        $condition = array();
        $condition['payment_code'] = $this->payment_code;
        $mb_payment_info = $model_mb_payment->getMbPaymentOpenInfo($condition);
        if(!$mb_payment_info) {
            output_error('系统不支持选定的支付方式');
        }
    
        //重新计算所需支付金额
        $result = $logic_payment->getVrOrderInfo($order_sn, $this->member_info['member_id']);
    
        if(!$result['state']) {
            output_error($result['msg']);
        }
    
        //第三方API支付
        $this->_api_pay($result['data'], $mb_payment_info);
    }

	/**
	 * 第三方在线支付接口
	 *
	 */
        private function _api_pay($order_pay_info, $mb_payment_info) {
            
        $inc_file = BASE_PATH.DS.'api'.DS.'payment'.DS.$this->payment_code.DS.$this->payment_code.'.php';
    	if(!is_file($inc_file)){
            output_error('支付接口不存在');
    	}
    	require($inc_file);
        $param = array();
    	$param = $mb_payment_info['payment_config'];
        $param['order_sn'] = $order_pay_info['pay_sn'];
        $param['order_amount'] = $order_pay_info['api_pay_amount'];
        $param['order_type'] = ($order_pay_info['order_type'] == 'real_order' ? 'r' : 'v');
        $payment_api = new $this->payment_code();
        $return = $payment_api->submit($param);
        echo $return;
    	exit;
	}
        
       private function _api_ali_pay($order_pay_info, $mb_payment_info) {
           
        $inc_file = BASE_PATH.DS.'api'.DS.'payment'.DS.$this->payment_code.DS.$this->payment_code.'.php';
    	if(!is_file($inc_file)){
            
            output_error('支付接口不存在');
    	}
    	require($inc_file);
        $param = array();
    	$param = $mb_payment_info['payment_config'];
        $param['order_sn'] = $order_pay_info['pay_sn'];
        $param['order_amount'] = $order_pay_info['api_pay_amount'];
        $param['order_type'] = ($order_pay_info['order_type'] == 'real_order' ? 'r' : 'v');
        $payment_api = new $this->payment_code();
        
        $return = $payment_api->returnParam($param);
        output_data($return);

	}
        
        
        
        
        	/**
	 * 第三方在线支付接口
	 *
	 */
	private function _api_pay_wx($order_pay_info, $mb_payment_info) {
        $inc_file = BASE_PATH.DS.'api'.DS.'payment'.DS.$this->payment_code.DS.$this->payment_code.'.php';
    	if(!is_file($inc_file)){
            output_error('支付接口不存在');
    	}
    	require($inc_file);
        $param = array();
    	$param = $mb_payment_info['payment_config'];
        $param['order_sn'] = $order_pay_info['pay_sn'];
        $param['order_amount'] = $order_pay_info['api_pay_amount'];
        $param['order_type'] = ($order_pay_info['order_type'] == 'real_order' ? 'r' : 'v');
        $payment_api = new $this->payment_code();
        $return = $payment_api->submit($param);
        echo $return;
    	exit;
	}
        
        

    /**
     * 可用支付参数列表
     */
    public function payment_listOp() {
        $model_mb_payment = Model('mb_payment');

        $payment_list = $model_mb_payment->getMbPaymentOpenList();

        $payment_array = array();
        if(!empty($payment_list)) {
            foreach ($payment_list as $value) {
                $payment_array[] = $value['payment_code'];
            }
        }

        output_data(array('payment_list' => $payment_array));
    }
}
