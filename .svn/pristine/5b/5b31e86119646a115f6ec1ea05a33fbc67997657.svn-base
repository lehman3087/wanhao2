<?php
/**
 * 商品图片统一调用函数
 *
 *
 *
 * @package    function* www.33hao.com 专业团队 提供售后服务
 */

defined('InShopNC') or exit('Access Invalid!');

function d_header_thumb($work, $type = '',$store_id=''){
    $search_array = explode(',', GOODS_IMAGES_EXT);
    
  //  $file = str_ireplace($search_array,'',$work['sn_work_pic']);
   // ATTACH_STORE_BARE.DS.$_SESSION['store_id'].DS.ATTACH_DESIGNER_HEADER.DS.$img_path;
    $fname = basename($work);

   
    if (preg_match('/^(\d+_)/',$fname)){
        $user_id = substr($fname,0,strpos($fname,'_'));
    }else{
            $user_id = $store_id;
    }
//    return BASE_UPLOAD_PATH.'/'.ATTACH_DWORK.'/'.$user_id.'/'.$file;
//    exit();<?php echo UPLOAD_SITE_URL.DS.ATTACH_STORE_BARE.DS.$_SESSION['store_id'].DS.ATTACH_DESIGNER_HEADER.DS.$output['sn_info']['sn_head'];
       
    $file = $type == '' ? $file : str_ireplace('.', '_' . $type . '.', $file);
    $thumb_host = UPLOAD_SITE_URL.DS.ATTACH_STORE_BARE.DS.$user_id.DS.ATTACH_DESIGNER_HEADER.DS.$work;
   // $thumb_host = UPLOAD_SITE_URL.'/'.ATTACH_MALBUM;
    return $thumb_host;
}
/**
 *  获得装修需求缩略图
 * @param type $work
 * @param string $type
 * @return type
 */
function wthumb($work, $type = '',$user_id){
//    $type_array = explode(',_', ltrim(GOODS_IMAGES_EXT, '_'));
//    if (!in_array($type, $type_array)) {
//        $type = '240';
//    }

    if (empty($work)){
        return UPLOAD_SITE_URL.'/'.defaultGoodsImage($type);
    }
    

    $search_array = explode(',', GOODS_IMAGES_EXT);
    
    $file = str_ireplace($search_array,'',$work);
    
    $fname = basename($file);

   
    if (preg_match('/^(\d+_)/',$fname)){
        $user_id = substr($fname,0,strpos($fname,'_'));
    }
//    return BASE_UPLOAD_PATH.'/'.ATTACH_DWORK.'/'.$user_id.'/'.$file;
//    exit();
       
    $file = $type == '' ? $file : str_ireplace('.', '_' . $type . '.', $file);
//    if (!file_exists(BASE_UPLOAD_PATH.'/'.ATTACH_DWORK.'/'.$user_id.'/'.$file)){
//        return UPLOAD_SITE_URL.'/'.defaultGoodsImage($type);
//    }
    $thumb_host = UPLOAD_SITE_URL.'/'.ATTACH_MALBUM;
    return $thumb_host.'/'.$user_id.'/'.$file;

}

function dwthumb($work = array(), $type = ''){
    $search_array = explode(',', GOODS_IMAGES_EXT);
    
    $file = str_ireplace($search_array,'',$work['sn_work_pic']);
    
    $fname = basename($file);

   
    if (preg_match('/^(\d+_)/',$fname)){
        $user_id = substr($fname,0,strpos($fname,'_'));
    }else{
        $user_id = $work['user_id'];
    }
//    return BASE_UPLOAD_PATH.'/'.ATTACH_DWORK.'/'.$user_id.'/'.$file;
//    exit();
       
    $file = $type == '' ? $file : str_ireplace('.', '_' . $type . '.', $file);
    
    $thumb_host = UPLOAD_SITE_URL.'/'.ATTACH_DWORK;
    return $thumb_host.'/'.$user_id.'/'.$work;
}
//装修需求
function reqthumb($work, $type = '',$user_id=''){
    $search_array = explode(',', GOODS_IMAGES_EXT);
    
  //  $file = str_ireplace($search_array,'',$work['sn_work_pic']);
    
    $fname = basename($work);

   
    if (preg_match('/^(\d+_)/',$fname)){
        $user_id = substr($fname,0,strpos($fname,'_'));
    }else{
            $user_id = $user_id;
    }
//    return BASE_UPLOAD_PATH.'/'.ATTACH_DWORK.'/'.$user_id.'/'.$file;
//    exit();
       
    $file = $type == '' ? $file : str_ireplace('.', '_' . $type . '.', $file);
    
    $thumb_host = UPLOAD_SITE_URL.'/'.ATTACH_REQUEST;
    return $thumb_host.'/'.$user_id.'/'.$work;
}


//判断是否可以下标书
function checkCanBid($param) {
    $bid_model=Model('bid');
    $condition['bid_work_id']=$param['dw_id'];
    $condition['bid_dc_id']=$_SESSION['store_id'];
    $condition['bid_state']=array('gt',0);
    $bidEffective=$bid_model->countCharg($condition);
    
    return $bidEffective;
    
}

//判断需求是否已经结束
function checkBtWin($param) {
    $bt_model=Model('bid_target');
    $condition['bt_rid']=$param['dw_id'];
    $bts=$bt_model->getBTList($condition);
    return $bts;
    
}

//检查一个标 是否还可以有装修公司竞标 一个标 最多几个人竞标
function checkbid($param){
    return checkBidCharge($param)&&checkBcCharge($param);
}

