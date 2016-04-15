<?php
/**
 * 商品
 *
 * by 33hao.com 好商城V3
 *
 *
 */
//by 33hao.com
//use Shopnc\Tpl;

defined('InShopNC') or exit('Access Invalid!');
class goodsControl extends mobileHomeControl{
        
	public function __construct() {
           
            
            parent::__construct();
           
            
    }
    


    /**
     * 商品列表
     */
    public function goods_listOp() {
        $model_goods = Model('goods');
        $model_search = Model('search');
        
//       $post=$this->read_json();  
//        $arr=OTA($post);
//        $_REQUEST=array_merge($_REQUEST,$arr);
        
        $condition=$this->_dealCondition($_REQUEST['conditions']);
        
        
       
        //Model('log').insert();
        //查询条件
       // $condition = array();
        if(!empty($_REQUEST['gc_id']) && intval($_REQUEST['gc_id']) > 0) {
            $condition['gc_id'] = $_REQUEST['gc_id'];
        } elseif (!empty($_REQUEST['keyword'])) {
            $condition['goods_name|goods_jingle'] = array('like', '%' . $_REQUEST['keyword'] . '%');
        }
        
        
        
                $start_price = !empty($_REQUEST['min_price']) && intval($_REQUEST['min_price']) > 0 ? $_REQUEST['min_price'] : null;
		$end_price = !empty($_REQUEST['max_price']) && intval($_REQUEST['max_price']) > 0 ? $_REQUEST['max_price'] : null;
		//$end_unixtime = $if_end_date ? $end_unixtime+86400-1 : null;
                
        
        if ($start_price || $end_price) {
		    $condition['goods_price'] = array('between',"{$start_price},{$end_price}");
	} 
                
        
//        if((!empty($_REQUEST['min_price']) && intval($_REQUEST['min_price']) > 0)&&(!empty($_REQUEST['max_price']) && intval($_REQUEST['max_price']) > 0)) {
//            $condition['goods_price'] = array('between', $_REQUEST['min_price']);
//        
//        if(!empty($_REQUEST['min_price']) && intval($_REQUEST['min_price']) > 0) {
//            $condition['goods_price'] = array('gt', $_REQUEST['min_price']);
//        } elseif (!empty($_REQUEST['max_price']) && intval($_REQUEST['max_price']) > 0) {
//            $condition['goods_price'] = array('lt',$_REQUEST['max_price']);
//        }
        
        
        //所需字段
        $fieldstr = "gc_id_1,gc_id_2,brand_id,goods_id,gc_id,goods_freight,goods_commonid,store_id,goods_name,goods_price,goods_marketprice,goods_image,goods_salenum,evaluation_good_star,evaluation_count";
       // $fields = "goods_id,goods_commonid,goods_name,goods_jingle,gc_id,store_id,store_name,goods_price,goods_promotion_price,goods_promotion_type,goods_marketprice,goods_storage,goods_image,goods_freight,goods_salenum,color_id,evaluation_good_star,evaluation_count,is_virtual,is_fcode,is_appoint,is_presell,have_gift";

        // 添加3个状态字段
        $fieldstr .= ',is_virtual,is_presell,is_fcode,have_gift';
        
        //排序方式
        $order = $this->_goods_list_order($_REQUEST['sortType'], $_REQUEST['sortOrder']);
        
        //优先从全文索引库里查找
        list($indexer_ids,$indexer_count) = $model_search->indexerSearch($_REQUEST,$this->page);
        if (is_array($indexer_ids)) {
            //商品主键搜索
            $goods_list = $model_goods->getGoodsOnlineList(array('goods_id'=>array('in',$indexer_ids)), $fieldstr, 0, $order, $this->page, null, false);
            //如果有商品下架等情况，则删除下架商品的搜索索引信息
            if (count($goods_list) != count($indexer_ids)) {
                $model_search->delInvalidGoods($goods_list, $indexer_ids);
            }
            pagecmd('setEachNum',$this->page);
            pagecmd('setTotalNum',$indexer_count);
        } else {
            
            $goods_list = $model_goods->getGoodsListByColorDistinct($condition, $fieldstr, $order, $this->page);
        }
        $page_count = $model_goods->gettotalpage();

        //处理商品列表(抢购、限时折扣、商品图片)
        $goods_list = $this->_goods_list_extend($goods_list);

        output_data(array('goods_list' => $goods_list), mobile_page($page_count));
    }

