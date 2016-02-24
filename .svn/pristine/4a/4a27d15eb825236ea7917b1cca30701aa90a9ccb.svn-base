<?php
/**
 * 停车位
 *
 * 
 *
 *
 */
defined('InShopNC') or exit('Access Invalid!');
class party_barcodeModel extends Model {
    
    public function __construct() {
        parent::__construct('party_barcode');
    }
    
    /*
	 * 查看停车位
	 * @param array $param
	 * @return bool
	 */ 
    public function getPBList($condition, $page = '', $field = '*',$count = 0) {
                return $this->table('party_barcode')->field($field)->where($condition)->page($page, $count)->order('lastuptime desc')->select();

	}
    /*
	 * 增加停车位
	 * @param array $param
	 * @return bool
	 */
    public function addPB($param) {
        return $this->insert($param);
    }
    
    	/*
	 * 更新
	 * @param array $update
	 * @param array $condition
	 * @return bool
	 */
    public function editPB($update, $condition){
        return $this->where($condition)->update($update);
    }
	
	/*
	 * 删除
	 * @param array $condition
	 * @return bool
	 */
    public function delPB($condition){
        return $this->where($condition)->delete();
    }
    
    
    public function getCondition($condition_array){
        $condition_str = '';
	if($condition_array['code'] != ''){
		$condition_str .= ' code = "'.$condition_array['code'].'"';
	}
	if($condition_array['address'] != ''){
		$condition_str .= ' and address = "'.$condition_array['address'].'"';
	}
                return $condition_str;
    }
    
}
