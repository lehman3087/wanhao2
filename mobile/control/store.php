<?php
/**
 * 商品
 *
 *
 *
 * by 33hao.com 好商城V3 运营版
 */
defined('InShopNC') or exit('Access Invalid!');
class storeControl extends mobileHomeControl{

	public function __construct() {
            
        parent::__construct();
        
    }

    /**
     * 商品列表
     */
    public function goods_listOp() {
        $model_goods = Model('goods');

        //查询条件
        $condition = array();
        if(!empty($_REQUEST['store_id']) && intval($_REQUEST['store_id']) > 0) {
            $condition['store_id'] = $_REQUEST['store_id'];
        } elseif (!empty($_REQUEST['keyword'])) { 
            $condition['goods_name|goods_jingle'] = array('like', '%' . $_REQUEST['keyword'] . '%');
        }

        //所需字段
        $fieldstr = "goods_id,goods_commonid,store_id,goods_name,goods_price,goods_marketprice,goods_image,goods_salenum,evaluation_good_star,evaluation_count";

        //排序方式
        $order = $this->_goods_list_order($_REQUEST['key'], $_REQUEST['order']);

        $goods_list = $model_goods->getGoodsListByColorDistinct($condition, $fieldstr, $order, $this->page);
        $page_count = $model_goods->gettotalpage();

        //处理商品列表(团购、限时折扣、商品图片)
        $goods_list = $this->_goods_list_extend($goods_list);

        output_data(array('goods_list' => $goods_list), mobile_page($page_count));
    }

    /**
     * 商品列表排序方式
     */
    private function _goods_list_order($key, $order) {
        $result = 'goods_id desc';
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
     * 处理商品列表(团购、限时折扣、商品图片)
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
            //团购
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

            unset($goods_list[$key]['store_id']);
            unset($goods_list[$key]['goods_commonid']);
            unset($goods_list[$key]['nc_distinct']);
        }