    /**
     * 商品列表排序方式
     */
    private function _goods_list_order($key, $order) {
        $result = 'is_own_shop desc,goods_id desc';
        if (!empty($key)) {

            $sequence = 'desc';
            if($order == 1) {
                $sequence = 'asc';
            }

            switch ($key) {
                //销量
                case '1' :
                    $result = 'goods_salenum' . ' ' . $sequence;
                    break;
                //浏览量
                case '2' :
                    $result = 'goods_click' . ' ' . $sequence;
                    break;
                //价格
                case '3' :
                    $result = 'goods_price' . ' ' . $sequence;
                    break;
            }
        }
        return $result;
    }

    
    
    /**
     * 根据分类编号返回下级分类列表几品牌列表
     */
    public function goods_filterOp() {
        
        
       $model_goods = Model('goods');
        $model_search = Model('search');
        
        
        
     //   var_dump('1');
        
       $post=$this->read_json();  
        $arr=OTA($post);
        $_REQUEST=array_merge($_REQUEST,$arr);
        
        $condition=$this->_dealCondition($_REQUEST['conditions']);
        
        
        //Db::insert('log',array('key'=>'1','value'=>  serialize($condition)));
        //Model('log').insert();
        //查询条件
       // $condition = array();
        if(!empty($_REQUEST['gc_id']) && intval($_REQUEST['gc_id']) > 0) {
            $condition['gc_id'] = $_REQUEST['gc_id'];
        } elseif (!empty($_REQUEST['keyword'])) {
            $condition['goods_name|goods_jingle'] = array('like', '%' . $_REQUEST['keyword'] . '%');
        }
       // ->field('DISTINCT order_id')
        //所需字段
        $fieldstr = "DISTINCT(gc_id_1) as gc_id_1";
        
       
        $goods_list = $model_goods->getGoodsOnlineList($condition, $fieldstr,0);

        $data=array();
        foreach ($goods_list as $goods) {
            $data['classes'][]=$this->_get_class_list($goods['gc_id_1']);
        }
        
        $fieldstr2 = "DISTINCT(brand_id) as brand_id";
        
        
        //获得品牌列表
       // $model = Model();
        
        
        
        $goods_list2 = $model_goods->getGoodsOnlineList($condition, $fieldstr2,0);
        $brandIds=array();
        
        foreach ($goods_list2 as $goods) {
            $brandIds[]=$goods['brand_id'];
        }
        
        
        $data['brand_list'] = Model('brand')->field('brand_id,brand_name')->where(array('brand_id'=>array('in',implode(',',$brandIds))))->order('brand_sort asc')->select();
        

        output_data($data);
    }
    
     public function classs_filterOp() {
         
         $gc=$this->_get_class_list($_REQUEST['gc_id']);
         
         $data['classes']=$gc['subClass'];
         $ids=$gc['child'].','.$_REQUEST['gc_id'];
         $data['brand_list'] = Model('brand')->field('brand_id,brand_name')->where(array('class_id'=>array('in',$ids)))->order('brand_sort asc')->select();
        
         output_data($data);
         //var_dump($data);
         
    }
  
