<?php
/**
 * 商品分类
 *
 *
 *
 * by 33hao.com 好商城V3 运营版
 */

//use Shopnc\Tpl;

defined('InShopNC') or exit('Access Invalid!');
class goods_classControl extends mobileHomeControl{

	public function __construct() {
        parent::__construct();
    }

	public function indexOp() {
        if(!empty($_REQUEST['gc_id']) && intval($_REQUEST['gc_id']) > 0) {
            $this->_get_class_list($_REQUEST['gc_id']);
        } else{
          $this-> get_all_category2();
           //  $this->_get_all_class_list();
        }
	}

    /**
     * 返回一级分类列表
     */
    private function _get_root_class() {
	$model_goods_class = Model('goods_class');
        $model_mb_category = Model('mb_category');

        $goods_class_array = Model('goods_class')->getGoodsClassForCacheModel();

	$class_list = $model_goods_class->getGoodsClassListByParentId(0);
        $mb_categroy = $model_mb_category->getLinkList(array());
        $mb_categroy = array_under_reset($mb_categroy, 'gc_id');
        foreach ($class_list as $key => $value) {
            if(!empty($mb_categroy[$value['gc_id']])) {
                $class_list[$key]['image'] = UPLOAD_SITE_URL.DS.ATTACH_MOBILE.DS.'category'.DS.$mb_categroy[$value['gc_id']]['gc_thumb'];
            } else {
                $class_list[$key]['image'] = '';
            }

            $class_list[$key]['text'] = '';
            $child_class_string = $goods_class_array[$value['gc_id']]['child'];
            $child_class_array = explode(',', $child_class_string);
            foreach ($child_class_array as $child_class) {
                $class_list[$key]['text'] .= $goods_class_array[$child_class]['gc_name'] . '/';
            }
            $class_list[$key]['text'] = rtrim($class_list[$key]['text'], '/');
        }

        output_data(array('class_list' => $class_list));
    }

    /**
     * 根据分类编号返回下级分类列表
     */
    private function _get_class_list($gc_id) {
        $goods_class_array = Model('goods_class')->getGoodsClassForCacheModel();

        $goods_class = $goods_class_array[$gc_id];

        if(empty($goods_class['child'])) {
            //无下级分类返回0
            output_data(array('class_list' => '0'));
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
            output_data(array('class_list' => $class_list));
        }
    }
    
       /**
     * 根据分类编号返回下级分类列表
     */
    private function _get_class_list_array($gc_id) {
        $goods_class_array = Model('goods_class')->getGoodsClassForCacheModel();

        $goods_class = $goods_class_array[$gc_id];

        if(empty($goods_class['child'])) {
            //无下级分类返回0
            output_data(array('class_list' => '0'));
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
            return $class_list;
        }
    }
    /**
     * 根据所有分类列表
     */
    private function _get_all_class_list() {
        
        $model_goods_class = Model('goods_class');
        $model_mb_category = Model('mb_category');

        $goods_class_array = Model('goods_class')->getGoodsClassForCacheModel();

	$class_list = $model_goods_class->getGoodsClassListByParentId(0);
        $mb_categroy = $model_mb_category->getLinkList(array());
        $mb_categroy = array_under_reset($mb_categroy, 'gc_id');
        foreach ($class_list as $key => $value) {
            if(!empty($mb_categroy[$value['gc_id']])) {
                $class_list[$key]['image'] = UPLOAD_SITE_URL.DS.ATTACH_MOBILE.DS.'category'.DS.$mb_categroy[$value['gc_id']]['gc_thumb'];
            } else {
                $class_list[$key]['image'] = '';
            }

            $class_list[$key]['text'] = '';
            $child_class_string = $goods_class_array[$value['gc_id']]['child'];
            $child_class_array = explode(',', $child_class_string);
            foreach ($child_class_array as $child_class) {
                $class_list[$key]['text'] .= $goods_class_array[$child_class]['gc_name'] . '/';
            }
            $class_list[$key]['text'] = rtrim($class_list[$key]['text'], '/');
            
            $child_list_array=$this->_get_class_list_array($class_list[$key]['gc_id']);
            $class_list[$key]['children']=$child_list_array;
        }

        output_data(array('class_list' => $class_list));
    }   
    
