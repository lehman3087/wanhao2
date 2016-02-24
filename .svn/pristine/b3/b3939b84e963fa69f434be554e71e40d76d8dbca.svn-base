<?php
/**
 * 活动管理
 *
 *
 *
 **by 好商城V3 www.33hao.com 运营版*/

defined('InShopNC') or exit('Access Invalid!');

class activityControl extends SystemControl{
    
    const EXPORT_SIZE = 5000;
    
	public function __construct(){
		parent::__construct();
		Language::read('activity');
	}
        
        
           /**
     * 审核活动
     */
        public function activity_verifyOp(){
        if (chksubmit()) {
            $commonids = $_POST['commonids'];
            $commonid_array = explode(',', $commonids);
            foreach ($commonid_array as $value) {
                if (!is_numeric($value)) {
                    showDialog(L('nc_common_op_fail'), 'reload');
                }
            }
            $update2 = array();
            $update2['activity_verify'] = intval($_POST['verify_state']);
            $update2['activity_state'] = intval($_POST['verify_state']);
            $update1 = array();
            $update1['activity_verifyremark'] = trim($_POST['verify_reason']);
            $update1 = array_merge($update1, $update2);
            $where = array();
            
            $where['activity_id_in'] = $commonids;

            $model_activity = Model('activity');
            if (intval($_POST['verify_state']) == 0) {
                $model_activity->editActivityVerifyFail($where, $update1);
            } else {
                 $model_activity->updateBycondition($update1,$where);
            }
            showDialog(L('nc_common_op_succ'), 'reload', 'succ');
        }
        Tpl::output('commonids', $_GET['id']);
        Tpl::showpage('activity.verify_remark', 'null_layout');
    }
    
	/**
	 * 活动列表
	 */
	public function indexOp(){
		$this->activityOp();
	}
        
	/**
	 * 活动列表/删除活动
	 */
	public function activityOp(){
		$activity	= Model('activity');
		//条件
		$condition_arr = array();
		//$condition_arr['activity_type'] = '1';//只显示商品活动
		//状态
		if (!empty($_GET['searchstate'])){
			$state = intval($_GET['searchstate'])-1;
			$condition_arr['activity_state'] = "$state";
		}
                
		//标题
		if (!empty($_GET['searchtitle'])){
			$condition_arr['activity_title'] = $_GET['searchtitle'];
		}
                
                //等待审核
		if (!empty($_GET['verify'])){
			$condition_arr['verify'] = 'waitverify';
                        $condition_arr['activity_funder'] = 'store';
		}
                
                //商户活动
                if(!empty($_GET['funder_type'])){
                        $condition_arr['activity_funder'] = 'store';
                }
		//有效期范围
		if (!empty($_GET['searchstartdate']) && !empty($_GET['searchenddate'])){
			$condition_arr['activity_daterange']['startdate'] = strtotime($_GET['searchstartdate']);
			$condition_arr['activity_daterange']['enddate'] = strtotime($_GET['searchenddate']);
            if($condition_arr['activity_daterange']['enddate'] > 0) {
                $condition_arr['activity_daterange']['enddate'] += 86400;
            }
            }
                //活动类型
            if (!empty($_GET['activity_type'])){
			$state = intval($_GET['activity_type']);
			$condition_arr['activity_type'] = "$state";
	}
		$condition_arr['order'] = 'activity_id desc,activity_sort asc';
		//活动列表
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
		$list	= $activity->getList($condition_arr,$page);
                
                
               
		//输出
		Tpl::output('show_page',$page->show());
		Tpl::output('list',$list);
                if (!empty($_GET['verify'])){
                    Tpl::showpage('activity.verify');
                }else{
                    Tpl::showpage('activity.index');
                }
		
	}

