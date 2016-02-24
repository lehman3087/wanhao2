<?php
/**
 * 店铺导航模型
 *
 * 
 *
 *
 */
defined('InShopNC') or exit('Access Invalid!');
class designer_workModel extends Model{

    public function __construct(){
        parent::__construct('designer_work');
    }

	/**
	 * 读取列表 
	 * @param array $condition
	 *
	 */
	public function getDesignerWorkListWeb1($condition, $field='*',$page='', $order='id desc') {
            $result = $this->field($field)->where($condition)->page($page)->order($order)->select();
            return $result;
	}
        
               /**
     * 删除案例
     * @param array $update 更新数据
     * @param array $condition 条件
     * @return boolean
     */
    public function delDwCommon($condition,$reason) {
        $return = $this->where($condition)->delete();
        if ($return) {
            // 商品违规下架发送店铺消息
            
            $common_list = $this->getDesignerWorkListWeb1($condition, 'sn_name,sn_store_id,sn_designer_id');
            foreach ($common_list as $val) {
                Model('designer')->updateDesignerWorkCount(array('designer_id'=>$val['sn_designer_id']));
                $param = array();
                $param['remark'] = $reason;
               // $param['common_id'] = $val['goods_commonid'];
                $this->_sendSMsg('designer_work_del', $val['sn_store_id'], $param);
            }
            return true;
        } else {
            return false;
        }
    }
        
        public function getDesignerWorkList($condition, $field = '*',$page=10,$count=5,$order='sn_collect desc') {
         $condition=$this->_dealCondition($condition);
        // var_dump($condition);
        // exit($condition);
       // $condition = $this->_getRecursiveClass($condition);
        return $this->table('designer_work,designer')->field($field)->on('designer_work.sn_designer_id = designer.id')->join('left')->where($condition)->order($order)->page($page)->select();
        }
        
        
        public function getDesignerWorkListweb($condition, $field = '*',$page=10,$count=5,$order='sn_collect desc') {
       //  $condition=$this->_dealCondition($condition);
       // $condition = $this->_getRecursiveClass($condition);
            $field='designer_work.id as id,designer_work.sn_category,designer_work.sn_area,designer_work.sn_cost,designer_work.sn_style,designer_work.sn_store_id,designer_work.sn_house_type,designer_work.sn_m_pic,designer_work.sn_name,designer_work.sn_collect as sn_collection_count,designer_work.sn_share_count,designer.sn_head,designer.sn_title as designername';
         return $this->table('designer_work,designer')->field($field)->on('designer_work.sn_designer_id = designer.id')->join('inner')->where($condition)->order($order)->page($page)->select();
        }
        
         public function getDesignerWorkListwebNoPage($condition, $field = '*',$count=5,$order='sn_collect desc') {
       //  $condition=$this->_dealCondition($condition);
       // $condition = $this->_getRecursiveClass($condition);
         $field='designer_work.id,designer_work.sn_m_pic,designer_work.sn_name,designer_work.sn_collect as sn_collection_count,designer_work.sn_share_count,designer.sn_head';
         return $this->table('designer_work,designer')->field($field)->on('designer_work.sn_designer_id = designer.id')->join('left')->where($condition)->order($order)->select();
        }
        
        
    
    
      public function _dealCondition($condition) {
        $con=array();
        if(!empty($condition)){
             foreach ($condition as $value) {
                // $con[]=$value->matchKey;
                 $kv=array();
                if($value->matchType==0){
                  $type =  'like';
                  $val="%".$value->matchValue."%";
                }else if($value->matchType==1){
                    $type =  'in';
                    $val=  explode(',',$value->matchValue);
                }else if($value->matchType==2){
                    $type =  'between';
                    $val=$value->matchValue;
                }else if($value->matchType==3){
                    $type =  'gt';
                    $val=$value->matchValue;
                }
                else if($value->matchType==4){
                    $type =  'lt';
                    $val=$value->matchValue;
                }
                $kv[]=$type;
                $kv[]=$val;
                $con[$value->matchKey]=$kv;
                }
        }
       
        return $con;
        
    }
    
    
    public function getDesignerWorktotalpage($condition) {
        $condition=$this->_dealCondition($condition);
        $result = $this->table('designer_work')->where($condition)->count();
        return $result;
        
    }
    
    /**
	 * 读取单条记录
	 * @param array $condition
	 *
	 */
    public function getDesignerWorkInfo($condition) {
        $result = $this->where($condition)->find();
        return $result;
    }

	/*
	 * 增加 
	 * @param array $param
	 * @return bool
	 */
    public function addDesignerWork($param){
        return $this->insert($param);	
    }
	
	/*
	 * 更新
	 * @param array $update
	 * @param array $condition
	 * @return bool
	 */
    public function editDesignerWork($update, $condition){
        return $this->where($condition)->update($update);
    }
	
	/*
	 * 删除
	 * @param array $condition
	 * @return bool
	 */
    public function delDesignerWork($condition){
        return $this->where($condition)->delete();
    }
	
    
     public function getDesignerWorkCount($condition) {
        $condition['sn_lock']=1;
        return $this->table('designer_work')->where($condition)->count();
    }
    
}