    /**
     * 根据分类编号返回下级分类列表
     */
    private function _get_class_list($gc_id) {
        $goods_class_array = Model('goods_class')->getGoodsClassForCacheModel();

        $goods_class = $goods_class_array[$gc_id];
        
       // $data=$goods_class['']
        if(empty($goods_class['child'])) {
            //无下级分类返回0
            return 0;
           // output_data(array('class_list' => '0'));
        } else {
            //返回下级分类列表
            $class_list = array();
            $child_class_string = $goods_class_array[$gc_id]['child'];
            $child_class_array = explode(',', $child_class_string);
            foreach ($child_class_array as $child_class) {
                $class_item = array();
                $class_item['gc_id'] .= $goods_class_array[$child_class]['gc_id'];
                
                $class_item['gc_name'] .= $goods_class_array[$child_class]['gc_name'];
                
                $class_list[] = $class_item;
            }
            $goods_class['subClass']=$class_list;
            return $goods_class;
           // output_data(array('class_list' => $class_list));
        }
    }
    
    
    /**
     * 处理商品列表(抢购、限时折扣、商品图片)
     */
    private function _goods_list_extend($goods_list) {
        //获取商品列表编号数组
        $commonid_array = array();
        $goodsid_array = array();
        foreach($goods_list as $key => $value) {
            $commonid_array[] = $value['goods_commonid'];
            $goodsid_array[] = $value['goods_id'];
        }

        //促销
        $groupbuy_list = Model('groupbuy')->getGroupbuyListByGoodsCommonIDString(implode(',', $commonid_array));
        $xianshi_list = Model('p_xianshi_goods')->getXianshiGoodsListByGoodsString(implode(',', $goodsid_array));
        foreach ($goods_list as $key => $value) {
            //抢购
            if (isset($groupbuy_list[$value['goods_commonid']])) {
                $goods_list[$key]['goods_price'] = $groupbuy_list[$value['goods_commonid']]['groupbuy_price'];
                $goods_list[$key]['group_flag'] = true;
            } else {
                $goods_list[$key]['group_flag'] = false;
            }

            //限时折扣
            if (isset($xianshi_list[$value['goods_id']]) && !$goods_list[$key]['group_flag']) {
                $goods_list[$key]['goods_price'] = $xianshi_list[$value['goods_id']]['xianshi_price'];
                $goods_list[$key]['xianshi_flag'] = true;
            } else {
                $goods_list[$key]['xianshi_flag'] = false;
            }

            //商品图片url
            $goods_list[$key]['goods_image_url'] = cthumb($value['goods_image'], 360, $value['store_id']);

            //unset($goods_list[$key]['store_id']);
            unset($goods_list[$key]['goods_commonid']);
            unset($goods_list[$key]['nc_distinct']);
        }

        return $goods_list;
    }

