<?php
/**
 * 购买
 *
 *
 *
 *
 * by 33hao.com 好商城V3 运营版
 */

//use Shopnc\Tpl;

defined('InShopNC') or exit('Access Invalid!');

class activityControl extends mobileMemberControl {

	public function __construct() {
		parent::__construct();
	}
        /**
	 * 单个活动信息页
	 */
	public function indexOp(){
		//读取语言包
		//Language::read('home_activity_index');
		//得到导航ID
		//$nav_id = intval($_GET['nav_id']) ? intval($_GET['nav_id']) : 0 ;
		//Tpl::output('index_sign',$nav_id);
		//查询活动信息
		$activity_id = intval($_REQUEST['activity_id']);
               
		if($activity_id<=0){
                     
                        output_special_code('10404');
			//showMessage(Language::get('para_error'),'index.php','html','error');//'缺少参数:活动编号'
		}
		$activity	= Model('activity')->getOneById($activity_id);
		if(empty($activity)|| $activity['activity_state'] != 1 || $activity['activity_start_date']>time() || $activity['activity_end_date']<time()){
			 output_special_code('10404');
                        //showMessage(Language::get('activity_index_activity_not_exists'),'index.php','html','error');//'指定活动并不存在'
		}
		//output(array('activity'=>$activity));
		//查询活动内容信息
		$list	= array();
		$list	= Model('activity_detail')->getGoodsList(array('order'=>'activity_detail.activity_detail_sort asc','activity_id'=>"$activity_id",'goods_show'=>'1','activity_detail_state'=>'1'));
		output_data(array('activity_list'=>$list,'html_title'=>C('site_name').' - '.$activity['activity_title']));
//                        Tpl::output('html_title',C('site_name').' - '.$activity['activity_title']);
//                        Tpl::showpage('activity_show');
	}
         /*
	 * 单个活动信息页 平台商品活动
	 */
	public function sa_datailOp(){
            $activity_id = intval($_REQUEST['activity_id']);
               
		if($activity_id<=0){
                     
                        output_special_code('10404');
			//showMessage(Language::get('para_error'),'index.php','html','error');//'缺少参数:活动编号'
		}
            $activity	= Model('activity')->getOneById($activity_id);
            $activity['activity_mb_body']=  unserialize($activity['activity_mb_body']);
            output_data($activity);
	}
        
        /**
	 * 单个活动信息页
	 */
	public function signup_datailOp(){
            $activity_id = intval($_REQUEST['activity_id']);
            if($activity_id<=0){
                        output_special_code('10404');
			//showMessage(Language::get('para_error'),'index.php','html','error');//'缺少参数:活动编号'
	    }
            $activity	= Model('activity')->getOneById($activity_id);
            $activity['activity_mb_body']=  unserialize($activity['activity_mb_body']);
            
            $condition['act_m_apply_act_id']=$_REQUEST['activity_id'];
            $condition['act_m_user_id']=$this->member_info['member_id'];
            
            $joininfo=Model('activity_member')->where($condition)->find();
            //var_dump($joininfo);
            if($joininfo){
                $joined=1;
            }else{
                $joined=0;
            }
            
            output_data(array('activity'=>$activity,'joined'=>$joined));
	}
        
       
        /**
     * 商品列表
     */
    
    
        
        public function youhuisOp(){
                        
                        $bl=Model('p_bundling')->getBundlingOpenList($condition5);
                        $activities['bundlings']=$bl;
                        $xs=Model('p_xianshi')->getXianshiList($condition3);
                         $activities['xianshis']=$xs;
                        $gb=Model('groupbuy')->getGroupbuyAvailableList($condition4); 
                        $activities['groupbuys']=$gb;
                        
                        output_data($activities);
                
	}
        

}