        /**
     * 前台头部的商品分类
     *
     * @param   number  $update_all   更新
     * @return  array   数组
     */
    public function get_all_categoryOp($update_all = 0) {

        // 不存在时更新或者强制更新时执行
        if ($update_all == 1 || !($gc_list = rkcache('all_categories'))) {
            $class_list = $this->getGoodsClassListAll();
            $gc_list = array();
            $class1_deep = array();//第1级关联第3级数组
            $class2_ids = array();//第2级关联第1级ID数组
            $type_ids = array();//第2级分类关联类型
            if (is_array($class_list) && !empty($class_list)) {
                foreach ($class_list as $key => $value) {
                    $p_id = $value['gc_parent_id'];//父级ID
                    $gc_id = $value['gc_id'];
                    $sort = $value['gc_sort'];
                    if ($p_id == 0) {//第1级分类
                        $gc_list[$gc_id] = $value;
                    } elseif (array_key_exists($p_id,$gc_list)) {//第2级
                        $class2_ids[$gc_id] = $p_id;
                        $type_ids[] = $value['type_id'];
                        $gc_list[$p_id]['class2'][$gc_id] = $value;
                    } elseif (array_key_exists($p_id,$class2_ids)) {//第3级
                        $parent_id = $class2_ids[$p_id];//取第1级ID
                        $gc_list[$parent_id]['class2'][$p_id]['class3'][$gc_id] = $value;
                        $class1_deep[$parent_id][$sort][] = $value;
                    }
                }
                $type_brands = $this->get_type_brands($type_ids);//类型关联品牌
                foreach ($gc_list as $key => $value) {
                    $gc_id = $value['gc_id'];
                    $pic_name = BASE_UPLOAD_PATH.'/'.ATTACH_COMMON.'/category-pic-'.$gc_id.'.jpg';
                    if (file_exists($pic_name)) {
                        $gc_list[$gc_id]['pic'] = UPLOAD_SITE_URL.'/'.ATTACH_COMMON.'/category-pic-'.$gc_id.'.jpg';
                    }
                    $class3s = $class1_deep[$gc_id];

                    if (is_array($class3s) && !empty($class3s)) {//取关联的第3级
                        $class3_n = 0;//已经找到的第3级分类个数
                        ksort($class3s);//排序取到分类
                        foreach ($class3s as $k3 => $v3) {
                            if ($class3_n >= 5) {//最多取5个
                                break;
                            }
                            foreach ($v3 as $k => $v) {
                                if ($class3_n >= 5) {
                                    break;
                                }
                                if (is_array($v) && !empty($v)) {
                                    $p_id = $v['gc_parent_id'];
                                    $gc_id = $v['gc_id'];
                                    $parent_id = $class2_ids[$p_id];//取第1级ID
                                    $gc_list[$parent_id]['class3'][$gc_id] = $v;
                                    $class3_n += 1;
                                }
                            }
                        }
                    }
                    $class2s = $value['class2'];
                    if (is_array($class2s) && !empty($class2s)) {//第2级关联品牌
                        foreach ($class2s as $k2 => $v2) {
                            $p_id = $v2['gc_parent_id'];
                            $gc_id = $v2['gc_id'];
                            $type_id = $v2['type_id'];
                            $gc_list[$p_id]['class2'][$gc_id]['brands'] = $type_brands[$type_id];
                        }
                    }
                }
            }

            wkcache('all_categories', $gc_list);
        }
        
        output_data(array('all_categories'=>$gc_list));
      //  return $gc_list;
    }
    
    public function get_all_category2($param) {
         $model_goods_class = Model('goods_class');
         $list=$model_goods_class->get_all_category2(1);
         
      //   var_dump($list);
         
         output_data(array('good_list'=>$list));
    }
}
