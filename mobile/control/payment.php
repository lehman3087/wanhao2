<?php
/**
 * 支付回调
 *
 *
 *
 *
 * by 33hao.com 好商城V3 运营版
 */

//use Shopnc\Tpl;

defined('InShopNC') or exit('Access Invalid!');

class paymentControl extends mobileHomeControl{

    private $payment_code;

	public function __construct() {
		parent::__construct();

            $this->payment_code = $_GET['payment_code'];
	}

    public function returnopenidOp(){
        $payment_api = $this->_get_payment_api();
        if($this->payment_code != 'wxpay'){
            output_error('支付参数异常');
            die;
        }
        $payment_api->getopenid();
    }
  
    
    public function getpWpayOp() {   
        $pay_sn = $_REQUEST['pay_sn'];
        
        $payment_api = $this->_get_payment_api();
        
        $return = $payment_api->getpWpay($pay_sn);
        
        //return $return;
        output_data(array('prepay_id'=>$return,),$payment_api->parameters);
        
    }
    
    public function returnwPrePOp($param) {
        $payment_api = $this->_get_payment_api();
        
        $pp=$payment_api->getPrepayId();
     //   $payment_api->setPrepayId($pp);
      //  $pstring=$payment_api->getParameters();
        echo($pp);
        
    }
    

      public function returnWxArrayOp(){
        $payment_api = $this->_get_payment_api();
        if($this->payment_code != 'wxpay'){
            output_error('支付参数异常');
            die;
        }
        $payment_api->getopenid();
    }
    

    /**
     * 支付回调
     */
    public function returnOp() {
        
        unset($_GET['act']);
        unset($_GET['op']);
        unset($_GET['payment_code']);

        $payment_api = $this->_get_payment_api();

        $payment_config = $this->_get_payment_config();

        $callback_info = $payment_api->getReturnInfo($payment_config);

        if($callback_info) {
            //验证成功
            $result = $this->_update_order($callback_info['out_trade_no'], $callback_info['trade_no']);
            if($result['state']) {
                Tpl::output('result', 'success');
                Tpl::output('message', '支付成功');
            } else {
                Tpl::output('result', 'fail');
                Tpl::output('message', '支付失败');
			}
        } else {
			//验证失败
            Tpl::output('result', 'fail');
            Tpl::output('message', '支付失败');
		}

        Tpl::showpage('payment_message');
    }

        /**
     * 支付提醒
     */
    public function notify2Op() {
        // 恢复框架编码的post值
        //$_POST['notify_data'] = html_entity_decode($_POST['notify_data']);

        //$payment_api = $this->_get_payment_api();

        //$payment_config = $this->_get_payment_config();

        //$callback_info = $payment_api->getNotifyInfo($payment_config);
        $result=Db::insert('log', array('key'=>'111','value'=>'12'));

       
            //验证成功
//            $result = $this->_update_order($_REQUEST['out_trade_no'], $_REQUEST['trade_no']);
//            if($result['state']) {
//                if($this->payment_code == 'wxpay'){
//                    echo $callback_info['returnXml'];
//                    die;
//                }else{
//                    echo 'success';die;
//                }
//
//            }
		//}

        //验证失败

    }
    
