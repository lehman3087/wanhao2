<?php
/**
 * cms首页
 *
 *
 *
 * by 33hao.com 好商城V3 运营版
 */

//use Shopnc\Tpl;

defined('InShopNC') or exit('Access Invalid!');
class indexControl extends mobileHomeControl{

    public function __construct() {
        parent::__construct();
    }

    /**
     * 首页
     */
	public function indexOp() {
        $model_mb_special = Model('mb_special'); 
        $data = $model_mb_special->getMbSpecialIndex();
        $this->_output_special($data, $_REQUEST['type']);
	}
        
        
        public function testpushOp() {
            
            QueueClient::push('sendMemberMsg', $param);
            
        }
        
        
        //首页展位列表
        public function adsOp($param) {
            $model = model('rec_position');
            $condition['rec_app'] = 1;
            $condition['rec_state'] = 1;
            $condition['rec_start_time'] =array('lt',time());
            $condition['rec_stop_time'] =array('gt',time());
            
            $rec_list = $model->where($condition)->order('rec_id desc')->select();
            $rec_new_list=array();
            foreach ($rec_list as $key => $value) {
                $rec_list[$key]['content']= unserialize($value['content']);
                //var_dump($rec_list[$key]['content']);
                $rec_new_list[$value['rec_position']][]=$rec_list[$key];
            }
            $rec_new_list2=array();
            foreach ($rec_new_list as $key => $value) {
                $rec_new_list2[$key]['zhanqu_id']=$key;
                $rec_new_list2[$key]['zhanwei_list']=$value;
            }
            $values = array_values($rec_new_list2);
            
            output_data($values);
        }
        
        //新闻列表 平台活动 
        public function smsOp($param) {
            
        }
        
        public function contactOp($param) {
            if(empty($_REQUEST["contact_name"])||empty($_REQUEST["contact_phone"])){
                output_special_code(10500);
            }
            $insert["contact_name"]=$_REQUEST["contact_name"];
            $insert["contact_phone"]=$_REQUEST["contact_phone"];
            $insert["contact_regin"]=$_REQUEST["contact_regin"];
            $id=Model("contact")->insert($insert);
            if($id>0){
                output_suc('1');
            }
            
        }
        
        
        public function getGlobalOp() {
            $city=$_REQUEST['prefer_cityid'];
            $city=$_REQUEST['bd_city_code_type'];
            $model_decoration_style=  Model('decoration');
            $styles=$model_decoration_style->get_style();
            $model_decoration = Model('decoration');
             $category=$model_decoration->get_category();
             $style=$model_decoration->get_style();
            // Tpl::output('hot_search',@explode(',',C('hot_search')));//热门搜索
             $hot_search=@explode(',',C('hot_search'));
             
//             //广告位
            $global=array(
                'snsTracePath'=>'/shop/index.php?act=store_snshome&op=mobileStraceinfo&st_id=',
                'decoration_style'=>$styles,
                'designer_head'=>'/data/upload/store/{}/designer/header/',//设计师头像路径 {}替换成store_id
                'member_avatar'=>'/data/upload/shop/avatar/',//{}替换成userid,后跟图像名称
                'category'=>$category,
                'style'=>$style,
                'decoration_work_path'=>'/data/upload/shop/store/work/',//案例图片地址
                'decoration_work_rec_path'=>'/data/upload/shop/store/work/rec/',//推荐案例图片地址
                //
                //'decoration_head'=>'/shop/store/work/',//案例图片地址
                'decoration_request_path'=>'/data/upload//shop/member/request/',//后跟会员ID
                'rec_list'=>$rec_list,//广告位
                'act_list'=>$act_list,
                'goods_path'=>'/data/upload/shop/store/goods/',// 后跟商户ID 商户商品图像路径 
                'store_sns_news_path'=>'/data/upload/shop/store/goods/',//店铺动态图像路径
                
                
                'booth_path'=>'/data/upload/shop/rec_position/',//展位基础路径
                'grougbuy_path'=>'/data/upload/shop/groupbuy/',//后跟商户ID 例：/data/upload/shop/groupbuy/1/1_04423393922882448_max.jpg
                
                
                'pf_activity_path'=>'/data/upload/shop/activity/',//平台活动图像路径
                
                'sign_up_activity_path'=>'/data/upload/shop/activity/',//报名活动图像路径
               
                'brand_path'=>'/data/upload/shop/brand/',//品牌图像路径
                'groupbuy_path'=>'/data/upload/shop/groupbuy/',//抢购活动海报路径 例：/data/upload/shop/groupbuy/12/12_05043585915065515_mid.jpg
                'store_banner'=>'/data/upload/shop/store/',//店铺条幅基础地址
                'store_avatar'=>'/data/upload/shop/store/',//店铺装修公司avator
                'hot_search'=>$hot_search,
                 'store_strace_comment_list'=>'/wap/store_sns.html?strace_id='
                );  
             output_data($global);        
        }
        /*
         * 推荐品牌
         */
        public function brandrOp($param) {
         $model = Model();
         $bnum=!empty($_REQUEST['bnum'])?$_REQUEST['bnum']:5;
         $gnum=!empty($_REQUEST['gnum'])?$_REQUEST['gnum']:10;
        $brand_r_list = Model('brand')->getBrandPassedList(array('brand_recommend'=>1) ,'brand_id,brand_name,brand_pic', 0, 'brand_sort asc, brand_id desc', $bnum);
       // $brands = $this->_tidyBrand($brand_c_list);
        $fieldstr = "goods_id,goods_commonid,goods_name,goods_jingle,store_id,store_name,goods_price,goods_promotion_price,goods_promotion_type,goods_marketprice,goods_storage,goods_image,goods_freight,goods_salenum,color_id,evaluation_good_star,evaluation_count,is_virtual,is_fcode,is_appoint,is_presell,have_gift";
        // 条件
        $where = array();
        
        
       foreach ($brand_r_list as $key => $value) {
           // 字段
        $where['brand_id'] = $value['brand_id'];
        $model_goods = Model('goods');
        $goods_list = $model_goods->getGoodsListByColorDistinct($where, $fieldstr, $order, $gnum);
        $brand_r_list[$key]['goods_list']=$goods_list;
       }
       
       output_data($brand_r_list);
        
        }
    /**
     * 专题
     */
    public function specialOp() {
        $model_mb_special = Model('mb_special'); 
        $data = $model_mb_special->getMbSpecialItemUsableListByID($_REQUEST['special_id']);
        $this->_output_special($data, $_REQUEST['type'], $_REQUEST['special_id']);
    }

