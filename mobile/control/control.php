<?php
/**
 * mobile父类
 *
 *
 * by 33hao.com 好商城V3 运营版
 */

//use Shopnc\Tpl;

defined('InShopNC') or exit('Access Invalid!');

/********************************** 前台control父类 **********************************************/

class mobileControl{
    

    //客户端类型
    protected $client_type_array = array('android', 'wap', 'wechat', 'ios');
    //列表默认分页数
    protected $page = 5;
    
    protected function read_json() {
        ob_start();
        $postdata = file_get_contents("php://input");
        return  json_decode($postdata);
        
    }
    
    
    protected function request_json(){
       $postdata = file_get_contents("php://input");
        $post=json_decode($postdata);
        $arr=OTA($post);
        return array_merge($_REQUEST,$arr);
    }


    protected function _dealDcOrder($param) {
        if($param=='1'){
            return 'rand()';
        }else if($param==2){
            return 'store_collect desc ';
        }else if($param==3){
            return 'store_sales desc';
        }
    }
    
    protected function _dealCondition($conditions) {
       // $conditions=(array)$conditions;
        $con=array();
        if(!empty($conditions)){
            
             foreach ($conditions as $value) {
                // var_dump($value['matchType']);
                 $kv=array();
                if($value['matchType']==0){
                  $type =  'like';
                  $val="%".$value['matchValue']."%";
                }elseif ($value['matchType']==10) {
                   $type =  'in';
                  $val=explode(',',$value['matchValue']);
                }
                $kv[]=$type;
                $kv[]=$val;
                $con[$value['matchKey']]=$kv;
                }
        }
       
        return $con;
        
    }
    


	public function __construct() {
            
        Language::read('mobile');
        $this->request_json();
        //分页数处理
        $page = intval($_REQUEST['pageCount']);
        if($page > 0) {
            $this->page = $page;
        }
        
        error_reporting(0);

        
    }
}

class mobileHomeControl extends mobileControl{
	public function __construct() {
        parent::__construct();
    }
    
        protected function getStoreInfo($store_id) {
        $model_store = Model('store');
        $store_info = $model_store->getStoreOnlineInfoByID($store_id);
        if(empty($store_info)) {
            showMessage(L('nc_store_close'), '', '', 'error');
        }

        $this->outputStoreInfo($store_info);
    }
    
}

class mobileMemberControl extends mobileControl{

    protected $member_info = array();

	public function __construct() {
            
        parent::__construct();

        $model_mb_user_token = Model('mb_user_token');
        $key = $_REQUEST['key'];
        if(empty($key)) {
            $key = $_REQUEST['key'];
        }
        $mb_user_token_info = $model_mb_user_token->getMbUserTokenInfoByToken($key);
        if(empty($mb_user_token_info)) {
            output_error('10404', array('login' => '0'));
        }

        $model_member = Model('member');
        $this->member_info = $model_member->getMemberInfoByID($mb_user_token_info['member_id']);
        $this->member_info['client_type'] = $mb_user_token_info['client_type'];
        if(empty($this->member_info)) {
            output_error('10404', array('login' => '0'));
        } else {
            //读取卖家信息
            $seller_info = Model('seller')->getSellerInfo(array('member_id'=>$this->member_info['member_id']));
            $this->member_info['store_id'] = $seller_info['store_id'];
        }
    }
}