        /**
	 * 活动列表/删除活动
	 */
	public function store_activityOp(){
		$activity	= Model('activity');
		//条件
		$condition_arr = array();
		//$condition_arr['activity_type'] = '1';//只显示商品活动
		//状态
		if (!empty($_GET['searchstate'])){
			$state = intval($_GET['searchstate'])-1;
			$condition_arr['activity_state'] = "$state";
		}
		//标题
		if (!empty($_GET['searchtitle'])){
			$condition_arr['activity_title'] = $_GET['searchtitle'];
		}
		//有效期范围
		if (!empty($_GET['searchstartdate']) && !empty($_GET['searchenddate'])){
			$condition_arr['activity_daterange']['startdate'] = strtotime($_GET['searchstartdate']);
			$condition_arr['activity_daterange']['enddate'] = strtotime($_GET['searchenddate']);
            if($condition_arr['activity_daterange']['enddate'] > 0) {
                $condition_arr['activity_daterange']['enddate'] += 86400;
            }
		}
                //活动类型
                if (!empty($_GET['activity_type'])){
			$state = intval($_GET['activity_type']);
			$condition_arr['activity_type'] = "$state";
		}
		$condition_arr['order'] = 'activity_sort asc';
		//活动列表
		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
		$list	= $activity->getList($condition_arr,$page);
		//输出
		Tpl::output('show_page',$page->show());
		Tpl::output('list',$list);
		Tpl::showpage('activity.index');
	}
        
           
	/**
	 * 新建活动/保存新建活动
	 */
	public function newOp(){
		//新建处理
		if($_POST['form_submit'] != 'ok'){
			Tpl::showpage('activity.add');
			exit;
		}
                
                 if ($_POST['m_body'] != '') {
                $_POST['m_body'] = str_replace('&quot;', '"', $_POST['m_body']);
                $_POST['m_body'] = str_replace('\\', '', $_POST['m_body']);
                $_POST['m_body'] = json_decode($_POST['m_body'], true);
                if (!empty($_POST['m_body'])) {
                    $_POST['m_body'] = serialize($_POST['m_body']);
                } else {
                    $_POST['m_body'] = '';
                }
                }
            
            
		//提交表单
		$obj_validate = new Validate();
		$validate_arr[] = array("input"=>$_POST["activity_title"],"require"=>"true","message"=>Language::get('activity_new_title_null'));
		$validate_arr[] = array("input"=>$_POST["activity_start_date"],"require"=>"true","message"=>Language::get('activity_new_startdate_null'));
		$validate_arr[] = array("input"=>$_POST["activity_end_date"],"require"=>"true",'validator'=>'Compare','operator'=>'>','to'=>"{$_POST['activity_start_date']}","message"=>Language::get('activity_new_enddate_null'));
		$validate_arr[] = array("input"=>$_POST["activity_style"],"require"=>"true","message"=>Language::get('activity_new_style_null'));
		$validate_arr[] = array('input'=>$_POST['activity_type'],'require'=>'true','message'=>Language::get('activity_new_type_null'));
		$validate_arr[] = array('input'=>$_FILES['activity_banner']['name'],'require'=>'true','message'=>Language::get('activity_new_banner_null'));
		$validate_arr[] = array('input'=>$_POST['activity_sort'],'require'=>'true','validator'=>'Range','min'=>0,'max'=>255,'message'=>Language::get('activity_new_sort_error'));
		$obj_validate->validateparam = $validate_arr;
		$error = $obj_validate->validate();
		if ($error != ''){
			showMessage(Language::get('error').$error,'','','error');
		}
		$upload	= new UploadFile();
		$upload->set('default_dir',ATTACH_ACTIVITY);
		$result = $upload->upfile('activity_banner');
		if(!$result){
			showMessage($upload->error);
		}
		//保存
		$input	= array();
		$input['activity_title']	= trim($_POST['activity_title']);
		$input['activity_type']		= trim($_POST['activity_type']);
		$input['activity_banner']	= $upload->file_name;
		$input['activity_style']	= trim($_POST['activity_style']);
		$input['activity_desc']		= trim($_POST['activity_desc']);
		$input['activity_sort']		= intval(trim($_POST['activity_sort']));
		$input['activity_start_date']= strtotime(trim($_POST['activity_start_date']));
		$input['activity_end_date']	= strtotime(trim($_POST['activity_end_date']));
		$input['activity_state']	= intval($_POST['activity_state']);
                $input['activity_mb_body']	= $_POST['m_body'];
                $input['activity_verify']	= 1;
                $input['activity_store_name']	= '平台';
		$activity	= Model('activity');
		$result	= $activity->add($input);
		if($result){
			$this->log(L('nc_add,activity_index').'['.$_POST['activity_title'].']',null);
			showMessage(Language::get('nc_common_op_succ'),'index.php?act=activity&op=activity');
		}else{
			//添加失败则删除刚刚上传的图片,节省空间资源
			@unlink(BASE_UPLOAD_PATH.DS.ATTACH_ACTIVITY.DS.$upload->file_name);
			showMessage(Language::get('nc_common_op_fail'));
		}
	}

