<?php
/**
 * 活动
 *
 *
 *
 **by 好商城V3 www.33hao.com 运营版*/


defined('InShopNC') or exit('Access Invalid!');

class activityControl extends BaseHomeControl {
	/**
	 * 单个活动信息页
	 */
    
       const EXPORT_SIZE = 5000;
        public function indexOp(){
		//读取语言包
		Language::read('home_activity_index');
		//得到导航ID
		$nav_id = intval($_GET['nav_id']) ? intval($_GET['nav_id']) : 0 ;
		Tpl::output('index_sign',$nav_id);
		//查询活动信息
		$activity_id = intval($_GET['activity_id']);
		if($activity_id<=0){
			showMessage(Language::get('para_error'),'index.php','html','error');//'缺少参数:活动编号'
		}
		$activity	= Model('activity')->getOneById($activity_id);
		if(empty($activity) || $activity['activity_type'] != '1' || $activity['activity_state'] != 1 || $activity['activity_start_date']>time() || $activity['activity_end_date']<time()){
			showMessage(Language::get('activity_index_activity_not_exists'),'index.php','html','error');//'指定活动并不存在'
		}
		Tpl::output('activity',$activity);
		//查询活动内容信息
		$list	= array();
		$list	= Model('activity_detail')->getGoodsList(array('order'=>'activity_detail.activity_detail_sort asc','activity_id'=>"$activity_id",'goods_show'=>'1','activity_detail_state'=>'1'));

		Tpl::output('list',$list);
		Tpl::output('html_title',C('site_name').' - '.$activity['activity_title']);
		Tpl::showpage('activity_show');
	}
        
        	/**
	 * 报名用户列表导出
	 */
	public function export_step1Op(){
                $model_act_member = Model('activity_member');
                $model_member = Model('member');
				/**
		 * 删除
		 */
                $condition['activity_member.act_m_apply_act_id'] =!empty($_REQUEST['id'])?$_REQUEST['id']:$_REQUEST['act_m_apply_act_id'];
		Tpl::output('act_m_apply_act_id',!empty($_REQUEST['id'])?$_REQUEST['id']:$_REQUEST['act_m_apply_act_id']);
                if (chksubmit()){
			/**
			 * 判断是否是管理员，如果是，则不能删除
			 */
			/**
			 * 删除
			 */
			if (!empty($_POST['del_id'])){
				if (is_array($_POST['del_id'])){
					foreach ($_POST['del_id'] as $k => $v){
						$v = intval($v);
						$rs = true;//$model_member->del($v);
						if ($rs){
							//删除该会员商品,店铺
							//获得该会员店铺信息
							$member = $model_act_member->getMemberInfo(array(
								'member_id'=>$v
							));
							//删除用户
							$model_member->del($v);
						}
					}
				}
				showMessage($lang['nc_common_del_succ']);
			}else {
				showMessage($lang['nc_common_del_fail']);
			}
		}
		//会员级别
		$member_grade = $model_member->getMemberGradeArr();
		if ($_GET['search_field_value'] != '') {
    		switch ($_GET['search_field_name']){
    			case 'member_name':
    				$condition['member_name'] = array('like', '%' . trim($_GET['search_field_value']) . '%');
    				break;
    			case 'member_email':
    				$condition['member_email'] = array('like', '%' . trim($_GET['search_field_value']) . '%');
    				break;
				//好商 城v3- b11
//			case 'member_mobile':
//    				$condition['member_mobile'] = array('like', '%' . trim($_GET['search_field_value']) . '%');
//    				break;
//    			case 'member_truename':
//    				$condition['member_truename'] = array('like', '%' . trim($_GET['search_field_value']) . '%');
//    				break;
    		}
		}
		switch ($_GET['search_state']){
			case 'no_informallow':
				$condition['inform_allow'] = '2';
				break;
			case 'no_isbuy':
				$condition['is_buy'] = '0';
				break;
			case 'no_isallowtalk':
				$condition['is_allowtalk'] = '0';
				break;
			case 'no_memberstate':
				$condition['member_state'] = '0';
				break;
		}
		//会员等级
		$search_grade = intval($_GET['search_grade']);
		if ($search_grade >= 0 && $member_grade){
		    $condition['member_exppoints'] = array(array('egt',$member_grade[$search_grade]['exppoints']),array('lt',$member_grade[$search_grade+1]['exppoints']),'and');
		}
		//排序
		$order = trim($_GET['search_sort']);
		if (empty($order)) {
		    $order = 'member_id desc';
		}
                
                
		
		//查询积分日志列表
		//$model = Model('exppoints');
                $member_list = $model_act_member->getMemberList($condition, '*', self::EXPORT_SIZE, $order);	
		//$list_log = $model->getExppointsLogList($where, '*', self::EXPORT_SIZE, 0, 'exp_id desc');

                $this->createExcel($member_list);

	}

	/**
	 * 生成excel
	 *
	 * @param array $data
	 */
	private function createExcel($data = array()){
		import('libraries.excel');
		$excel_obj = new Excel();
		$excel_data = array();
		//设置样式
		$excel_obj->setStyle(array('id'=>'s_title','Font'=>array('FontName'=>'宋体','Size'=>'12','Bold'=>'1')));
		//header
		$excel_data[0][] = array('styleid'=>'s_title','data'=>'会员名称');
//		$excel_data[0][] = array('styleid'=>'s_title','data'=>'经验值');
		$excel_data[0][] = array('styleid'=>'s_title','data'=>'报名时间');
//		$excel_data[0][] = array('styleid'=>'s_title','data'=>'操作阶段');
//		$excel_data[0][] = array('styleid'=>'s_title','data'=>'描述');
		//$stage_arr = Model('exppoints')->getStage();
		foreach ((array)$data as $k=>$v){
			$tmp = array();
			$tmp[] = array('data'=>$v['member_name']);
//			$tmp[] = array('format'=>'Number','data'=>ncPriceFormat($v['exp_points']));
			$tmp[] = array('data'=>date('Y-m-d H:i:s',$v['act_m_apply_time']));
			$excel_data[] = $tmp;
		}
		$excel_data = $excel_obj->charset($excel_data,CHARSET);
		$excel_obj->addArray($excel_data);
		$excel_obj->addWorksheet($excel_obj->charset('活动报名明细',CHARSET));
		$excel_obj->generateXML($excel_obj->charset('活动报名明细',CHARSET).$_GET['act_name'].$_GET['curpage'].'-'.date('Y-m-d-H',time()));
	}
        
        
        
}