    public function goods_detailOp() {
        //var_dump('1');
//        $post=$this->read_json();  
//        $arr=objectToArray($post);
//        $_REQUEST=array_merge($_REQUEST,$arr);
        $goods_id = intval($_REQUEST ['goods_id']);
        
        // 商品详细信息
        $model_goods = Model('goods');
        $goods_detail = $model_goods->getGoodsDetail($goods_id);
        
        
        if (empty($goods_detail)) {
            output_error('商品不存在');
        }

        //推荐商品
        $model_store = Model('store');
        $hot_sales = $model_store->getHotSalesList($goods_detail['goods_info']['store_id'], 6);
        $goods_commend_list = array();
        foreach($hot_sales as $value) {
            $goods_commend = array();
            $goods_commend['goods_id'] = $value['goods_id'];
            $goods_commend['goods_name'] = $value['goods_name'];
            $goods_commend['goods_price'] = $value['goods_price'];
            $goods_commend['goods_image_url'] = cthumb($value['goods_image'], 240);
            $goods_commend_list[] = $goods_commend;
        }
        $goods_detail['goods_commend_list'] = $goods_commend_list;
         $store_info = $model_store->getStoreOnlineInfoByID($goods_detail['goods_info']['store_id']);
        // $storeListBasic = $model_store-> getStoreInfoBasic($storeList);
       // $store_info = $model_store->getStoreInfoByID($goods_detail['goods_info']['store_id']);
        $goods_detail['store_info'] = $store_info;

        //商品详细信息处理
        $goods_detail = $this->_goods_detail_extend($goods_detail);
	
      //  var_dump($goods_detail);
        
      //  $goods_detail['spec_value']=  json_encode($goods_detail['spec_value']);	
        
        $goods_detail['goods_info']['specs']=array();
        foreach ($goods_detail['goods_info']['spec_name'] as $key => $value) {
            $array['id']=(string)$key;
            $array['value']=$value;
            $array['select']=$goods_detail['goods_info']['spec_value'][$key];
            $new=array();
            foreach ($array['select'] as $key => $value) {
                $arr['id']=(string)$key;
                $arr['value']=$value;
                $new[]=$arr;
            }
            $array['select']=$new;
            $goods_detail['goods_info']['specs'][]=$array;
        }
	
        
        
	foreach ($goods_detail['goods_info']['spec_value'] as $key => $value) {
            $goods_detail['goods_info']['spec_value'][]['id']=$key;
            $goods_detail['goods_info']['spec_value'][]['value']=$value;
        }	
        
        // 优惠套装
        $array = Model('p_bundling')->getBundlingCacheByGoodsId($goods_id);
        if (!empty($array)) {
            $bundling_arra=unserialize($array['bundling_array']);
            $b_goods_array=unserialize($array['b_goods_array']);
            foreach ($bundling_arra as $key => $value) {
                $bundling_arra[$key]['b_goods_array']=  array_values($b_goods_array[$key]);
            }
            $goods_detail['goods_info']['bundling_array']=array_values($bundling_arra);
           // output_data(array_values($bundling_arra));
            //$bundling_arranew=array_values($array['bundling_array']);
          //  output_data(array('bundling_array'=> unserialize($array['bundling_array']),'b_goods_array', unserialize($array['b_goods_array'])));
           // Tpl::output('bundling_array', unserialize($array['bundling_array']));
           //Tpl::output('b_goods_array', unserialize($array['b_goods_array']));
        }

	
       
        
		//v3-b11 抢购商品是否开始
	$goods_info=$goods_detail['goods_info'];
        $goods_detail['promotion_message']=$this->getptype($goods_detail['goods_info']);

        $goods_detail['goods_comments']=$this->_get_comments($goods_id, $_REQUEST['type'], 3);
        
        if(!empty($this->member_info['member_id'])){
          Model('goods_browse')->addViewedGoods($goods_id,$this->member_info['member_id'],$goods_detail['goods_info']['store_id']);
        }
         
         
        output_data($goods_detail);
        
    }
    
    
    private function getptype($goods_detail) {
        
         if($goods_detail['promotion_type']== '2'){ 
             $xianshi= "<font size=14 color='#ff7419'>直降：¥".$goods_detail['down_price']."</font>";
        
            if($goods_detail['lower_limit']){ 
                $xianshi .= sprintf(" <font size=14 color='#690'>最低%s件起</font> %s",$goods_detail['lower_limit'],$goods_detail['explain']);
            }
            $promotionMessage[]=$xianshi."<br/>";
         }
        
        
        if ($goods_detail['promotion_type'] == '1') {
            if ($goods_detail['upper_limit']) {
                $promotionMessage[]=sprintf(" <font size=14 color='#690'>最多限购%s件</font><br/>",$output['goods']['upper_limit']);
            }

        }
        if ($output['goods']['have_gift'] == '1') {
            $promotionMessage[]="<font size=14 color='#ff7419'>赠品 </font> <font size=14 color='#999'>赠下方的热销商品，赠完即止</font>";
        }
        
        return $promotionMessage;
    }
    
