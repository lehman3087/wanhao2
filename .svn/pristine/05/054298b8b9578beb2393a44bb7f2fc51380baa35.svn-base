<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

defined('InShopNC') or exit('Access Invalid!');
class designerControl extends mobileHomeControl{

	public function __construct() {
          
        parent::__construct();
       
    }
    
    public function abcOp($param) {
        $json = "{\"pageCount\":\"10\"}";
        var_dump(json_decode($json));
    }
    
    public function designer_listOp(){
        $model_designers = Model('designer');
       // $post=$this->read_json();     
        
         $post=$this->read_json();  
        $arr=OTA($post);
        $_REQUEST=array_merge($_REQUEST,$arr);
        
//        
        $designers_list = $model_designers->getDesignerListPage($post->conditions,$_REQUEST['pageCount'],0,'*','',$post->sortType);
        $page_count = $model_designers->gettotalpage();
        output_data(array('desginers_list' => $designers_list), mobile_page($page_count));
        
        
    }
}