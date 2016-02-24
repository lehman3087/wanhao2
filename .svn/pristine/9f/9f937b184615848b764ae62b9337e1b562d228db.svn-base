<?php
/**
 * 会员模型
 *
 *
 *
 *
 * by 33hao 好商城V3  www.33hao.com 开发
 */
defined('InShopNC') or exit('Access Invalid!');
class decorationModel extends Model {

    public function __construct(){
        parent::__construct('decoration');
    }
    const STATE1 = 1;       // 竞标中
    const STATE0 = 0;       // 竞标中断
    const STATE2 = 2;     //   标书饱和
    const STATE3 = 3;     //   定标完成
    
    private $states=array(
        '0'=>'用户取消',
        '1'=>'竞标中',
        '2'=>'征满',
        '3'=>'已定标'
    );
    
    public function getStates() {
        return $this->states;
    }
    
    const VERIFY1 = 1;      // 审核通过
    const VERIFY0 = 0;      // 审核失败
    const VERIFY10 = 10;    // 等待审核
    
    


    public function get_category() {
      //  $decoration_category = C('decoration_category')?unserialize(C('decoration_category')):array();
        
        $model_setting = Model('setting');
        $list_setting = $model_setting->getListSetting();
        if ($list_setting['decoration_category'] != ''){
            $decoration_category = mb_unserialize($list_setting['decoration_category']);
	}
        
       $decoration_category = array_map("base64_decode",$decoration_category);
       //var_dump($decoration_category);
      // exit();
//
//        var_dump(C('decoration_catigory'));
//        exit();
	return $decoration_category;
    }
    
    
        public function get_decoration_config() {
      //  $decoration_category = C('decoration_category')?unserialize(C('decoration_category')):array();
        
        $model_setting = Model('setting');
        $list_setting = $model_setting->getListSetting();
        if ($list_setting['decoration_bid_count'] != ''){
            $decoration_config = mb_unserialize($list_setting['decoration_config']);
	}
        
       $decoration_config = array_map("base64_decode",$decoration_config);
       //var_dump($decoration_category);
      // exit();
//
//        var_dump(C('decoration_catigory'));
//        exit();
	return $decoration_config;
    }
    
    
    
    
    
    public function get_style() {
        $model_setting = Model('setting');
        $list_setting = $model_setting->getListSetting();
        if ($list_setting['decoration_style'] != ''){
        $decoration_style = mb_unserialize($list_setting['decoration_style']);
	}
        $decoration_style = array_map("base64_decode",$decoration_style);
	return $decoration_style;
    }
    
     public function update_category($data) {
         
  //      $model_setting = Model('setting');
//        $list_setting = $model_setting->getListSetting();
//        if ($list_setting['decoration_category'] != ''){
//            $list = mb_unserialize($list_setting['decoration_category']);
//	}
//        $model_setting->
//        $decoration_category = C('decoration_category')?unserialize(C('decoration_category')):array();
        $condition['name']='decoration_category';
        $update['value']=  serialize($data);
        // $update = $this->table('member')->where('name=decoration_category')->update($data);
        $s= $this->table('setting')->where("`name`='decoration_category'")->update($update);
        //exit($s);
//        var_dump(C('decoration_catigory'));
//        exit();
	//return $decoration_category;
    }
    
      public function update_style($data) {
        $update['value']=  serialize($data);
        $s= $this->table('setting')->where("`name`='decoration_style'")->update($update);
    }
    
    
    /**
     * 装修需求列表－商管使用
     *
     * @param array $condition 条件
     * @param array $field 字段
     * @param string $page 分页
     * @param string $order 排序
     * @return array
     */
    public function getWorkCommonList($condition, $field = '*', $page = 10, $order = 'dw_id desc') {
       // $condition = $this->_getRecursiveClass($condition);
        return $this->table('decoration_work')->field($field)->where($condition)->order($order)->page($page)->select();
    }
    
     /**
     * 装修需求列表－商管使用
     *
     * @param array $condition 条件
     * @param array $field 字段
     * @param string $page 分页
     * @param string $order 排序
     * @return array
     */
    public function getExtWorksCommonList($condition, $field = '*', $page = 10, $order = 'dw_id desc') {
       // $condition = $this->_getRecursiveClass($condition);
        $works = $this->table('decoration_work')->field($field)->where($condition)->order($order)->page($page)->select();
    
        $works = $this->getExtWorkListDc($works);
        return $works;
    }
    
    
    
