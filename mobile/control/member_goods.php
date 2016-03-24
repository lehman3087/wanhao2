<?php
/**
 * 购买
 *
 *
 *
 *
 * by 33hao.com 好商城V3 运营版
 */

//use Shopnc\Tpl;

defined('InShopNC') or exit('Access Invalid!');

class member_goodsControl extends mobileMemberControl {

	public function __construct() {
		parent::__construct();
	}


    public function goods_detailOp() {
       // var_dump($this->member_info['member_name']);
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
		//print_r($goods_info);
		$IsHaveBuy=0;
		if(!empty($this->member_info['member_name']))
		{
		   $model_member = Model('member');
		   $member_info= $model_member->getMemberInfo(array('member_name'=>$this->member_info['member_name']));
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
		
        //评价信息
     //   $goods_evaluate_info = Model('evaluate_goods')->getEvaluateGoodsInfoByGoodsID($goods_id);
      //  Tpl::output('goods_evaluate_info', $goods_evaluate_info);
        
	//$goods_id = intval($_GET['goods_id']);
        $goods_detail['goods_comments']=$this->_get_comments($goods_id, $_REQUEST['type'], 3);
        
        
      Model('goods_browse')->addViewedGoods($goods_id,$this->member_info['member_id'],$goods_detail['goods_info']['store_id']);
       
         
         
        output_data($goods_detail);
        
    }
    
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
    


}

