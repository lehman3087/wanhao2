<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
defined('InShopNC') or exit('Access Invalid!');
class decorationControl extends SystemControl{
    
   private $links = array(
		array('url'=>'act=decoration&op=settings_index','lang'=>'category_manage'),
		array('url'=>'act=decoration&op=style_index','lang'=>'style_manage'),
                array('url'=>'act=decoration&op=otherSettings','lang'=>'other_settings'),
    );
    
    public function __construct(){
        error_reporting(0);
		parent::__construct();	
                Language::read('decoration');

    }
    
    public function indexOp() {
//         $model_decoration = Model('decoration');
//        $work_list = $model_decoration->getWorkCommonList();
//        
//        $a=wthumb($work_list[0],60);
//        var_dump($a);
//        exit();
//       
//        $list_setting = $model_setting->getListSetting();
//        if ($list_setting['decoration_category'] != ''){
//			$list = mb_unserialize($list_setting['decoration_category']);
//	}
//        var_dump($list_setting['decoration_category']);   
//        exit();
//        $dc=array('家装','工装');
//        $sdc=serialize($dc);
//        $sdc=base64_encode($sdc);
//        var_dump($sdc);
//        //var_dump(unserialize($sdc));
//       // $str = 'a:9:{s:4:"time";i:1405306402;s:4:"name";s:6:"新晨";s:5:"url";s:1:"-";s:4:"word";s:1:"-";s:5:"rpage";s:29:"http://www.baidu.com/test.html";s:5:"cpage";s:1:"-";s:2:"ip";s:15:"117.151.180.150";s:7:"ip_city";s:31:"中国北京市 北京市移动";s:4:"miao";s:1:"5";}';  
//        var_dump(unserialize(base64_decode($sdc)));
    }
    
    public function settings_indexOp() {
          $model_decoration = Model('decoration');
          
          
//          var_dump($category);
//          exit();
          
         if (chksubmit()){
             $uparr=array_filter($_POST['category']);
             if($_POST['check_gc_id']){
                $uparr = array_diff($uparr,$_POST['check_gc_id']);
             }
             $cats=array_map("base64_encode",$uparr);
             $model_decoration->update_category($cats);
         }
         $category=$model_decoration->get_category();
          Tpl::output('category',$category);
          Tpl::output('top_link',$this->sublink($this->links,'settings_index'));
          Tpl::showpage('decoration.category');
          
          
    }
    
        public function style_indexOp() {
          $model_decoration = Model('decoration');
          
          
//          var_dump($category);
//          exit();
          
         if (chksubmit()){
             $uparr=array_filter($_POST['style']);
             if($_POST['check_gc_id']){
                $uparr = array_diff($uparr,$_POST['check_gc_id']);
             }
             $cats=array_map("base64_encode",$uparr);
             $model_decoration->update_style($cats);
         }
         $style=$model_decoration->get_style();
          Tpl::output('style',$style);
          Tpl::output('top_link',$this->sublink($this->links,'style_index'));
          Tpl::showpage('decoration.style');
          
          
    }
    
    public function otherSettingsOp(){
        $model_setting = Model('setting');
        if (chksubmit()){
            $param['decoration_bid_count']=$_REQUEST['decoration_bid_count'];
            $param['decoration_dc_bid_issue']=$_REQUEST['decoration_dc_bid_issue'];
            $model_setting->updateSetting($param);
          //  exit($param['decoration_bid_count']);
        }
        
        $list_setting = $model_setting->getListSetting();
        
        Tpl::output('list_setting',$list_setting);
        Tpl::output('top_link',$this->sublink($this->links,'otherSettings'));
        Tpl::showpage('decoration.othersettings');
          
    }

