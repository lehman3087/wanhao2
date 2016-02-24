<?php
/**
 * 停车位
 *
 * 
 *
 *
 */
defined('InShopNC') or exit('Access Invalid!');
class bidModel extends Model {
    
    public function __construct() {
        parent::__construct('bid');
    }
    
    
    private $states=array(
        '0'=>'放弃',
        '1'=>'竞标中',
        '2'=>'胜出'
        
    );
    
    public function returnStates($param) {
        return $this->states;
    }
    /*
	 * 查看标书
	 * @param array $param
	 * @return bool
	 */ 
    public function getBidList($condition, $page = '', $field = '*',$count = 0) {
                return $this->table('bid')->field($field)->where($condition)->page($page, $count)->order('bid_lastuptime desc')->select();

    }
    /*
	 * 增加停车位
	 * @param array $param
	 * @return bool
	 */
    public function addBid($param) {
        return $this->insert($param);
    }
    
    
    public function countCharg($condition,$field='*') {
        return $this->table('bid')->field($field)->where($condition)->count();
        
    }
    
    	/*
	 * 更新
	 * @param array $update
	 * @param array $condition
	 * @return bool
	 */
    public function editBid($update, $condition){
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
    
    public function getBidInfo($condition){
        $bid = $this->where($condition)->find();
        if(!empty($bid)){
            $bid['bid_content']= unserialize($bid['bid_content']);
        }
        
       // var_dump($bid['bid_content']);
        return $bid;
    }
    
    public function getbidCommonOnlineList($param) {
        
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