      /**
     * 异步显示优惠套装/推荐组合
     */
    public function get_bundlingOp() {
        $goods_id = intval($_REQUEST['goods_id']);
        if ($goods_id <= 0) {
            exit();
        }
        $model_goods = Model('goods');
        $goods_info = $model_goods->getGoodsOnlineInfoByID($goods_id);
        if (empty($goods_info)) {
            exit();
        }

        // 优惠套装
        $array = Model('p_bundling')->getBundlingCacheByGoodsId($goods_id);
        if (!empty($array)) {
            $bundling_arra=unserialize($array['bundling_array']);
            $b_goods_array=unserialize($array['b_goods_array']);
            foreach ($bundling_arra as $key => $value) {
                $bundling_arra[$key]['b_goods_array']=  array_values($b_goods_array[$key]);
            }
           // output_data(array_values($bundling_arra));
            //$bundling_arranew=array_values($array['bundling_array']);
          //  output_data(array('bundling_array'=> unserialize($array['bundling_array']),'b_goods_array', unserialize($array['b_goods_array'])));
           // Tpl::output('bundling_array', unserialize($array['bundling_array']));
           //Tpl::output('b_goods_array', unserialize($array['b_goods_array']));
        }

        // 推荐组合
        if (!empty($goods_info) && $model_goods->checkIsGeneral($goods_info)) {
            $array = Model('goods_combo')->getGoodsComboCacheByGoodsId($goods_id);
            $gcombo_list=unserialize($array['gcombo_list']);
           // Tpl::output('goods_info', $goods_info);
           // Tpl::output('gcombo_list', unserialize($array['gcombo_list']));
        }
        

         output_data(array('bundling_array'=> array_values($bundling_arra),'goods_combo'=>$gcombo_list));
        

      //  Tpl::showpage('goods_bundling', 'null_layout');
    }
    
    private function goods_all_commentsOp() {
        $goods_id=$_REQUEST['goods_id'];
        $comments=$this->_get_comments($goods_id, $_REQUEST['type'], $this->page);
        if(!empty($comments)){
            output_data(array('goods_evaluate_list'=>$comments));
        }
    }
    
      /**
     * 商品评价详细页
     */
//    public function comments_listOp() {
//        
//        $goods_id = intval($_REQUEST['goods_id']);
//
//        // 商品详细信息
//        $model_goods = Model('goods');
//        $goods_info = $model_goods->getGoodsInfoByID($goods_id, '*');
//        // 验证商品是否存在
//        if (empty($goods_info)) {
//            showMessage(L('goods_index_no_goods'), '', 'html', 'error');
//        }
//        Tpl::output('goods', $goods_info);
//
//        $this->getStoreInfo($goods_info['store_id']);
//
//        // 当前位置导航
//        $nav_link_list = Model('goods_class')->getGoodsClassNav($goods_info['gc_id'], 0);
//        $nav_link_list[] = array('title' => $goods_info['goods_name'], 'link' => urlShop('goods', 'index', array('goods_id' => $goods_id)));
//        $nav_link_list[] = array('title' => '商品评价');
//        Tpl::output('nav_link_list', $nav_link_list );
//
//        //评价信息
//        $goods_evaluate_info = Model('evaluate_goods')->getEvaluateGoodsInfoByGoodsID($goods_id);
//        Tpl::output('goods_evaluate_info', $goods_evaluate_info);
//
//        $seo_param = array ();
//
//        $seo_param['name'] = $goods_info['goods_name'];
//        $seo_param['key'] = $goods_info['goods_keywords'];
//        $seo_param['description'] = $goods_info['goods_description'];
//        Model('seo')->type('product')->param($seo_param)->show();
//
//        $this->_get_comments($goods_id, $_REQUEST['type'], 20);
//
//		Tpl::showpage('goods.comments_list');
//    }
//    
    
  
    /**
     * 商品详细信息处理
     */
    private function _goods_detail_extend($goods_detail) {
        //整理商品规格
        unset($goods_detail['spec_list']);
        $goods_detail['spec_list'] = $goods_detail['spec_list_mobile'];
        unset($goods_detail['spec_list_mobile']);

        //整理商品图片
        unset($goods_detail['goods_image']);
        $goods_detail['goods_image'] = implode(',', $goods_detail['goods_image_mobile']);
        unset($goods_detail['goods_image_mobile']);

        //商品链接
        $goods_detail['goods_info']['goods_url'] = urlShop('goods', 'index', array('goods_id' => $goods_detail['goods_info']['goods_id']));

        //整理数据
        unset($goods_detail['goods_info']['goods_commonid']);
        unset($goods_detail['goods_info']['gc_id']);
        unset($goods_detail['goods_info']['gc_name']);
        unset($goods_detail['goods_info']['store_name']);
        unset($goods_detail['goods_info']['brand_id']);
        unset($goods_detail['goods_info']['brand_name']);
        unset($goods_detail['goods_info']['type_id']);
        unset($goods_detail['goods_info']['goods_image']);
        unset($goods_detail['goods_info']['goods_body']);
        unset($goods_detail['goods_info']['goods_state']);
        unset($goods_detail['goods_info']['goods_stateremark']);
        unset($goods_detail['goods_info']['goods_verify']);
        unset($goods_detail['goods_info']['goods_verifyremark']);
        unset($goods_detail['goods_info']['goods_lock']);
        unset($goods_detail['goods_info']['goods_addtime']);
        unset($goods_detail['goods_info']['goods_edittime']);
        unset($goods_detail['goods_info']['goods_selltime']);
        unset($goods_detail['goods_info']['goods_show']);
        unset($goods_detail['goods_info']['goods_commend']);
        unset($goods_detail['goods_info']['explain']);
        unset($goods_detail['goods_info']['cart']);
        unset($goods_detail['goods_info']['buynow_text']);
        unset($goods_detail['groupbuy_info']);
        unset($goods_detail['xianshi_info']);

        return $goods_detail;
    }