        return $goods_list;
    }

    /**
     * 店铺详细页
     */
    public function store_detailOp() {
        
        $store_id = intval($_REQUEST['store_id']);
        // 商品详细信息
        $model_store = Model('store');
        $conditionall['store_id']=$store_id;
        
        $store_info = $model_store->getStoreOnlineInfoByID($store_id);
        
       
        
        if (empty($store_info)) {
            output_error('404');
        }
        
        
      
        

        $store_detail['store_pf'] = $store_info['store_credit'];
        $store_detail['store_info'] = $store_info;
      //  $store_detail['store_banner'] = getStoreLogo($store_info['store_banner'],'store_banner');
        
        
//        var_dump($store_detail);
//        exit();
        
         
        // //店铺导航
         $model_store_navigation = Model('store_navigation');
         $store_navigation_list = $model_store_navigation->getStoreNavigationList(array('sn_store_id' => $store_id));
         $store_detail['store_navigation_list'] = $store_navigation_list;
         //幻灯片图片
         
         
         if($this->store_info['store_slide'] != '' && $this->store_info['store_slide'] != ',,,,'){
             $store_detail['store_slide'] = explode(',', $this->store_info['store_slide']);
             $store_detail['store_slide_url'] = explode(',', $this->store_info['store_slide_url']);
         }
         
         
         
        
        //店铺详细信息处理
         $store_detail = $this->_store_detail_extend($store_info);
         
         $store_detail['p_bundling_count'] =  Model('p_bundling')->getOpenBundlingCount($conditionall);
         $store_detail['groupbuy_count'] =  Model('groupbuy')->getGroupbuyCount($conditionall);
         $store_detail['p_xianshi_count'] =  Model('p_xianshi')->getXianshiListCount($conditionall);
         $store_detail['p_mansong_count'] =  Model('p_mansong')->getMansongCountByStoreID($store_id);
         
         $con['store_id']=$store_id;
         $con['opening']=1;
         $con['activity_state']=1;
         $store_detail['p_signup_count'] = Model('activity')->getCount($con);
                 //Model('activity')->getMansongCountByStoreID($store_id);
         
         //$store_detail['store_info']['p_mansong_count'] =  Model('p_mansong')->getMansongCountByStoreID($store_id);
        
        $where = array();
	$where['strace_state'] = 1;
        $where['strace_type'] = 2;
	$where['strace_storeid'] = $store_id;
         
         $model_stracelog = Model('store_sns_tracelog');
         $store_detail['strace_count']=$model_stracelog->getStoreSnsTracelogCount($where);
         
        if(!empty($this->member_info['member_id'])){
            $favorites_model = Model('favorites');
       //   Model('goods_browse')->addViewedGoods($goods_id,$this->member_info['member_id'],$goods_detail['goods_info']['store_id']);
            $favorites_info = $favorites_model->getOneFavorites(array('fav_id'=>"$store_id",'fav_type'=>'store','member_id'=>"{$this->member_info['member_id']}"));
            if(!empty($favorites_info)){
                    $store_detail['member_collected']=1;
                }else{
                $store_detail['member_collected']=0;
            }
          
        }
        
        	
        $store_detail['store_banner'] = getStoreLogo($store_info['store_banner'],'store_banner');
         output_data($store_detail);
         
    }

    /**
     * 店铺详细信息处理
     */
    private function _store_detail_extend($store_detail) {
        //整理数据
        unset($store_detail['store_info']['goods_commonid']);
        unset($store_detail['store_info']['gc_id']);
        unset($store_detail['store_info']['gc_name']);
        // unset($goods_detail['goods_info']['store_id']);
        // unset($goods_detail['goods_info']['store_name']);
        unset($store_detail['store_info']['brand_id']);
        unset($store_detail['store_info']['brand_name']);
        unset($store_detail['store_info']['type_id']);
        unset($store_detail['store_info']['goods_image']);
        unset($store_detail['store_info']['goods_body']);
        unset($store_detail['store_info']['goods_state']);
        unset($store_detail['store_info']['goods_stateremark']);
        unset($store_detail['store_info']['goods_verify']);
        unset($store_detail['store_info']['goods_verifyremark']);
        unset($store_detail['store_info']['goods_lock']);
        unset($store_detail['store_info']['goods_addtime']);
        unset($store_detail['store_info']['goods_edittime']);
        unset($store_detail['store_info']['goods_selltime']);
        unset($store_detail['store_info']['goods_show']);
        unset($store_detail['store_info']['goods_commend']);

        return $store_detail;
    }
    
    public function storeBasiclistOp() {
            error_reporting(0);
            
            $post=$this->read_json();
            $model_store = Model('store');
            
            //var_dump($_REQUEST['param'][0]);
           //  $post->conditions->store_apply_type = 0;
            //$model_store=  Model('seller');
             
           //  var_dump($post);
          //  exit('123');
            $storeList=$model_store->getStoreOnlineIdArray($post->conditions,$post->pageCount,$post->sortType);
            
//            var_dump($storeList);
//            exit();
            $storeListBasic = $model_store-> getStoreInfoBasic($storeList);
            
            $count=$model_store->getStoreCount2($post->conditions);
            
            $storeListBasic= array_values($storeListBasic);
            
            if($count>0){
                output_data(array('storeBasic_list' => $storeListBasic), mobile_page($count));
               // output_data($storeList,array('statuCode'=>array('10200'),'total'=>$count));
            }else{
                output_error('10404');
            }
    }
    
    
        public function functionName($param) {
                
                
        }
        
