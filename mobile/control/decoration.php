<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

defined('InShopNC') or exit('Access Invalid!');
class decorationControl extends mobileMemberControl{
    public function __construct() {
		parent::__construct();
	}
        public function addBTOp($param) {
            $model_designers = Model('decoration');
            $insert['dw_con_name']=$_REQUEST['dw_con_name'];
            $insert['dw_con_mobile']=$_REQUEST['dw_con_mobile'];
            $insert['dw_category']=$_REQUEST['dw_category'];
            $insert['dw_budget']=$_REQUEST['dw_budget'];
            $insert['dw_area']=$_REQUEST['dw_area'];
            $insert['dw_style']=$_REQUEST['dw_style'];
            $insert['dw_address']=$_REQUEST['dw_address'];
            $insert['dw_house_type']=$_REQUEST['dw_house_type'];
            $insert['dw_house_type']=$_REQUEST['dw_file_name'];
            $result=$model_designers->addBt($insert);
            if($result){
                 output_data('10200');
            }
        }
        
        public function addRequestOp($param) {
            
            $model_designers = Model('decoration');
            $insert['dw_con_name']=$_REQUEST['dw_con_name'];
            $insert['dw_con_mobile']=$_REQUEST['dw_con_mobile'];
            $insert['dw_category']=$_REQUEST['dw_category'];
            $insert['dw_budget']=$_REQUEST['dw_budget'];
            $insert['dw_area']=$_REQUEST['dw_area'];
            $insert['dw_style']=$_REQUEST['dw_style'];
            $insert['dw_address']=$_REQUEST['dw_address'];
            $insert['dw_house_type']=$_REQUEST['dw_house_type'];
            $insert['dw_file_paths']=$_REQUEST['dw_file_paths'];
            $insert['dw_user_id']=$_REQUEST['user_id'];
            $insert['dw_user_name']=$_REQUEST['user_name'];
            $insert['dw_addtime']=time();
            
            $result=$model_designers->addBt($insert);
            if($result){
                 output_suc('10200');
            }else{
                output_error('10500');
            }
        }
        
        public function delRequestOp() {
            $model_db = Model('decoration');
            $condition['dw_id']=$_REQUEST['id'];
            $result=$model_db->delBt($condition);
            if($result){
                 output_suc('10200');
            }else{
                 output_error('10500');
            }
        }
        
         public function cancelRequestOp() {
            $model_db = Model('decoration');
            $update['dw_result']=!empty($_REQUEST['result'])?$_REQUEST['result']:'个人原因';
            $update['dw_state']=0;
            $condition['dw_id']=$_REQUEST['dw_id'];
            $result=$model_db->cancelBt($update,$condition);
            if($result){
                 output_suc('10200');
            }else{
                output_error('10500');
            }
        }
        
         public function selctBidOp() {
            $_REQUEST=$this->request_json();
             if(empty($_REQUEST['user_id'])||empty($_REQUEST['dc_id'])||empty($_REQUEST['dw_id'])||empty($_REQUEST['bid_id'])){
                 output_error('10404');
             }
            $model_db = Model('bid_target');
            //$condition['dw_user_id']=$_REQUEST['user_id'];
            
            $data['bt_user_id']=  intval($_REQUEST['user_id']);
            $data['bt_dc_id']=intval($_REQUEST['dc_id']);
            $data['bt_rid']=intval($_REQUEST['dw_id']);
            $data['bt_evaluation']=$_REQUEST['evaluation'];
            $data['bt_bid']=intval($_REQUEST['bid_id']);
            $result=$model_db->selectBid($data);
            $condition2['bid_id']=  intval($_REQUEST['bid_id']);
            $dw_id=  intval($_REQUEST['dw_id']);
            if($result){
                $result=$model_db->selectedUpdateBid($condition2,$dw_id);
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