    public function worksOp() {
        $model_decoration = Model ( 'decoration' );
        /**
         * 处理分类风格
         */
        
        $style_arr = Model('decoration')->get_style();
        $category_arr = Model('decoration')->get_category();
	Tpl::output('style',$style_arr);
	Tpl::output('category',$category_arr);

        /**
         * 查询条件
         */
        $where = array();
        if ($_GET['search_goods_name'] != '') {
            $where['dw_name'] = array('like', '%' . trim($_GET['search_goods_name']) . '%');
        }
        if (intval($_GET['search_commonid']) > 0) {
            $where['dw_id'] = intval($_GET['search_commonid']);
        }

        if (in_array($_GET['search_state'], array('0','1','10'))) {
            $where['dw_state'] = $_GET['search_state'];
        }
        if (in_array($_GET['search_verify'], array('0','1','10'))) {
            $where['dw_verify'] = $_GET['search_verify'];
        }

        switch ($_GET['type']) {
            // 禁售
            case 'lockup':
                $goods_list = $model_goods->getGoodsCommonLockUpList($where);
                break;
            // 等待审核
            case 'waitverify':
                $work_list = $model_decoration->getWorksCommonWaitVerifyList($where, '*', 10, 'dw_verify desc, dw_id desc');
                //var_dump($work_list);
                break;
            // 全部商品
            default:
                $work_list = $model_decoration->getExtWorksCommonList($where);
                //print_r($work_list);
                break;
        }
        Tpl::output('work_list', $work_list);
        
        Tpl::output('page', $model_decoration->showpage(2));


        Tpl::output('search', $_GET);

        Tpl::output('state', array('1' => '竞标中', '0' => '中断', '3' => '定标'));

        Tpl::output('verify', array('1' => '通过', '0' => '未通过', '10' => '等待审核'));

        //Tpl::output('ownShopIds', array_fill_keys(Model('store')->getOwnShopIds(), true));

        switch ($_GET['type']) {
            // 禁售
            case 'lockup':
                Tpl::showpage('goods.close');
                break;
            // 等待审核
            case 'waitverify':
                Tpl::showpage('decoration.works.verify');
                break;
            // 全部商品
            default:
                Tpl::showpage('decoration.works.index');
                break;
        }
    }
    
    /*
     * 案例违规删除
     */
    public function designer_work_delOp() {
       
        if (chksubmit()) {
            $commonids = $_POST['commonids'];
            $commonid_array = explode(',', $commonids);
            foreach ($commonid_array as $value) {
                if (!is_numeric($value)) {
                    showDialog(L('nc_common_op_fail'), 'reload');
                }
            }
            $where = array();
            $where['id'] = array('in', $commonid_array);
            $reason = trim($_POST['close_reason']);
            Model('designer_work')->delDwCommon($where,$reason);
            showDialog(L('nc_common_op_succ'), 'reload', 'succ');
        }
        Tpl::output('commonids', $_GET['id']);
        Tpl::showpage('designerwork.close_remark', 'null_layout');
    
    }
     /**
     * 违规下架
     */
    
    public function work_lockupOp() {
       
        if (chksubmit()) {
            $commonids = $_POST['commonids'];
            $commonid_array = explode(',', $commonids);
            foreach ($commonid_array as $value) {
                if (!is_numeric($value)) {
                    showDialog(L('nc_common_op_fail'), 'reload');
                }
            }
            $update = array();
            $update['dw_result'] = trim($_POST['close_reason']);
            $where = array();
            $where['dw_id'] = array('in', $commonid_array);

            Model('decoration')->editDwLockUp($update, $where);
            showDialog(L('nc_common_op_succ'), 'reload', 'succ');
        }
        Tpl::output('commonids', $_GET['id']);
        Tpl::showpage('decoration.close_remark', 'null_layout');
    
    }
    
    
    public function lookup_bidOp() {
        error_reporting(0);
        $where['bid_id']=$_REQUEST['id'];
        $bid=Model('bid')->getBidInfo($where);
        
        Tpl::output('bid', $bid);
        Tpl::showpage('decoration.lookbid', 'null_layout');
    }
    
