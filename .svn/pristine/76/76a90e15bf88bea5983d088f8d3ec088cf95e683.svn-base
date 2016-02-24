<?php
/**
 * 店铺导航模型
 *
 * 
 *
 *
 */
defined('InShopNC') or exit('Access Invalid!');
class designerModel extends Model{
    
    public function __construct(){
        //echo('1');
        parent::__construct('designer');
        
    }

	/**
	 * 读取列表 
	 * @param array $condition
	 *
	 */
	public function getDesignerList($condition, $page='', $order='', $field='*') {      
        $result = $this->field($field)->where($condition)->page($page)->order($order)->select();
        return $result;
	}
        
        public function updateDesignerWorkCount($param) {
            $condition['sn_designer_id']=$param['designer_id'];
            $count=Model('designer_work')->where($condition)->count();
            $condition2['id']=$param['designer_id'];
            $update['work_count']=$count;
            
            $this->where($condition2)->update($update);
            
        }
        
        public function _dealOrder($param) {
            if($param=='1'){
              return 'rand()';
            }
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
                    $type =  '=';
                    $val=$value->matchValue;
                }
                $kv[]=$type;
                $kv[]=$val;
                $con[$value->matchKey]=$kv;
                }
        }
       
        return $con;
        
    }
    
        public function getDesignerListPage($condition,$page = 0,$count = 0, $field = '*', $group = '',$order = '', $limit = 0,  $lock = false){
             $condition=  $this->_dealCondition($condition);
            $count=$this->getDesignerCount($condition);
             if($order==2){
               $order='sn_designer_collect desc';
             }else if($order==1){
                 $order='rand()';
             }else if($order==3){
                 $order='work_count desc';
             }
             $designers = $this->table('designer')->field($field)->where($condition)->group($group)->order($order)->limit($limit)->page($page, $count)->select();
             //$designers2=  $this->getDesignerWorkCount($designers,$order);
            // return array_values($designers2);
             return $designers;
        }
        
        
    public function getDesignerCount($condition, $field = '*', $group = '') {
       
        return $this->table('designer')->where($condition)->group($group)->count($field);
    }
    
    public function getDesignerRowCount($condition, $field = '*', $group = '') {
        $condition=  $this->_dealCondition($condition);
        return $this->table('designer')->where($condition)->count();
    }
    
    public function getDesignerWorkCount($designers,$order) {
        foreach ($designers as $key=>$designer) {
           // echo json_encode($designer);
            
             $condition['sn_designer_id']=$designer['id'];
             $work_count = $this->table('designer_work')->where($condition)->count();
//             echo json_encode($work_count);
//             exit();
             $designers[$key]['work_count']=$work_count;
        }
      //  $designers2=array_values($designers);
       // echo json_encode($designers);
        if($order==3){
           
            uasort($designers, 'work_count_cmp1');
        }
        
        return $designers;
       
        
    }
    
    
       
    
    

    /**
	 * 读取单条记录
	 * @param array $condition
	 *
	 */
    public function getDesignerInfo($condition) {
        $result = $this->where($condition)->find();
        return $result;
    }

	/*
	 * 增加 
	 * @param array $param
	 * @return bool
	 */
    public function addDesigner($param){
        return $this->insert($param);	
    }
	
	/*
	 * 更新
	 * @param array $update
	 * @param array $condition
	 * @return bool
	 */
    public function editDesigner($update, $condition){
        return $this->where($condition)->update($update);
    }
	
	/*
	 * 删除
	 * @param array $condition
	 * @return bool
	 */
    public function delDesigner($condition){
        return $this->where($condition)->delete();
    }
	
}
