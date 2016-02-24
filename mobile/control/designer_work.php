<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

defined('InShopNC') or exit('Access Invalid!');
class designer_workControl extends mobileHomeControl{
	public function __construct() {
        parent::__construct();
    }

    public function designer_work_listOp(){
        
            error_reporting(0);
            $post=$this->read_json();
            
            $arr=OTA($post);
            $_REQUEST= array_merge($_REQUEST,$arr);
          //  var_dump($_REQUEST);
          //  exit();
 //       $arr=objectToArray($post);
 //       $_REQUEST=array_merge($_REQUEST,$arr);
 //       $goods_id = intval($_REQUEST ['goods_id']);
        
       $model_designer_work = Model('designer_work');
//        // $model_search = Model('search');
//       // $condition['designer_work.sn_if_show']=1;
//        if(!empty($_REQUEST['id']) && intval($_REQUEST['id']) > 0) {
//        $condition = " and designer_work.id=".$_REQUEST['id'];
//        } elseif (!empty($_REQUEST['conditions']['matchValue'])) {
//        $condition['designer_work.sn_name|designer_work.sn_content'] = array('like', '%' . $_REQUEST['conditions']['matchValue'] . '%');
//        }
        //$condition['sn_name|sn_content'] = array('like', '%' . 'abc'. '%');
        
     //   output_data(array('desginers_work_list' => $post));
       $field='designer_work.id,designer_work.sn_collect,designer_work.sn_category,designer_work.sn_style,designer_work.sn_m_pic,designer_work.sn_work_pic,designer_work.sn_area,designer_work.sn_cost,designer_work.sn_content,designer_work.sn_add_time,designer_work.sn_house_type,designer_work.sn_collection_count,designer_work.sn_share_count,designer_work.sn_designer_id,designer.sn_title,designer_work.sn_name,designer.sn_head,designer.sn_designer_style,designer.sn_designer_enter_time,designer.sn_designer_collect,designer.sn_store_id,designer.sn_store_name';
        $designers_work_list = $model_designer_work->getDesignerWorkList($post->conditions,$field,$_REQUEST['pageCount']);
        
       // var_dump($designers_work_list);
       // output_data(array('desginers_work_list' => $post));
         
        $page_count = $model_designer_work->gettotalpage();
        //优先从全文索引库里查找
        
        output_data(array('desginers_work_list' => $designers_work_list), mobile_page($page_count));
        
    }
}