    public function getExtWorkListDc($param) {
        foreach ($param as $key => $value) {
           $condition['bid_work_id'] = $value['dw_id'];
           $condition['bid_state'] = array('gt',0);
          // $condition2['bt_rid'] = $value['dw_id'];
          // var_dump($condition['bid_work_id']);
           $param[$key]['ext']=$this->table('bid,store')->field($field)->join('left')->on('bid.bid_dc_id=store.store_id')->where($condition)->select();
         //  $param[$key]['win']=$this->table('bid_target')->field($field)->where($condition2)->find();
          // $param[$key]['win_id']=$param[$key]['win']['bt_bid'];
        }
        return $param;
    }
    
        public function getExtWorkForApp($param) {
        foreach ($param as $key => $value) {
           $condition['bid_work_id'] = $value['dw_id'];
           $condition['bid_state'] = array('gt',0);
          // $condition2['bt_rid'] = $value['dw_id'];
          // var_dump($condition['bid_work_id']);
           $param[$key]['bid_count']=$this->table('bid')->where($condition)->count();
          // $param[$key]['ext']=$this->table('bid,store')->field($field)->join('left')->on('bid.bid_dc_id=store.store_id')->where($condition)->select();
         //  $param[$key]['win']=$this->table('bid_target')->field($field)->where($condition2)->find();
          // $param[$key]['win_id']=$param[$key]['win']['bt_bid'];
        }
        return $param;
    }
    
    
    
    public function getExtWorkDc($param) {
        
        
           $condition['bid_work_id'] = $param['dw_id'];
          // var_dump($condition['bid_work_id']);
           $param[$key]['ext']=$this->table('bid,store')->field($field)->join('inner')->on('bid.bid_dc_id=store.store_id')->where($condition)->find();
        
        return $param;
    }
    
    public function getExtWorkUser($param) {
        
        
           $condition['bid_work_id'] = $param['dw_id'];
           $condition['bid_state'] = array('gt',0);
         //  $condition2['bt_rid'] = $value['dw_id'];
          // var_dump($condition['bid_work_id']);
           $param['ext']=$this->table('bid,store')->field($field)->join('left')->on('bid.bid_dc_id=store.store_id')->where($condition)->select();
         //  $win=$this->table('bid_target')->field($field)->where($condition2)->find();
        //   $param['win_id']=$win['bt_bid'];
         //  $param['win_id']=$win['bt_bid'];
           if(!empty($param['ext'])){
               foreach ($param['ext'] as $key => $value) {
                    $condition1['designer_work.sn_store_id']=$value['store_id'];
                    $condition2['sn_style']=$param['dw_style'];
                    $condition2['sn_store_id']=$value['store_id'];
                    $param['ext'][$key]['designer_works']=Model('designer_work')->getDesignerWorkListweb($condition1,'*',4);
                    $param['ext'][$key]['designer_works_relate_count']=Model('designer_work')->getDesignerWorkCount($condition2);
                }
           }
           
           
           
            return $param;
    }
    
    
    
        /**
     * 装修需求列表
     *
     * @param array $condition 条件
     * @param string $field 字段
     * @param string $group 分组
     * @param string $order 排序
     * @param int $limit 限制
     * @param int $page 分页
     * @param boolean $lock 是否锁定
     * @return array 二维数组
     */
    public function getWorkList($condition, $field = '*', $page = '',$order = '', $limit = 0,  $group= 0, $lock = false, $count = 0) {

        //$condition = $this->_getRecursiveClass($condition);
        return $this->table('decoration_work')->field($field)->where($condition)->group($group)->order($order)->limit($limit)->page($page, $count)->lock($lock)->select();
    }
    
    
     /**
     * 竞标中需求列表
     *
     * @param array $condition 条件
     * @param string $field 字段
     * @param string $group 分组
     * @param string $order 排序
     * @param int $limit 限制
     * @param int $page 分页
     * @param boolean $lock 是否锁定
     * @return array
     */
    public function getworkCommonOnlineList($condition, $field = '*', $page = 0, $order = 'id desc', $limit = 0, $group = '', $lock = false, $count = 0) {
        $condition['sn_state']   = self::STATE1;
        $condition['sn_verify']  = self::VERIFY1;
        return $this->getWorkList($condition, $field,$page, $order, $limit, $group, $lock, $count);
    }
    
