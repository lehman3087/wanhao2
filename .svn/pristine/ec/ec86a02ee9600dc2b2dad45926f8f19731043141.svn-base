<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
defined('InShopNC') or exit('Access Invalid!');

class smsModel extends Model{
    
    private $Vrange=120000;
    public function __construct(){
        parent::__construct('sms');
    }
    
    public function insertSMS($param){
        $insert['create_time']=time();
        $insert['content']=$param['content'];
        $insert['type']=$param['type'];
        $insert['username']=$param['username'];
        Model()->table('sms')->insert($insert);
        
    }
    
    public function smsValidate($username,$vtype,$content=''){
       
       // $condition_str = $this->getCondition($condition);
        
	$param	= array();
	$param['table']		= 'sms';
	$param['where']		= "username=".$username;
        $param['where']		.= " AND type='".$vtype."'";
        $param['order']		= 'create_time desc';
        $param['limit']		= '1';
        
	$sms		=       Db::select($param,$page);
        if(empty($sms)){
            return false;
        }
        $now=time();
        switch ($vtype) {
            case 'SMS_GET_REG_CODE':
                //var_dump($now-$sms[0]['create_time']);
                return (($now-$sms[0]['create_time']) < $this->Vrange)&&($sms[0]['content']==$content);
                break;
            case 'SMS_GET_FGT_PASS_CODE':
                return (($now-$sms[0]['create_time']) < $this->Vrange)&&($sms[0]['content']==$content);
                break;

        }
        
        
    }
    
    public function expire($key){

        $condition_str = $this->getCondition(array('key'=>$key));
        Db::update('sms',array('state'=>0),$condition_str);
        
    }
}