    /**
     * 输出专题
     */
    private function _output_special($data, $type = 'json', $special_id = 0) {
        $model_special = Model('mb_special');
        if($_REQUEST['type'] == 'html') {
            $html_path = $model_special->getMbSpecialHtmlPath($special_id);
            if(!is_file($html_path)) {
                ob_start();
                Tpl::output('list', $data);
                Tpl::showpage('mb_special');
                file_put_contents($html_path, ob_get_clean());
            }
            header('Location: ' . $model_special->getMbSpecialHtmlUrl($special_id));
            die;
        } else {
            output_data($data);
        }
    }

    /**
     * android客户端版本号
     */
    public function apk_versionOp() {
		$version = C('mobile_apk_version');
		$url = C('mobile_apk');
        if(empty($version)) {
           $version = '';
        }
        if(empty($url)) {
            $url = '';
        }

        output_data(array('version' => $version, 'url' => $url));
    }
    
       public function all_area_listOp() {
        
         if ($data = rkcache('areaarea',true)) {
           // $this->cachedData2 = $data;
           //var_dump('1');
             output_data(array('area_list' => $data));
           // return $data;
        }
        
        $area_id = intval($_REQUEST['area_id']);
        
        $model_area = Model('area');

        $condition = array();

        $condition['area_deep'] = 1;
        
        $area_list = $model_area->getAreaList($condition, 'area_id,area_name');
        foreach ($area_list as $key => $value) {
            $condition2['area_deep'] = 2;
            $condition2['area_parent_id'] = $value['area_id'];
            $area_list2 = $model_area->getAreaList($condition2, 'area_id,area_name');
            $area_list[$key]['chindren_list']=$area_list2;
            foreach ($area_list[$key]['chindren_list'] as $key2 => $value2) {
                $condition3['area_deep'] = 3;
                $condition3['area_parent_id'] = $value2['area_id'];
                $area_list3 = $model_area->getAreaList($condition3, 'area_id,area_name');
                $area_list[$key]['chindren_list'][$key2]['chindren_list']=$area_list3;
            }
        }
        wkcache('areaarea', $area_list);
        //var_dump($area_list);
        output_data(array('area_list' => $area_list));
    }
    
}