         /**
     * 竞标中需求列表（装修公司可看）
     *
     * @param array $condition 条件
     * @param string $field 字段
     * @param string $group 分组
     * @param string $order 排序
     * @param int $limit 限制
     * @param int $page 分页
     * @param boolean $lock 是否锁定
     * @return array
     */
    public function getworkCommonOnlineListForDc($condition, $field = '*', $page = 0, $order = 'dw_id desc', $limit = 0, $group = '', $lock = false, $count = 0) {

        $condition['dw_verify']  = self::VERIFY1;
        return $this->getWorkList($condition, $field, $group, $order, $limit, $page, $lock, $count);
    }
    
    
     /**
     * 竞标中需求详情
     *
     * @param array $condition 条件
     * @param string $field 字段
     */
   public function getRequestInfo($condition, $field = '*') {
        return $this->table('decoration_work')->field($field)->where($condition)->find();
    }
    
    
    
     /**
     * 兴建需求
     *
     * @param array $condition 条件
     */
    public function addBt($insert) {
        return $this->table('decoration_work')->insert($insert);
    } 
    
    
        /**
     * 违规下架
     *
     * @param array $update
     * @param array $condition
     * @return boolean
     */
    public function editDwLockUp($update, $condition) {
        $update_param['dw_state'] = self::STATE0;
        $update = array_merge($update, $update_param);
        $return = $this->editDwCommon($condition, $update);
        if ($return) {
            // 商品违规下架发送店铺消息
            $common_list = $this->getWorkList($condition, 'goods_commonid,store_id,goods_stateremark', 0);
            foreach ($common_list as $val) {
                $param = array();
                $param['remark'] = $val['goods_stateremark'];
                $param['common_id'] = $val['goods_commonid'];
                $this->_sendStoreMsg('goods_violation', $val['store_id'], $param);
            }
            return true;
        } else {
            return false;
        }
    }
    
    
        /**
     * 更新商品数据
     * @param array $update 更新数据
     * @param array $condition 条件
     * @return boolean
     */
    public function editDwCommon($update, $condition) {
        return $this->table('decoration_work')->where($condition)->update($update);
    }
    
    
    
     /**
     * 删除需求
     *
     * @param array $condition 条件
     */
    public function delBt($condition) {
        return $this->table('decoration_work')->where($condition)->delete();
    } 
    
    
    public function cancelBt($param,$condition) {
        return $this->table('decoration_work')->where($condition)->update($param);
    }
    
        /**
     * 等待审核或审核失败的需求列表
     *
     * @param array $condition 条件
     * @param array $field 字段
     * @param string $page 分页
     * @param string $order 排序
     * @return array
     */
    public function getWorksCommonWaitVerifyList($condition, $field = '*', $page = 10, $order = "dw_id desc") {
        if (!isset($condition['dw_verify'])) {
            $condition['dw_verify']  = self::VERIFY10;
            $condition['dw_state']  = array('not in',array(self::STATE0));
        }
        return $this->getWorkList($condition, $field, $page, $order);
    }
    
        /**
     * 更新商品信息
     *
     * @param array $condition
     * @param array $update1
     * @param array $update2
     * @return boolean
     */
    public function editDws($condition, $update1, $update2 = array()) {
        $update2 = empty($update2) ? $update1 : $update2;
        $goods_array = $this->getGoodsCommonList($condition, 'dw_id', 0);
        if (empty($goods_array)) {
            return true;
        }
        $commonid_array = array();
        foreach ($goods_array as $val) {
            $commonid_array[] = $val['dw_id'];
        }
        $return1 = $this->editGoodsCommonById($update1, $commonid_array);
        $return2 = $this->editGoods($update2, array('dw_id' => array('in', $commonid_array)));
        if ($return1 && $return2) {
            return true;
        } else {
            return false;
        }
    }
    
    

    
    }