//检查一个标 是否还可以有装修公司竞标
function checkBidCharge($param) {
    
    $bid_model=Model('bid');
    $model_setting = Model('setting');
    $list_setting = $model_setting->getListSetting();
    $condition['bid_work_id']=$param['bid_work_id'];
    $condition['bid_state']=array('gt',0);
    $bidEffective=$bid_model->countCharg($condition);
    
    if($bidEffective<$list_setting['decoration_bid_count']||$list_setting['decoration_bid_count']==0){
        return true;
    }
    
    
}




function getBidCharge($param) {
    $model_setting = Model('setting');
    $list_setting = $model_setting->getListSetting();
    if($list_setting['decoration_bid_count']==0){
        return '不限';
    }
     $bid_model=Model('bid');
    
    $condition['bid_work_id']=$param['bid_work_id'];
    $condition['bid_state']=1;
    
    $dcEffective=$bid_model->countCharg($condition,"distinct(bid_work_id)");
    
    return $list_setting['decoration_bid_count']-$dcEffective;  
}

function functionName($param) {
    
}

//检查装修公司同时竞标 是否已满，是否还可以竞标
function checkBcCharge($param) {
    
    $bid_model=Model('bid');
    $model_setting = Model('setting');
    $list_setting = $model_setting->getListSetting();
    $condition['bid_dc_id']=$param['bid_dc_id'];
    $condition['bid_state']=1;
    
    $dcEffective=$bid_model->countCharg($condition,"distinct(bid_work_id)");
    
    if($dcEffective<$list_setting['decoration_dc_bid_issue']||$list_setting['decoration_dc_bid_issue']==0){
        return true;
    }
    
}

//竞标中 饱和情况下才可以放弃
 function DidBid($param) {
     $model_decoration = Model ( 'bid' );
     $condition['bid_dc_id']=$_SESSION['store_id'];
     $condition['bid_work_id']=$param['dw_id'];
     $condition['bid_state']=1;
     $bid = $model_decoration->countCharg($condition);
     
     
     
     if($bid>0&&($param['dw_state']==1||$param['dw_state']==2)){
         return true;
     }
     
}

function wdcthumb($file, $type = '',$store_id){
//    $type_array = explode(',_', ltrim(GOODS_IMAGES_EXT, '_'));
//    if (!in_array($type, $type_array)) {
//        $type = '240';
//    }

    if (empty($file)){
        return UPLOAD_SITE_URL.'/'.defaultGoodsImage($type);
    }
    
    

//    if (empty($work['sn_work_pic'])) {
//        return UPLOAD_SITE_URL.'/'.defaultGoodsImage($type);
//    }
//    
 //  exit('1');
    //$search_array = explode(',', GOODS_IMAGES_EXT);
    
   // $file = str_ireplace($search_array,'',$work['sn_work_pic']);
    
//    $fname = basename($file);
//
//   
//    if (preg_match('/^(\d+_)/',$fname)){
//        $user_id = substr($fname,0,strpos($fname,'_'));
//    }else{
//        $user_id = $work['sn_store_id'];
//    }
////    return BASE_UPLOAD_PATH.'/'.ATTACH_DWORK.'/'.$user_id.'/'.$file;
////    exit();ATTACH_WORK
//       
//    $file = $type == '' ? $file : str_ireplace('.', '_' . $type . '.', $file);
    if (!file_exists(BASE_UPLOAD_PATH.'/'.ATTACH_DWORK.'/'.$store_id.'/'.$file)){
       // exit('1');
        return UPLOAD_SITE_URL.'/'.defaultGoodsImage($type);
    }
    $thumb_host = UPLOAD_SITE_URL.'/'.ATTACH_DWORK;
    return $thumb_host.'/'.$store_id.'/'.$file;

}


function wcthumb($file, $type = '',$store_id){
//    $type_array = explode(',_', ltrim(GOODS_IMAGES_EXT, '_'));
//    if (!in_array($type, $type_array)) {
//        $type = '240';
//    }

    if (empty($file)){
        return UPLOAD_SITE_URL.'/'.defaultGoodsImage($type);
    }
    
    

//    if (empty($work['sn_work_pic'])) {
//        return UPLOAD_SITE_URL.'/'.defaultGoodsImage($type);
//    }
//    
 //  exit('1');
    //$search_array = explode(',', GOODS_IMAGES_EXT);
    
   // $file = str_ireplace($search_array,'',$work['sn_work_pic']);
    
//    $fname = basename($file);
//
//   
//    if (preg_match('/^(\d+_)/',$fname)){
//        $user_id = substr($fname,0,strpos($fname,'_'));
//    }else{
//        $user_id = $work['sn_store_id'];
//    }
////    return BASE_UPLOAD_PATH.'/'.ATTACH_DWORK.'/'.$user_id.'/'.$file;
////    exit();
//       
//    $file = $type == '' ? $file : str_ireplace('.', '_' . $type . '.', $file);
    if (!file_exists(BASE_UPLOAD_PATH.'/'.ATTACH_WORK.'/'.$file)){
       // exit('1');
        return UPLOAD_SITE_URL.'/'.defaultGoodsImage($type);
    }
    $thumb_host = UPLOAD_SITE_URL.'/'.ATTACH_WORK;
    return $thumb_host.'/'.$file;

}



function get_work_designer($param) {
    $model_decoration = Model ( 'designer' );
    $condition['id']=$param;
    $designer = $model_decoration->getDesignerInfo($condition);
    return $designer['sn_title'];
}

function get_decoration_company($param) {
    $model_decoration = Model ( 'store' );
    $store=$model_decoration->getStoreInfoByID($param);
    return $store['store_name'];
      
}