//        public function store_activityOp() {
//         
//            
//        
//        if(empty($_REQUEST['store_id'])){
//            output_error('10404');
//        }
//         $conditionall['store_id']=$_REQUEST['store_id'];     
//         $store['groupbuy_list'] =  Model('groupbuy')->getGroupbuyOnlineList($conditionall, $this->page);
//         $store['xianshi_list'] =  Model('p_xianshi')->getXianshiList($conditionall,$this->page);
//         
//         $condition_arr['order'] = 'activity_id desc';
//            $condition_arr['store_id'] = $_SESSION['store_id'];
//		//活动列表
////		$page	= new Page();
////		$page->setEachNum(5);
////		$page->setStyle('admin');
//		$store['signup_list']= Model('activity')->getList($conditionall,$this->page);
//                
//                
//         output_data(array('store_acts'=>$store));
//         
//            
//        }
        
        
                        /**
	 * 所有优惠
	 */
        public function store_activitysOp(){
                
            
                        $activity_type = $_REQUEST['activity_type'];
                        $store_id=intval($_REQUEST['store_id']);
                        if($store_id>0){
                           $conditionall['store_id']= $store_id;
                        }
                        
                        
                        if(($activity_type=='xianshis')||empty($activity_type)){
                            
                           $xs=Model('p_xianshi')->getXianshiList($conditionall,$this->page);
                            foreach ($xs as $key1 => $value1) {
                           $model_xianshi_goods = Model('p_xianshi_goods');
                            $condition['xianshi_id'] = $value1['xianshi_id'];
                            $xianshi_goods_list = $model_xianshi_goods->getXianshiGoodsExtendList($condition);
                          // $xs_details = Model('p_xianshi_goods')->getXianshiInfoByID($value1['xianshi_id']);
                           $xs[$key1]['xs_goods_list']=$xianshi_goods_list;
                        }
                         $activities['xianshis']=$xs;
                         $count =  Model('p_xianshi')->getXianshiListCount($conditionall);
                        }
                        
                        if(($activity_type=='groupbuys')||empty($activity_type)){
                            $gb=Model('groupbuy')->getGroupbuyAvailableList($conditionall,$this->page); 
                            $activities['groupbuys']=$gb;
                            $count =  Model('groupbuy')->getGroupbuyCount($conditionall);
                        }
                        
//                        if(($activity_type=='groupbuys')||empty($activity_type)){
//                            $gb=Model('groupbuy')->getGroupbuyAvailableList($conditionall,$this->page); 
//                            $activities['groupbuys']=$gb;
//                            $count =  Model('groupbuy')->getGroupbuyCount($conditionall);
//                        }
                        
                        if(($activity_type=='signups')||empty($activity_type)){
                           $as = Model('activity')->getList($conditionall,$this->page);
//                            $gb=Model('groupbuy')->getGroupbuyAvailableList($conditionall,$this->page); 
//                            $activities['groupbuys']=$gb;
                           $activities['signup_list']=$as;
                           // $count =  Model('activity')->gettotalpage();
                        }
                        
                        
                        
                        
                     //   condition_arr['store_id'] = $_SESSION['store_id'];
		//活动列表
//		$page	= new Page();
//		$page->setEachNum(5);
//		$page->setStyle('admin');
		//$store['signup_list']= Model('activity')->getList($conditionall,$this->page);
                        
                        
                        
                        output_data($activities, mobile_page($count));
                
	}
        
        
        /**
	 * 一条SNS动态及其评论
	 */
	public function straceinfoOp(){
		$stid = intval($_REQUEST['strace_id']);
		if($stid <= 0){
                    output_error('error');
			//showMessage(Language::get('para_error'),'','','error');
		}
		$model_stracelog = Model('store_sns_tracelog');
		$strace_info = $model_stracelog->getStoreSnsTracelogInfo(array('strace_id' => $stid));
		if(!empty($strace_info)){
			if($strace_info['strace_content'] == ''){
				$content = $model_stracelog->spellingStyle($strace_info['strace_type'], json_decode($strace_info['strace_goodsdata'],true));
				$strace_info['strace_content'] = str_replace("%siteurl%", SHOP_SITE_URL.DS, $content);
			}
		}
                output_data(array('strace_info'=>$strace_info));
	}
        
        
        /**
	 * 评论前10条记录
	*/
	public function commenttopOp(){
		$stid = intval($_REQUEST['id']);
		if($stid > 0){
			$model_storesnscomment = Model('store_sns_comment');
			//查询评论总数

			$where = array(
						'strace_id'=>$stid,
						'scomm_state'=>1
					);
			$countnum = $model_storesnscomment->getStoreSnsCommentCount($where);
                        var_dump($countnum);
                        exit();
			//动态列表
			$commentlist = $model_storesnscomment->getStoreSnsCommentList($where, '*', 'scomm_id desc', 10);

			// 更新评论数量
			Model('store_sns_tracelog')->editStoreSnsTracelog(array('strace_comment'=>$countnum), array('strace_id'=>$stid));
		}
		$showmore = '0';//是否展示更多的连接
		if ($countnum > count($commentlist)){
			$showmore = '1';
		}
                
                
                
		Tpl::output('countnum',$countnum);
		Tpl::output('showmore',$showmore);
		Tpl::output('showtype',1);//页面展示类型 0表示分页 1表示显示前几条
		Tpl::output('stid',$stid);

		//验证码
		Tpl::output('nchash',substr(md5(SHOP_SITE_URL.$_GET['act'].$_GET['op']),0,8));

		//允许插入新记录的最大条数
		Tpl::output('max_recordnum',self::MAX_RECORDNUM);

		Tpl::output('commentlist',$commentlist);
		Tpl::showpage('store_snscommentlist','null_layout');
	}
        
        /**
	 * 某会员的SNS动态列表
	 */
	public function tracelistOp(){
		$tracelog_model = Model('store_sns_comment');
		$condition = array();
                $stid = intval($_REQUEST['id']);
		$condition['strace_id'] = $stid;
                $condition['scomm_state']=1;
//		switch ($this->relation){
//			case 3:
//				$condition['trace_privacyin'] = "";
//				break;
//			case 2:
//				$condition['trace_privacyin'] = "0','1";
//				break;
//			case 1:
//				$condition['trace_privacyin'] = "0";
//				break;
//			default:
//				$condition['trace_privacyin'] = "0";
//				break;
//		}
//		$condition['trace_state'] = "0";
                
                
		$count = $tracelog_model->getStoreSnsCommentCount($condition);
//                var_dump($count);
//                exit();
		//分页
		$page	= new Page();
		$page->setEachNum(30);
		$page->setStyle('admin');
		$page->setTotalNum($count);
		$delaypage = intval($_REQUEST['delaypage'])>0?intval($_REQUEST['delaypage']):1;//本页延时加载的当前页数
		$lazy_arr = lazypage(10,$delaypage,$count,true,$page->getNowPage(),$page->getEachNum(),$page->getLimitStart());
		//动态列表
		//$condition['limit'] = $lazy_arr['limitstart'].",".$lazy_arr['delay_eachnum'];
                $tracelist = $tracelog_model->getStoreSnsCommentList($condition, '*', 'scomm_id desc', $lazy_arr['limitstart'],$lazy_arr['delay_eachnum']);
		//$tracelist = $tracelog_model->getStoreSnsCommentList($condition);
                var_dump($tracelist);
                exit();
//		if (!empty($tracelist)){
//			foreach ($tracelist as $k=>$v){
//				if ($v['trace_title']){
//					$v['trace_title'] = str_replace("%siteurl%", SHOP_SITE_URL.DS, $v['trace_title']);
//					$v['trace_title_forward'] = '|| @'.$v['trace_membername'].Language::get('nc_colon').preg_replace("/<a(.*?)href=\"(.*?)\"(.*?)>@(.*?)<\/a>([\s|:|：]|$)/is",'@${4}${5}',$v['trace_title']);
//				}
//				if(!empty($v['trace_content'])){
//					//替换内容中的siteurl
//					$v['trace_content'] = str_replace("%siteurl%", SHOP_SITE_URL.DS, $v['trace_content']);
//				}
//				$tracelist[$k] = $v;
//			}
//		}
		Tpl::output('hasmore',$lazy_arr['hasmore']);
		Tpl::output('tracelist',$tracelist);
		Tpl::output('show_page',$page->show());
		Tpl::output('type','home');
		//验证码
		Tpl::output('nchash',substr(md5(SHOP_SITE_URL.$_GET['act'].$_GET['op']),0,8));
		Tpl::output('menu_sign', 'snstrace');
		Tpl::showpage('sns_tracelist','null_layout');
	}
        
        
    
    
    	public function snsOp(){
		//获得店铺ID
        
		$sid	= intval($_REQUEST['sid']);
		//$this->getStoreInfo($sid);
                
                $model_store = Model('store');
                $store_info = $model_store->getStoreOnlineInfoByID($sid);
                
               
                
		// where 条件
		$where = array();
		$where['strace_state'] = 1;
                $where['strace_type'] = 2;
		$where['strace_storeid'] = $sid;

                
		$model_stracelog = Model('store_sns_tracelog');
		$strace_array = $model_stracelog->getStoreSnsTracelogList($where, '*', 'strace_id desc', 0,$this->page);
		// 整理
                $count=$model_stracelog->getStoreSnsTracelogCount($where);
              
                //if(!empty($strace_array)){
                   output_data(array('strace_array' => $strace_array),mobile_page($count));
                 //   output_data(array('strace_array' => $strace_array,'total'=>$count,'max_recordnum'=>20,'nchash'=>substr(md5('whshop'.$_REQUEST['act'].$_REQUEST['op']),0,8)));
                   //output_data($storeList,array('statuCode'=>array('10200'),'total'=>$count));
               // }else{
                //   output_error('10404');
               // }
            
//		Tpl::output('show_page',$model_stracelog->showpage(2));
		// 最多收藏的会员
//		$favorites = Model('favorites')->getStoreFavoritesList(array('fav_id' => $sid), '*', 0, 'fav_time desc', 8);
//		if (!empty($favorites)) {
//		    $memberid_array = array();
//		    foreach ($favorites as $val) {
//		        $memberid_array[] = $val['member_id'];
//		    }
//		    $favorites_list = Model('member')->getMemberList(array('member_id' => array('in', $memberid_array)), 'member_id,member_name,member_avatar');
//		    Tpl::output('favorites_list', $favorites_list);
//		}
//		Tpl::showpage('store_snshome');
	}
        

    // /**
    //  * 商品详细页
    //  */
    // public function goods_bodyOp() {
    //     $store_id = intval($_REQUEST ['store_id']);

    //     $model_goods = Model('goods');

    //     $goods_info = $model_goods->getGoodsInfo(array('goods_id' => $goods_id));
    //     $goods_common_info = $model_goods->getGoodeCommonInfo(array('goods_commonid' => $goods_info['goods_commonid']));

    //     Tpl::output('goods_common_info', $goods_common_info);
    //     Tpl::showpage('goods_body');
    // }
}