    /**
     * 支付提醒
     */
    public function notifyOp() {
        
        if($_GET['payment_code'] == 'alipay'){
                    $this->ali_notice();
                }else{
                    echo 'success';die;
                }
                
                
        // 恢复框架编码的post值
        $result=Db::insert('log', array('key'=>'1','value'=>serialize($_POST)));
        $result=Db::insert('log', array('key'=>'2','value'=>serialize($_GET)));
        $_POST['notify_data'] = html_entity_decode($_POST['notify_data']);
        $result=Db::insert('log', array('key'=>'3','value'=>serialize($_POST)));
        $payment_api = $this->_get_payment_api();

        $payment_config = $this->_get_payment_config();

        $callback_info = $payment_api->getNotifyInfo($payment_config);
        $result=Db::insert('log', array('key'=>'4','value'=>  serialize($callback_info)));
        if($callback_info) {
            //验证成功
            $result = $this->_update_order($callback_info['out_trade_no'], $callback_info['trade_no']);
            if($result['state']) {
                if($this->payment_code == 'wxpay'){
                    echo $callback_info['returnXml'];
                    die;
                }else{
                    echo 'success';die;
                }

            }
		}

        //验证失败

        if($this->payment_code == 'wxpay'){
            echo '<xml><return_code><!--[CDATA[FAIL]]--></return_code></xml>';
            die;
        }else{
            
            
            echo "fail";die;
        }
    }
    
    
    private function ali_notice(){
        if(!empty($_POST)){             //如果$_POST数据不为空的话
//        foreach ($_POST as $k => $v) {
//            file_put_contents('post.txt', $k.'---'.$v.PHP_EOL, FILE_APPEND);
//        }
 
    if(!empty($_POST['trade_status'])){         //状态值不为空
        $bill_list_id_date = $_POST['out_trade_no'];        //商户订单号
        $trade_no = $_POST['trade_no'];                     //支付宝交易号
        $trade_status = $_POST['trade_status'];             //交易状态
        $total_fee = $_POST['total_fee'];                   //支付金额
        //检查该账单是否已支付.....
 
        if($trade_status == 'TRADE_FINISHED' OR $trade_status  == 'TRADE_SUCCESS') {
            //处理你的业务逻辑......
            $result = $this->_update_order($bill_list_id_date, $trade_no);
            if($result['state']) {
                if($this->payment_code == 'wxpay'){
                    echo $callback_info['returnXml'];
                    die;
                }else{
                    echo 'success';die;
                }

            }
        }
    }
}

    }

    /**
     * 获取支付接口实例
     */
    private function _get_payment_api() {
       
        $inc_file = BASE_PATH.DS.'api'.DS.'payment'.DS.$this->payment_code.DS.$this->payment_code.'.php';

        if(is_file($inc_file)) {
             
            require($inc_file);
        }

        $payment_api = new $this->payment_code();
        //var_dump($payment_api);
        return $payment_api;
    }

    /**
     * 获取支付接口信息
     */
    private function _get_payment_config() {
        $model_mb_payment = Model('mb_payment');

        //读取接口配置信息
        $condition = array();
        $condition['payment_code'] = $this->payment_code;
        $payment_info = $model_mb_payment->getMbPaymentOpenInfo($condition);
        
        return $payment_info['payment_config'];
    }
    
    
    public function update_orderOp() {

            $result = $this->_update_order($_POST['pay_sn'], $_POST['trade_no']);
            if($result['state']) {
                output_suc('10200');
            }
		
    }

    /**
     * 更新订单状态
     */
    private function _update_order($out_trade_no, $trade_no) {
        $model_order = Model('order');
        $logic_payment = Logic('payment');

        $tmp = explode('|', $out_trade_no);
        $out_trade_no = $tmp[0];
        
        if (!empty($tmp[1])) {
            $order_type = $tmp[1];
        } else {
            $order_pay_info = Model('order')->getOrderPayInfo(array('pay_sn'=> $out_trade_no));
            if(empty($order_pay_info)){
                $order_type = 'v';
            } else {
                $order_type = 'r';
            }
        }

        if ($order_type == 'r') {
            $result = $logic_payment->getRealOrderInfo($out_trade_no);
            if (intval($result['data']['api_pay_state'])) {
                return array('state'=>true);
            }
            $order_list = $result['data']['order_list'];
            $result = $logic_payment->updateRealOrder($out_trade_no, $this->payment_code, $order_list, $trade_no);

        } elseif ($order_type == 'v') {
        	$result = $logic_payment->getVrOrderInfo($out_trade_no);
	        if ($result['data']['order_state'] != ORDER_STATE_NEW) {
	            return array('state'=>true);
	        }
	        $result = $logic_payment->updateVrOrder($out_trade_no, $this->payment_code, $result['data'], $trade_no);
        }

        return $result;
    }

}