       private function _get_comments($goods_id, $type, $page) {
        $condition = array();
        $condition['geval_goodsid'] = $goods_id;
        switch ($type) {
            case '1':
                $condition['geval_scores'] = array('in', '5,4');
                //Tpl::output('type', '1');
                break;
            case '2':
                $condition['geval_scores'] = array('in', '3,2');
               // Tpl::output('type', '2');
                break;
            case '3':
                $condition['geval_scores'] = array('in', '1');
              //  Tpl::output('type', '3');
                break;
        }
        
        //查询商品评分信息
        $model_evaluate_goods = Model("evaluate_goods");
        $goodsevallist = $model_evaluate_goods->getEvaluateGoodsList($condition, $page);
        return $goodsevallist;
//        Tpl::output('goodsevallist',$goodsevallist);
//        Tpl::output('show_page',$model_evaluate_goods->showpage('5'));
    }
    
    public function get_all_commentsOp() {

        if(empty($_REQUEST['goods_id'])){
            output_error('商品为空');
        }
        $type=$_REQUEST['type'];
        $comments=$this->_get_comments($_REQUEST['goods_id'], $type, $this->page);
        $page_count=Model("evaluate_goods")->gettotalnum();
        output_data(array('goods_comments'=>$comments),  mobile_page($page_count));
    }
    