    public function designer_worksOp($param) {
          $model_decoration = Model ( 'designer_work' );
        /**
         * 处理分类风格
         */
        
        $style_arr = Model('decoration')->get_style();
        $category_arr = Model('decoration')->get_category();
	Tpl::output('style',$style_arr);
	Tpl::output('category',$category_arr);
        
        
        $where = array();
        if ($_GET['search_goods_name'] != '') {
            $where['goods_name'] = array('like', '%' . trim($_GET['search_goods_name']) . '%');
        }
        if (intval($_GET['search_commonid']) > 0) {
            $where['goods_commonid'] = intval($_GET['search_commonid']);
        }
        if ($_GET['search_store_name'] != '') {
            $where['store_name'] = array('like', '%' . trim($_GET['search_store_name']) . '%');
        }
        if (intval($_GET['b_id']) > 0) {
            $where['brand_id'] = intval($_GET['b_id']);
        }
        if ($choose_gcid > 0){
		    $where['gc_id_'.($gccache_arr['showclass'][$choose_gcid]['depth'])] = $choose_gcid;
		}
        if (in_array($_GET['search_state'], array('0','1','10'))) {
            $where['goods_state'] = $_GET['search_state'];
        }
        if (in_array($_GET['search_verify'], array('0','1','10'))) {
            $where['goods_verify'] = $_GET['search_verify'];
        }

        switch ($_GET['type']) {
            // 禁售
            case 'lockup':
                $goods_list = $model_goods->getGoodsCommonLockUpList($where);
                break;
            // 等待审核
            case 'waitverify':
                $goods_list = $model_goods->getGoodsCommonWaitVerifyList($where, '*', 10, 'goods_verify desc, goods_commonid desc');
                break;
            // 全部商品
            default:
                $work_list = $model_decoration->getDesignerWorkListweb($where);
                break;
        }
        Tpl::output('work_list', $work_list);
        Tpl::output('page', $model_decoration->showpage(2));

        Tpl::showpage('decoration.designer_work');
    }
    
    public function get_designer_work_list_ajaxOp(){
            /**
     * ajax获取商品列表
     */
   
        $commonid = $_GET['commonid'];
        if ($commonid <= 0) {
            echo 'false';exit();
        }
        $model_goods = Model('designer_work');
        $condition['id']=$commonid;
        $goodscommon_list = $model_goods->getDesignerWorkInfo($condition);
        
       $pic_arr = explode(',', $goodscommon_list);
        if (empty($pic_arr)) {
            echo 'false';exit();
        }
//        $goods_list = $model_goods->getGoodsList(array('goods_commonid' => $commonid), 'goods_id,goods_spec,store_id,goods_price,goods_serial,goods_storage,goods_image');
//        if (empty($goods_list)) {
//            echo 'false';exit();
//        }

       // $spec_name = array_values((array)unserialize($goodscommon_list['spec_name']));
        foreach ($pic_arr as $key => $val) {
           // $goods_spec = array_values((array)unserialize($val['goods_spec']));
           // $spec_array = array();
//            foreach ($goods_spec as $k => $v) {
//                $spec_array[] = '<div class="goods_spec">' . $spec_name[$k] . L('nc_colon') . '<em title="' . $v . '">' . $v .'</em>' . '</div>';
//            }
            $goods_list[$key]['goods_image'] = thumb($val, '60');
            $goods_list[$key]['goods_spec'] = implode('', $spec_array);
            $goods_list[$key]['url'] = urlShop('goods', 'index', array('goods_id' => $val['goods_id']));
        }

        /**
         * 转码
         */
        if (strtoupper(CHARSET) == 'GBK') {
            Language::getUTF8($goods_list);
        }
        echo json_encode($goods_list);
    }
    
    
         /**
     * 审核需求
     */
    public function dw_verifyOp(){
        if (chksubmit()) {
            $commonids = $_POST['commonids'];
            $commonid_array = explode(',', $commonids);
            foreach ($commonid_array as $value) {
                if (!is_numeric($value)) {
                    showDialog(L('nc_common_op_fail'), 'reload');
                }
            }
            $update2 = array();
            $update2['dw_verify'] = intval($_POST['verify_state']);
            
            $update1 = array();
            $update1['dw_result'] = trim($_POST['verify_reason']);
            $update1 = array_merge($update1, $update2);
            $where = array();
            $where['dw_id'] = array('in', $commonid_array);
            
            Model('decoration')->editDwCommon($update1, $where);
            showDialog(L('nc_common_op_succ'), 'reload', 'succ');
        }
        Tpl::output('commonids', $_GET['id']);
        Tpl::showpage('decoration.verify_remark', 'null_layout');
    }
    
    
    
}