	/**
	 * 异步修改
	 */
	public function ajaxOp(){
		if(in_array($_GET['branch'],array('activity_title','activity_sort'))){
			$activity = Model('activity');
			$update_array = array();
			switch ($_GET['branch']){
				/**
				 * 活动主题
				 */
				case 'activity_title':
					if(trim($_GET['value'])=='')exit;
					break;
				/**
				 * 排序
				 */
				case 'activity_sort':
					if(preg_match('/^\d+$/',trim($_GET['value']))<=0 or intval(trim($_GET['value']))<0 or intval(trim($_GET['value']))>255)exit;
					break;
				default:
						exit;
			}
			$update_array[$_GET['column']] = trim($_GET['value']);
			if($activity->update($update_array,intval($_GET['id'])))
			echo 'true';
		}elseif(in_array($_GET['branch'],array('activity_detail_sort'))){
			$activity_detail = Model('activity_detail');
			$update_array = array();
			switch ($_GET['branch']){
				/**
				 * 排序
				 */
				case 'activity_detail_sort':
					if(preg_match('/^\d+$/',trim($_GET['value']))<=0 or intval(trim($_GET['value']))<0 or intval(trim($_GET['value']))>255)exit;
					break;
				default:
						exit;
			}
			$update_array[$_GET['column']] = trim($_GET['value']);
			if($activity_detail->update($update_array,intval($_GET['id'])))
			echo 'true';
		}
	}

	/**
	 * 删除活动
	 */
	public function delOp(){
		$id	= '';
		if(empty($_REQUEST['activity_id'])){
			showMessage(Language::get('activity_del_choose_activity'));
		}
		if(is_array($_POST['activity_id'])){
			try{
				//删除数据先删除横幅图片，节省空间资源
				foreach ($_POST['activity_id'] as $v){
					$this->delBanner(intval($v));
				}
			}catch(Exception $e){
				showMessage($e->getMessage());
			}
			$id	= "'".implode("','",$_POST['activity_id'])."'";
		}else{
			//删除数据先删除横幅图片，节省空间资源
			$this->delBanner(intval($_GET['activity_id']));
			$id	= intval($_GET['activity_id']);
		}
		$activity	= Model('activity');
		$activity_detail	= Model('activity_detail');
		//获取可以删除的数据
		$condition_arr = array();
		$condition_arr['activity_state'] = '0';//已关闭
		$condition_arr['activity_enddate_greater_or'] = time();//过期
		$condition_arr['activity_id_in'] = $id;
		$activity_list = $activity->getList($condition_arr);
		if (empty($activity_list)){//没有符合条件的活动信息直接返回成功信息
			showMessage(Language::get('nc_common_del_succ'));
		}
		$id_arr = array();
		foreach ($activity_list as $v){
			$id_arr[] = $v['activity_id'];
		}
		$id_new	= "'".implode("','",$id_arr)."'";
		//只有关闭或者过期的活动，能删除
		if($activity_detail->del($id_new)){
			if($activity->del($id_new)){
				$this->log(L('nc_del,activity_index').'[ID:'.$id.']',null);
				showMessage(Language::get('nc_common_del_succ'));
			}
		}
		showMessage(Language::get('activity_del_fail'));
	}

