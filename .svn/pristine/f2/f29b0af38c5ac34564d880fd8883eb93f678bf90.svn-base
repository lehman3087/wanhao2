<?php
/**
 * 活动细节
 *
 * 
 *
 *
 * by 33hao 好商城V3  www.33hao.com 开发
 */
defined('InShopNC') or exit('Access Invalid!');
class rec_applysModel{
	/**
	 * 添加
	 *
	 * @param array $input 
	 * @return bool
	 */
	public function add($input){
		return Db::insert('rec_applys',$input);
	}
	/**
	 * 更新
	 *
	 * @param array $input 更新内容
	 * @param string $id 活动内容id
	 * @return bool
	 */
	public function update($input,$id){
		return Db::update('rec_applys',$input,'adp_apply_id in('.$id.')');
	}
        
        /**
	 * 使其他已通过申请失效
	 *
	 * @param array $input 更新内容
	 * @param string $id 活动内容id
	 * @return bool
	 */
	public function invalid($input,$adpid,$id){
		return Db::update('rec_applys',$input,'adp_id='.$adpid.' and adp_apply_id not in('.$id.')');
	}
        
	/**
	 * 根据条件更新
	 *
	 * @param array $input 更新内容
	 * @param array $condition 更新条件
	 * @return bool
	 */
	public function updateList($input,$condition){
		return Db::update('rec_applys',$input,$this->getCondition($condition));
	}
	/**
	 * 删除
	 *
	 * @param string $id
	 * @return bool
	 */
	public function del($id){
		return Db::delete('rec_applys','adp_apply_id in('.$id.')');
	}
	/**
	 * 根据条件删除
	 *
	 * @param array $condition 条件数组
	 * @return bool
	 */
	public function delList($condition){
		return Db::delete('rec_applys',$this->getCondition($condition));
	}
	/**
	 * 根据条件查询活动内容信息
	 *
	 * @param array $condition 查询条件数组
	 * @param obj $page	分页对象
	 * @return array 二维数组
	 */
	public function getList($condition,$page=''){
		$param	= array();
		$param['table']	= 'rec_applys';
		$param['where']	= $this->getCondition($condition);
		$param['order']	= $condition['order'];
		return Db::select($param,$page);
	}
	/**
	 * 根据条件查询活动商品内容信息
	 *
	 * @param array $condition 查询条件数组
	 * @param obj $page	分页对象
	 * @return array 二维数组
	 */
	public function getGoodsJoinList($condition,$page=''){
		$param	= array();
		$param['table']	= 'activity_detail,goods';
		$param['join_type']	= 'inner join';
		$param['field']	= 'activity_detail.*,goods.*';
		$param['join_on']	= array('activity_detail.item_id=goods.goods_id');
		$param['where']	= $this->getCondition($condition);
		$param['order']	= $condition['order'];
		return Db::select($param,$page);
	}
        
        	/**
	 * 根据条件查询参与推广活动信息
	 *
	 * @param array $condition 查询条件数组
	 * @param obj $page	分页对象
	 * @return array 二维数组
	 */
	public function getActivitiesJoinList($condition,$page=''){
                $param['field']	= 'rec_applys.*';
		$param['table']	= 'rec_applys';
                $param['order']	= $condition['order'];
                $param['where']	= $this->getCondition($condition);
               
                $applys=Db::select($param,$page);
                 
                if(!empty($applys)){
                    $applys=$this->getExtAcitity($applys);
                }
                
		return $applys;
	}
        
