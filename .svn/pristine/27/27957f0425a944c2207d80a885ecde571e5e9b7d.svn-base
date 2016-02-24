<?php
/**
 * 停车位
 *
 * 
 *
 *
 */
defined('InShopNC') or exit('Access Invalid!');
class bid_targetModel extends Model {
    
    public function __construct() {
        parent::__construct('bid_target');
    }
    
    /*
	 * 查看停车位
	 * @param array $param
	 * @return bool
	 */ 
    public function getBTList($condition, $page = '', $field = '*',$count = 0,$order='bt_id desc') {
                return $this->table('bid_target')->field($field)->where($condition)->page($page, $count)->order($order)->select();

	}

    
    	/*
	 * 更新
	 * @param array $update
	 * @param array $condition
	 * @return bool
	 */
    public function editBT($update, $condition){
        return $this->where($condition)->update($update);
    }
	
	/*
	 * 删除
	 * @param array $condition
	 * @return bool
	 */
    public function delBT($condition){
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
    /*
     * 定标
     */
    public function selectBid($param){
        $result = $this->insert($param);
        if($result){
            return $result;
        }else{
            echo json_encode(array('stateCode'=>10500));
            exit();
        }
        
         
    }
    
     /*
     * 中标后更新所有标书状态
     */
    public function selectedUpdateBid($param,$dw_id){
           $update['bid_state']=2;
            $update2['bid_state']=3;
            $conditon['bid_work_id']=$dw_id;
            $conditon['bid_state']=1;
            $dwcondition['dw_id']=$dw_id;
            $dwupdate['dw_state']=3;
            Model('decoration')->editDwCommon($dwupdate,$dwcondition);
            Model('bid')->editBid($update,$param);
            Model('bid')->editBid($update2,$conditon);
            $this->resultReportBid($dw_id);
    }
    
         /*
     * 中标后更新所有标书状态
     */
    public function resultReportBid($param,$dw_id){
            $conditon['bid_work_id']=$dw_id;
            $conditon['bid_state']=2;
            $conditon2['bid_work_id']=$dw_id;
            $conditon2['bid_state']=3;
            $bidlist=Model('bid')->getBidList($conditon);
            foreach ($bidlist as $key => $value) {
                $this->_sendStoreMsg('bid_sccess', $value['bid_store_id'], '');
            }
            
            $bidlist2=Model('bid')->getBidList($conditon2);
            foreach ($bidlist2 as $key => $value) {
                $this->_sendStoreMsg('bid_fail', $value['bid_store_id'], '');
            }
    }
    
    
    
     /**
     * 发送店铺消息
     * @param string $code
     * @param int $store_id
     * @param array $param
     */
    private function _sendStoreMsg($code, $store_id, $param) {
        QueueClient::push('sendStoreMsg', array('code' => $code, 'store_id' => $store_id, 'param' => $param));
    }
    
    
}