	/**
	 * 编辑活动/保存编辑活动
	 */
	public function editOp(){
		if($_POST['form_submit'] != 'ok'){
			if(empty($_GET['activity_id'])){
				showMessage(Language::get('miss_argument'));
			}
			$activity	= Model('activity');
			$row	= $activity->getOneById(intval($_GET['activity_id']));
                        
                         $row['activity_mb_body']=  unserialize($row['activity_mb_body']);                  
                        
                        $row['mobile_body']=  json_encode($row['activity_mb_body']);
                        
                          
                        
			Tpl::output('activity',$row);
			Tpl::showpage('activity.edit');
			exit;
		}
                
                //移动端内容
                 if ($_POST['m_body'] != '') {
                $_POST['m_body'] = str_replace('&quot;', '"', $_POST['m_body']);
                $_POST['m_body'] = str_replace('\\', '', $_POST['m_body']);
                $_POST['m_body'] = json_decode($_POST['m_body'], true);
                if (!empty($_POST['m_body'])) {
                    $_POST['m_body'] = serialize($_POST['m_body']);
                } else {
                    $_POST['m_body'] = '';
                }
                }
                
                
		//提交表单
		$obj_validate = new Validate();
		$validate_arr[] = array("input"=>$_POST["activity_title"],"require"=>"true","message"=>Language::get('activity_new_title_null'));
		$validate_arr[] = array("input"=>$_POST["activity_start_date"],"require"=>"true","message"=>Language::get('activity_new_startdate_null'));
		$validate_arr[] = array("input"=>$_POST["activity_end_date"],"require"=>"true",'validator'=>'Compare','operator'=>'>','to'=>"{$_POST['activity_start_date']}","message"=>Language::get('activity_new_enddate_null'));
		$validate_arr[] = array("input"=>$_POST["activity_style"],"require"=>"true","message"=>Language::get('activity_new_style_null'));
		$validate_arr[] = array('input'=>$_POST['activity_type'],'require'=>'true','message'=>Language::get('activity_new_type_null'));
		$validate_arr[] = array('input'=>$_POST['activity_desc'],'require'=>'true','message'=>Language::get('activity_new_desc_null'));
		$validate_arr[] = array('input'=>$_POST['activity_sort'],'require'=>'true','validator'=>'Range','min'=>0,'max'=>255,'message'=>Language::get('activity_new_sort_error'));
		$obj_validate->validateparam = $validate_arr;
		$error = $obj_validate->validate();
		if ($error != ''){
			showMessage(Language::get('error').$error,'','','error');
		}
		//构造更新内容
		$input	= array();
		if($_FILES['activity_banner']['name']!=''){
			$upload	= new UploadFile();
			$upload->set('default_dir',ATTACH_ACTIVITY);
			$result	= $upload->upfile('activity_banner');
			if(!$result){
				showMessage($upload->error);
			}
			$input['activity_banner']	= $upload->file_name;
		}
		$input['activity_title']	= trim($_POST['activity_title']);
		$input['activity_type']		= trim($_POST['activity_type']);
                
		$input['activity_style']	= trim($_POST['activity_style']);
		$input['activity_desc']		= trim($_POST['activity_desc']);
		$input['activity_sort']		= intval(trim($_POST['activity_sort']));
		$input['activity_start_date']	= strtotime(trim($_POST['activity_start_date']));
		$input['activity_end_date']	= strtotime(trim($_POST['activity_end_date']));
		$input['activity_state']	= intval($_POST['activity_state']);
                $input['activity_state']	= intval($_POST['activity_state']);
                $input['activity_mb_body']	= $_POST['m_body'];
                if($input['activity_type']<11){
                    $input['activity_store_name']	= '平台';
                }
                
                

		$activity	= Model('activity');
		$row	= $activity->getOneById(intval($_POST['activity_id']));
		$result	= $activity->update($input,intval($_POST['activity_id']));
		if($result){
			if($_FILES['activity_banner']['name']!=''){
				@unlink(BASE_UPLOAD_PATH.DS.ATTACH_ACTIVITY.DS.$row['activity_banner']);
			}
			$this->log(L('nc_edit,activity_index').'[ID:'.$_POST['activity_id'].']',null);
			showMessage(Language::get('nc_common_save_succ'),'index.php?act=activity&op=activity');
		}else{
			if($_FILES['activity_banner']['name']!=''){
				@unlink(BASE_UPLOAD_PATH.DS.ATTACH_ACTIVITY.DS.$upload->file_name);
			}
			showMessage(Language::get('nc_common_save_fail'));
		}
	}