        public function getExtAcitity($applys) {
            
            if (!is_array($applys)) {
                return false;
            }
            
             
            foreach ($applys as $key => $value) {
                switch ($value['item_cate']) {
                    case 'p_mansong':
                        $id='mansong_id';
                        $name='mansong_name';
                        $remark='remark';
                        $this->getExcents($applys,$key,$value,$id,$name);
                        break;
                    case 'groupbuy':  
                        $id='groupbuy_id';
                        $name='groupbuy_name';
                        $remark='remark';
                        $this->getExcents($applys,$key,$value,$id,$name);
                        break;
                    case 'p_xianshi':
                        $id='xianshi_id';
                        $name='xianshi_name';
                        $remark='xianshi_explain';
                        $this->getExcents($applys,$key,$value,$id,$name);
                        break;
                    case 'p_bundling':
                        $id='bl_id';
                        $name='bl_name';
                        $remark='';
                        $this->getExcents($applys,$key,$value,$id,$name);
                        break;
                    case 'activity':
                        $id='activity_id';
                        $name='activity_title';
                        $startt='activity_start_date';
                        $endt='activity_end_date';
                        $remark='';
                        $this->getExcents($applys,$key,$value,$id,$name,$startt,$endt);
                        break;
                    case 'good':
                        break;
                    default:
                        break;
                }
//                $param['table']	= $value['item_cate'];
//                $param['where']	= ' and '.$id.'='.$value['item_id'];
//                $activity=Db::select($param,$page);
//                $applys[$key]['act_name']=$activity[0][$name];
//                $applys[$key]['start_time']=$activity[0][$startt];
//                $applys[$key]['end_time']=$activity[0][$endt];
            }
            return $applys;
        }
        private function getExcents(&$applys,$key,$value,$id,$name,$startt='start_time',$endt='end_time'){

                $param['table']	= $value['item_cate'];
                $param['where']	= ' and '.$id.'='.$value['item_id'];
                
                $activity=Db::select($param,$page);
                
                $applys[$key]['act_name']=$activity[0][$name];
                $applys[$key]['start_time']=$activity[0][$startt];
                $applys[$key]['end_time']=$activity[0][$endt];
                
               
        }
        
	/**
	 * 查询活动商品信息
	 *
	 * @param array $condition 查询条件数组
	 * @param obj $page	分页对象
	 * @return array 二维数组
	 */
	public function getGoodsList($condition,$page=''){
		$param	= array();
		$param['table']	= 'activity_detail,goods';
		$param['join_type']	= 'inner join';
		$param['field']	= 'activity_detail.activity_detail_sort,goods.goods_id,goods.store_id,goods.goods_name,goods.goods_price,goods.goods_image';
		$param['join_on']	= array('activity_detail.item_id=goods.goods_id');
		$param['where']	= $this->getCondition($condition);
		$param['order']	= $condition['order'];
		return Db::select($param,$page);
	}
	/**
	 * 构造查询条件
	 *
	 * @param array $condition 查询条件数组
	 * @return string
	 */
	private function getCondition($condition){
		$conditionStr	= '';
		if($condition['rec_id']>0){
			$conditionStr	.= " and rec_applys.rec_id = '{$condition['rec_id']}'";
		}
                
                if($condition['adp_id']>0){
			$conditionStr	.= " and rec_applys.adp_id = '{$condition['adp_id']}'";
		}
		if (isset($condition['adp_apply_id_in'])){
			if ($condition['adp_apply_id_in'] == ''){
				$conditionStr	.= " and adp_apply_id in ('')";
			}else{
				$conditionStr	.= " and adp_apply_id in ({$condition['adp_apply_id_in']})";
			}
		}
		if(isset($condition['adp_apply_state_in'])){
			if ($condition['adp_apply_state_in'] == ''){
				$conditionStr	.= " and adp_apply_state in ('')";
			}else{
				$conditionStr	.= " and adp_apply_state in ({$condition['adp_apply_state_in']})";
			}
		}
                
                if(isset($condition['adp_apply_state'])){

			$conditionStr	.= " and adp_apply_state ＝ '{$condition['adp_apply_state']}'";
			
		}
                
                
                if(intval($condition['store_id'])>0){
			$conditionStr	.= " and rec_applys.store_id='".intval($condition['store_id'])."'";
		}
                
		if($condition['activity_detail_state'] != ''){
			$conditionStr	.= " and activity_detail.activity_detail_state='".$condition['activity_detail_state']."'";
		}
		if($condition['gc_id'] != ''){
		$conditionStr	.= " and goods.gc_id='{$condition['gc_id']}'";
		}
		if($condition['brand_id'] != ''){
			$conditionStr	.= " and goods.brand_id='{$condition['brand_id']}' ";
		}
		if($condition['name'] != ''){
			$conditionStr	.= " and goods.goods_name like '%{$condition['name']}%'";
		}
		if(intval($condition['item_id'])>0){
			$conditionStr	.= " and activity_detail.item_id='".intval($condition['item_id'])."'";
		}
		if($condition['item_name'] != ''){
			$conditionStr	.= " and activity_detail.item_name like '%{$condition['item_name']}%'";
		}
		
		if($condition['store_name'] != ''){
			$conditionStr	.= " and activity_detail.store_name like '%{$condition['store_name']}%'";
		}
		if ($condition_array['goods_show'] != '') {
			$condition_sql	.= " and goods.goods_show= '{$condition_array['goods_show']}'";
		}
		return $conditionStr;
	}
}