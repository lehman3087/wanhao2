<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

defined('InShopNC') or exit('Access Invalid!');
class decoration_pubControl extends mobileHomeControl{
    public function __construct() {
		parent::__construct();
	}
        
    
        public function getDcListOp($param) {
            error_reporting(0);
            $post=$this->read_json();
            
            $arr=OTA($post);
            $_REQUEST= array_merge($_REQUEST,$arr);
            
           //var_dump($_REQUEST);
            $model_store = Model('store');
            
            //var_dump($_REQUEST['param'][0]);
            
            //$model_store=  Model('seller');
            $storeList=$model_store->getDcStoreOnlineIdArray($post->conditions,$_REQUEST['pageCount'],$post->sortType);
            
            $storeListBasic = $model_store-> getDcInfoBasic($storeList);
           
            $count=$model_store->gettotalpage();
            
//            var_dump($count);
//            exit();
            $storeListBasic= array_values($storeListBasic);
            
            if($count>0){
                output_data(array('storeBasic_list' => $storeListBasic), mobile_page($count));
               // output_data($storeList,array('statuCode'=>array('10200'),'total'=>$count));
            }else{
                output_error('10404');
            }
            
        }
        
        public function dwlistOp() {
            //$post=$this->read_json();
          //  $model_db=Model('decoration');
           // $_REQUEST = objectToArray($post);
           // output_data($_REQUEST);
            if($_REQUEST['user_id']<1){
                 output_error('10404');
             }
            $model_db = Model('decoration');
            $condition['dw_user_id']=intval($_REQUEST['user_id']);
            $result=$model_db->getWorkCommonList($condition,'',$_REQUEST['pageCount']);
            
            $result=$model_db->getExtWorkForApp($result);
            if($result){
                 output_data(array('dwlist'=>$result));
            }else{
                 output_error('10500');
            }
        }
        
               public function dw_suc_rec_listOp() {
           // var_dump('1');
            
            $model_db = Model('decoration');
            
            $condition['dw_commend']=1;
            
            $result=$model_db->getExtWorksCommonList($condition, $field = '*', $page = 6);
            if($result){
                 output_data(array('dwsuccessList'=>$result));
            }else{
                 output_error('10500');
            }
        }
        
        
        public function dwindexOp() {
            $model_db = Model('decoration');
            $condition['dw_id']=intval($_REQUEST['dw_id']);
            $result=$model_db->getRequestInfo($condition);
            $result=$model_db->getExtWorkUser($result);
            if($result){
                 output_data(array('dw'=>$result));
            }else{
                 output_error('10500');
            }
        }
        
        
         public function cancelRequestOp() {
            $model_db = Model('decoration');
            //$condition['dw_user_id']=$_REQUEST['user_id'];
            $update['dw_result']=!empty($_REQUEST['result'])?$_REQUEST['result']:'个人原因';
            $update['dw_state']=0;
          //  $dw_user_id=$_REQUEST['dw_id'];
            $condition['dw_id']=$_REQUEST['dw_id'];
            $result=$model_db->cancelBt($update,$condition);
            if($result){
                 output_suc('10200');
            }else{
                output_error('10500');
            }
        }
        
         public function selctBidOp() {
            $model_db = Model('bid_target');
            //$condition['dw_user_id']=$_REQUEST['user_id'];
            
            if(empty($_REQUEST['user_id'])||empty($_REQUEST['dc_id'])||empty($_REQUEST['dw_id'])||empty($_REQUEST['bid_id'])){
                 output_error('10404');
             }
             
            $data['bt_user_id']=  intval($_REQUEST['user_id']);
            $data['bt_dc_id']=intval($_REQUEST['dc_id']);
            $data['bt_rid']=intval($_REQUEST['dw_id']);
            $data['bt_evaluation']=$_REQUEST['evaluation'];
            $result=$model_db->selectBid($data);
            $condition2['bid_id']=  intval($_REQUEST['bid_id']);
            $dw_id=  intval($_REQUEST['dw_id']);
            if($result){
                $model_db->selectedUpdateBid($condition2,$dw_id);
            }
            $data2['store_dc_deals'] = array('exp','store_dc_deals+1');
           // $data2['store_dc_deals']='store_dc_deals+1';
            $scondition['store_id']=intval($_REQUEST['dc_id']);
            $result=Model('store')->editStore($data2,$scondition);
            if($result){
                 output_suc('10200');
            }else{
                output_error('10500');
            }
        }
        
        
        

        
        
}