	/**
	 * 活动细节列表
	 */
	public function detailOp(){
		$activity_id = intval($_GET['id']);
		if($activity_id <= 0){
			showMessage(Language::get('miss_argument'));
		}
		//条件
		$condition_arr = array();
		$condition_arr['activity_id'] = $activity_id;
		//审核状态
		if (!empty($_GET['searchstate'])){
			$state = intval($_GET['searchstate'])-1;
			$condition_arr['activity_detail_state'] = "$state";
		}
		//店铺名称
		if (!empty($_GET['searchstore'])){
			$condition_arr['store_name'] = $_GET['searchstore'];
		}
	    //商品名称
		if (!empty($_GET['searchgoods'])){
			$condition_arr['item_name'] = $_GET['searchgoods'];
		}
		$condition_arr['order'] = 'activity_detail.activity_detail_state asc,activity_detail.activity_detail_sort asc';

		$page	= new Page();
		$page->setEachNum(10);
		$page->setStyle('admin');
		$activitydetail_model	= Model('activity_detail');
		$list	= $activitydetail_model->getList($condition_arr,$page);
		//输出到模板
		Tpl::output('show_page',$page->show());
		Tpl::output('list',$list);
		Tpl::showpage('activity_detail.index');
	}

	/**
	 * 活动内容处理
	 */
	public function dealOp(){
		if(empty($_REQUEST['activity_detail_id'])){
			showMessage(Language::get('activity_detail_del_choose_detail'));
		}
		//获取id
		$id	= '';
		if(is_array($_POST['activity_detail_id'])){
			$id	= "'".implode("','",$_POST['activity_detail_id'])."'";
		}else{
			$id	= intval($_GET['activity_detail_id']);
		}
		//创建活动内容对象
		$activity_detail	= Model('activity_detail');
		if($activity_detail->update(array('activity_detail_state'=>intval($_GET['state'])),$id)){
			$this->log(L('nc_edit,activity_index').'[ID:'.$id.']',null);
			showMessage(Language::get('nc_common_op_succ'));
		}else{
			showMessage(Language::get('nc_common_op_fail'));
		}
	}

	/**
	 * 删除活动内容
	 */
	public function del_detailOp(){
		if(empty($_REQUEST['activity_detail_id'])){
			showMessage(Language::get('activity_detail_del_choose_detail'));
		}
		$id	= '';
		if(is_array($_POST['activity_detail_id'])){
			$id	= "'".implode("','",$_POST['activity_detail_id'])."'";
		}else{
			$id	= "'".intval($_GET['activity_detail_id'])."'";
		}
		$activity_detail	= Model('activity_detail');
		//条件
		$condition_arr = array();
		$condition_arr['activity_detail_id_in'] = $id;
		$condition_arr['activity_detail_state_in'] = "'0','2'";//未审核和已拒绝
		if($activity_detail->delList($condition_arr)){
			$this->log(L('nc_del,activity_index_content').'[ID:'.$id.']',null);
			showMessage(Language::get('nc_common_del_succ'));
		}else{
			showMessage(Language::get('nc_common_del_fail'));
		}
	}

	/**
	 * 根据活动编号删除横幅图片
	 *
	 * @param int $id
	 */
	private function delBanner($id){
		$activity	= Model('activity');
		$row	= $activity->getOneById($id);
		//删除图片文件
		@unlink(BASE_UPLOAD_PATH.DS.ATTACH_ACTIVITY.DS.$row['activity_banner']);
	}
        
        
        	/**
	 * 会员管理
	 */
	public function memberOp(){
		$lang	= Language::getLangContent();
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
		$member_list = $model_act_member->getMemberList($condition, '*', 10, $order);		
		//整理会员信息
		if (is_array($member_list)){
			foreach ($member_list as $k=> $v){
				$member_list[$k]['member_time'] = $v['member_time']?date('Y-m-d H:i:s',$v['member_time']):'';
				$member_list[$k]['act_m_apply_time'] = $v['act_m_apply_time']?date('Y-m-d H:i:s',$v['act_m_apply_time']):'';
				$member_list[$k]['member_login_time'] = $v['member_login_time']?date('Y-m-d H:i:s',$v['member_login_time']):'';
                                $member_list[$k]['member_grade'] = ($t = $model_member->getOneMemberGrade($v['member_exppoints'], false, $member_grade))?$t['level_name']:'';
			}
		}
		Tpl::output('member_grade',$member_grade);
		Tpl::output('search_sort',trim($_GET['search_sort']));
		Tpl::output('search_field_name',trim($_GET['search_field_name']));
		Tpl::output('search_field_value',trim($_GET['search_field_value']));
		Tpl::output('member_list',$member_list);
		Tpl::output('page',$model_member->showpage());
		Tpl::showpage('activity_member.index');
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