    /**
     * 商品详细页
     */
    public function goods_bodyOp() {
        $goods_id = intval($_REQUEST ['goods_id']);

        $model_goods = Model('goods');

        $goods_info = $model_goods->getGoodsInfoByID($goods_id, 'goods_commonid');
        $goods_common_info = $model_goods->getGoodeCommonInfoByID($goods_info['goods_commonid']);
        
        output_data($goods_common_info);
//        Tpl::output('goods_common_info', $goods_common_info);
//        Tpl::showpage('goods_body');
    }
	/**
     * 手机商品详细页
     */
	public function wap_goods_bodyOp() {
        $goods_id = intval($_REQUEST ['goods_id']);

        $model_goods = Model('goods');

        $goods_info =$model_goods->getGoodsInfoByID($goods_id, 'goods_id');
        $goods_common_info =$model_goods->getMobileBodyByCommonID($goods_info['goods_commonid']);
        Tpl:output('goods_common_info',$goods_common_info);
        Tpl::showpage('goods_body');
    }
    
    
    public function testOp() {
           $post=$this->read_json();  
        $arr=objectToArray($post);
        $_REQUEST=array_merge($_REQUEST,$arr);
        $goods_id = intval($_REQUEST ['goods_id']);
        

        // 商品详细信息
        $model_goods = Model('goods');
        $goods_detail = $model_goods->getGoodsDetail($goods_id);
        
        
        if (empty($goods_detail)) {
            output_error('商品不存在');
        }

        //推荐商品
        $model_store = Model('store');
        $hot_sales = $model_store->getHotSalesList($goods_detail['goods_info']['store_id'], 6);
        $goods_commend_list = array();
        foreach($hot_sales as $value) {
            $goods_commend = array();
            $goods_commend['goods_id'] = $value['goods_id'];
            $goods_commend['goods_name'] = $value['goods_name'];
            $goods_commend['goods_price'] = $value['goods_price'];
            $goods_commend['goods_image_url'] = cthumb($value['goods_image'], 240);
            $goods_commend_list[] = $goods_commend;
        }
        $goods_detail['goods_commend_list'] = $goods_commend_list;
        $store_info = $model_store->getStoreInfoByID($goods_detail['goods_info']['store_id']);
        $goods_detail['store_info']['store_id'] = $store_info['store_id'];
        $goods_detail['store_info']['store_name'] = $store_info['store_name'];
        $goods_detail['store_info']['member_id'] = $store_info['member_id'];
	//显示QQ及旺旺 好商城V3
	$goods_detail['store_info']['store_qq'] = $store_info['store_qq'];
	$goods_detail['store_info']['store_ww'] = $store_info['store_ww'];
	$goods_detail['store_info']['store_phone'] = $store_info['store_phone'];
        $goods_detail['store_info']['member_name'] = $store_info['member_name'];
        $goods_detail['store_info']['avatar'] = getMemberAvatarForID($store_info['member_id']);

        //商品详细信息处理
        $goods_detail = $this->_goods_detail_extend($goods_detail);
	
      //  var_dump($goods_detail);
        
      //  $goods_detail['spec_value']=  json_encode($goods_detail['spec_value']);	
        
        $goods_detail['goods_info']['specs']=array();
        foreach ($goods_detail['goods_info']['spec_name'] as $key => $value) {
            $array['id']=$key;
            $array['value']=$value;
            $array['select']=$goods_detail['goods_info']['spec_value'][$key];
            $new=array();
            foreach ($array['select'] as $key => $value) {
                $arr['id']=$key;
                $arr['value']=$value;
                $new[]=$arr;
            }
            $array['select']=$new;
            $goods_detail['goods_info']['specs'][]=$array;
        }
	
        
        
	foreach ($goods_detail['goods_info']['spec_value'] as $key => $value) {
            $goods_detail['goods_info']['spec_value'][]['id']=$key;
            $goods_detail['goods_info']['spec_value'][]['value']=$value;
        }	
	

        
		//v3-b11 抢购商品是否开始
		$goods_info=$goods_detail['goods_info'];
		//print_r($goods_info);
		$IsHaveBuy=0;
		if(!empty($_COOKIE['username']))
		{
		   $model_member = Model('member');
		   $member_info= $model_member->getMemberInfo(array('member_name'=>$_COOKIE['username']));
		   $buyer_id=$member_info['member_id'];
		   
		   $promotion_type=$goods_info["promotion_type"];
		   
		   if($promotion_type=='groupbuy')
		   {   
		    //检测是否限购数量
			$upper_limit=$goods_info["upper_limit"];
			if($upper_limit>0)
			{
				//查询些会员的订单中，是否已买过了
				$model_order= Model('order');
				 //取商品列表
                $order_goods_list = $model_order->getOrderGoodsList(array('goods_id'=>$goods_id,'buyer_id'=>$buyer_id,'goods_type'=>2));
				if($order_goods_list)
				{   
				    //取得上次购买的活动编号(防一个商品参加多次团购活动的问题)
				    $promotions_id=$order_goods_list[0]["promotions_id"];
					//用此编号取数据，检测是否这次活动的订单商品。
					 $model_groupbuy = Model('groupbuy');
					 $groupbuy_info = $model_groupbuy->getGroupbuyInfo(array('groupbuy_id' => $promotions_id));
					 if($groupbuy_info)
					 {
						$IsHaveBuy=1;
					 }
					 else
					 {
						$IsHaveBuy=0;
					 }
				}
			}
		  }
		}
		$goods_detail['IsHaveBuy']=$IsHaveBuy;
	
                //var_dump($goods_detail);
		
		

        output_data($goods_detail);
    }
}
