<?php
/**
 * 店铺动态
 *
 *
 *
 **by 好商城V3 www.33hao.com 运营版*/


defined('InShopNC') or exit('Access Invalid!');
class store_snsControl extends BaseSellerControl{
    public function __construct() {
        parent::__construct ();
        Language::read('store_sns,member_sns');
    }
    public function indexOp() {
        $this->addOp();
    }
    
    
    public function signup_delOp() {
         $activity	= Model('activity');
         $snid=$_REQUEST['sn_id'];
         if(intval($snid)){
           $activity->del(intval($snid));
           showDialog(Language::get('nc_common_del_succ'),'reload','succ');
           // showMessage(Language::get('nc_common_save_succ'),'index.php?act=store_sns&op=signup_list');
         }
         
    }

    public function signup_listOp() {
        
            $activity	= Model('activity');
        
        
            $condition_arr['order'] = 'activity_id desc';
            $condition_arr['store_id'] = $_SESSION['store_id'];
		//活动列表
		$page	= new Page();
		$page->setEachNum(5);
		$page->setStyle('admin');
		$list	= $activity->getList($condition_arr,$page);
                
                //var_dump($list);
               
		//输出
		Tpl::output('show_page',$page->show());
		Tpl::output('list',$list);
               $this->profile_menu('store_signup_list');
		//self::profile_menu('store_navigation');
		Tpl::showpage('store_signup.list');
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
     * 发布动态
     */
    public function addOp() {
        $model_goods = Model('goods');
        // 热销商品

        // where条件
        $where = array('store_id' => $_SESSION['store_id']);
        $field = 'goods_id,goods_name,goods_image,goods_price,goods_salenum,store_id';
        $order = 'goods_salenum desc';
        $hotsell_list = $model_goods->getGoodsOnlineList($where, $field, 0, $order, 8);
        Tpl::output('hotsell_list', $hotsell_list);

        // 新品

        // where条件
        $where = array('store_id' => $_SESSION['store_id']);
        $field = 'goods_id,goods_name,goods_image,goods_price,goods_salenum,store_id';
        $order = 'goods_id desc';
        $new_list = $model_goods->getGoodsOnlineList($where, $field, 0, $order, 8);
        Tpl::output('new_list', $new_list);

        $this->profile_menu ( 'store_sns_add' );
        if($_REQUEST['cat']=='signup'){
            Tpl::showpage ( 'store_sns_signup_add' );
        }else{
            Tpl::showpage ( 'store_sns_add' );
        }
    }
    
    public function snsSignupEditOp() {
            if($_POST['form_submit'] != 'ok'){
                
			if(empty($_GET['activity_id'])){
				showMessage(Language::get('miss_argument'));
			}
                        
			$activity	= Model('activity');
			$row	= $activity->getOneById(intval($_GET['activity_id']));
                        
                        $row['mobile_body']=  json_encode(unserialize($row['activity_mb_body']));
                        $row['activity_mb_body']=  unserialize($row['activity_mb_body']);
                        
                        $this->profile_menu ( '' );
			Tpl::output('activity',$row);
                        Tpl::showpage('store_sns_signup_edit');
			//Tpl::showpage('store_sns_signup_edit');
			exit;
		}
               // exit(0);
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
                $input	= array();
		if($_POST['sns_image']!=''){
//			$upload	= new UploadFile();
//			$upload->set('default_dir',ATTACH_REC_POSITION);
//			$result	= $upload->upfile('normal_file');
//			if(!$result){
//				showMessage($upload->error);
//			}
			$input['activity_banner']	= $_POST['sns_image'];
                      //  exit($input['activity_banner'].'lehman');
		}
		$input['activity_title']	= trim($_POST['activity_title']);
		$input['activity_type']		= trim($_POST['activity_type']);
                
		$input['activity_style']	= trim($_POST['activity_style']);
		$input['activity_desc']		= trim($_POST['activity_desc']);
		$input['activity_sort']		= intval(trim($_POST['activity_sort']));
		$input['activity_start_date']	= strtotime(trim($_POST['activity_start_date']));
		$input['activity_end_date']	= strtotime(trim($_POST['activity_end_date']));
		$input['activity_state']	= intval($_POST['activity_state']);
                $input['activity_store_id']	= $_SESSION['store_id'];
                $input['activity_mb_body']	= $_POST['m_body'];
                $input['activity_store_name']	= $_SESSION['store_name'];
                $input['contact_phone']	= $_POST['contact_phone'];
                $input['activity_location']	= $_POST['activity_location'];
                

		$activity	= Model('activity');
		$row	= $activity->getOneById(intval($_POST['activity_id']));
		$result	= $activity->update($input,intval($_POST['activity_id']));
		if($result){
			if($_FILES['normal_file']['name']!=''){
				@unlink(BASE_UPLOAD_PATH.DS.ATTACH_REC_POSITION.DS.$row['activity_banner']);
			}
			//$this->log(L('nc_edit,activity_index').'[ID:'.$_POST['activity_id'].']',null);
			showMessage(Language::get('nc_common_save_succ'),'index.php?act=store_sns&op=signup_list');
		}else{
			if($_FILES['normal_file']['name']!=''){
				@unlink(BASE_UPLOAD_PATH.DS.ATTACH_REC_POSITION.DS.$upload->file_name);
			}
			showMessage(Language::get('nc_common_save_fail'));
		}
                
//        $activity	= Model('activity');
//		//条件
//	$condition_arr = array();
//          $condition_arr['store_id']=$_SESSION['store_id'];
//          $condition_arr['activity_id']=$_REQUEST['activity_id'];
//        $condition_arr['order'] = 'activity_sort asc';
//		//活动列表
//		$page	= new Page();
//		$page->setEachNum(10);
//		$page->setStyle('admin');
//		$list	= $activity->getList($condition_arr,$page);
//		//输出
//		Tpl::output('show_page',$page->show());
//		Tpl::output('list',$list);
		//Tpl::showpage('store_sns_signup_edit');
    }


    /**
     * 上传图片
     */
    public function image_uploadOp() {
        // 判断图片数量是否超限
        $model_album = Model('album');
        $album_limit = $this->store_grade['sg_album_limit'];
        if ($album_limit > 0) {
            $album_count = $model_album->getCount(array('store_id' => $_SESSION['store_id']));
            if ($album_count >= $album_limit) {
                $error = L('store_goods_album_climit');
                if (strtoupper(CHARSET) == 'GBK') {
                    $error = Language::getUTF8($error);
                }
                exit(json_encode(array('error' => $error)));
            }
        }

        $class_info = $model_album->getOne(array('store_id' => $_SESSION['store_id'], 'is_default' => 1), 'album_class');
        // 上传图片
        $upload = new UploadFile();
        $upload->set('default_dir', ATTACH_GOODS . DS . $_SESSION ['store_id'] . DS . $upload->getSysSetPath());
        $upload->set('max_size', C('image_max_filesize'));

        $upload->set('thumb_width', GOODS_IMAGES_WIDTH);
        $upload->set('thumb_height', GOODS_IMAGES_HEIGHT);
        $upload->set('thumb_ext', GOODS_IMAGES_EXT);
        $upload->set('fprefix', $_SESSION['store_id']);
        $upload->set('allow_type', array('gif', 'jpg', 'jpeg', 'png'));
        $result = $upload->upfile($_POST['id']);
        if (!$result) {
            if (strtoupper(CHARSET) == 'GBK') {
                $upload->error = Language::getUTF8($upload->error);
            }
            $output = array();
            $output['error'] = $upload->error;
            $output = json_encode($output);
            exit($output);
        }

        $img_path = $upload->getSysSetPath() . $upload->file_name;
        $thumb_page = $upload->getSysSetPath() . $upload->thumb_image;

        // 取得图像大小
        list($width, $height, $type, $attr) = getimagesize(UPLOAD_SITE_URL . '/' . ATTACH_GOODS . '/' . $_SESSION ['store_id'] . DS . $img_path);

        // 存入相册
        $image = explode('.', $_FILES[$_POST['id']]["name"]);
        $insert_array = array();
        $insert_array['apic_name'] = $image['0'];
        $insert_array['apic_tag'] = '';
        $insert_array['aclass_id'] = $class_info['aclass_id'];
        $insert_array['apic_cover'] = $img_path;
        $insert_array['apic_size'] = intval($_FILES[$_POST['id']]['size']);
        $insert_array['apic_spec'] = $width . 'x' . $height;
        $insert_array['upload_time'] = TIMESTAMP;
        $insert_array['store_id'] = $_SESSION['store_id'];
        $model_album->addPic($insert_array);

        $data = array ();
        $data ['image'] = cthumb($img_path, 240, $_SESSION['store_id']);
        $data['filename']=$img_path;

        // 整理为json格式
        $output = json_encode($data);
        echo $output;
        exit();
    }
    
     public function newActivityOp() {
            // exit('123');
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
                $input	= array();
		$input['activity_title']	= trim($_POST['activity_title']);
		$input['activity_type']		= trim($_POST['activity_type']);
		$input['activity_banner']	= $_REQUEST['sns_image'];
		$input['activity_style']	= trim($_POST['activity_style']);
		$input['activity_desc']		= trim($_POST['activity_desc']);
		$input['activity_sort']		= intval(trim($_POST['activity_sort']));
                $input['activity_store_id']		= $_SESSION['store_id'];
                $input['activity_store_name']		= $_SESSION['store_name'];
               
		$input['activity_start_date']= strtotime(trim($_POST['activity_start_date']));
		$input['activity_end_date']	= strtotime(trim($_POST['activity_end_date']));
		$input['activity_state']	= intval($_POST['activity_state']);
                $input['activity_mb_body']	= $_POST['m_body'];
                
                $input['contact_phone']	= $_POST['contact_phone'];
                $input['activity_location']	= $_POST['activity_location'];
                
                
		$activity	= Model('activity');
		$result	= $activity->add($input);
		if($result){
			//$this->log(L('nc_add,activity_index').'['.$_POST['activity_title'].']',null);
			showMessage(Language::get('nc_common_op_succ'),'index.php?act=store_sns&op=add');
		}else{
			//添加失败则删除刚刚上传的图片,节省空间资源
			//@unlink(BASE_UPLOAD_PATH.DS.ATTACH_ACTIVITY.DS.$upload->file_name);
			showMessage(Language::get('nc_common_op_fail'));
		}
                
        }        
        
        
	/**
	 * 保存动态
	 */
	public function store_sns_saveOp(){
		/**
		 * 验证表单
		 */
		$obj_validate = new Validate();
		$obj_validate->validateparam = array(
				//array("input"=>$_POST["content"],"require"=>"false","validator"=>"Length","max"=>140,"min"=>1,"message"=>Language::get('store_sns_center_error')),
				array("input"=>$_POST["goods_url"],"require"=>"false","validator"=>"url","message"=>Language::get('store_goods_index_goods_price_null')),
		);
		$error = $obj_validate->validate();
		if ($error != ''){
                   
			showDialog($error);
		}
                 
		// 实例化模型
		$model = Model();


		$goodsdata	= '';
		$content	= '';
		$_POST['type'] = intval($_POST['type']);
		switch ($_POST['type']){
			case '2':
				$sns_image	= trim($_POST['sns_image']);
				if($sns_image != '') $content	= '<div class="fd-media">
									<div class="thumb-image"><a href="javascript:void(0);" nc_type="thumb-image"><img src="'.$sns_image.'" /><i></i></a></div>
									<div class="origin-image"><a href="javascript:void(0);" nc_type="origin-image"></a></div>
								</div>';
                                
				break;
			case '9':
				$data = $this->getGoodsByUrl(html_entity_decode($_POST['goods_url']));
				if( CHARSET == 'GBK') {
					foreach ((array)$data as $k=>$v){
						$data[$k] = Language::getUTF8($v);
					}
				}
				$goodsdata	= addslashes(json_encode($data));
				break;
			case '10':
				if(is_array($_POST['goods_id'])){
					$goods_id_array = $_POST['goods_id'];
				}else{
					showDialog(Language::get('store_sns_choose_goods'));
				}
				$field = 'goods_id,store_id,goods_name,goods_image,goods_price,goods_freight';
				$where = array('store_id'=>$_SESSION['store_id'],'goods_id'=>array('in',$goods_id_array));
				$goods_array = Model('goods')->getGoodsList($where, $field);
				if(!empty($goods_array) && is_array($goods_array)){
					$goodsdata	= array();
					foreach ($goods_array as $val){
						if( CHARSET == 'GBK') {
							foreach ((array)$val as $k=>$v){
								$val[$k] = Language::getUTF8($v);
							}
						}
						$goodsdata[]	= addslashes(json_encode($val));
					}
				}
				break;
			case '3':
				if(is_array($_POST['goods_id'])){
					$goods_id_array = $_POST['goods_id'];
				}else{
					showDialog(Language::get('store_sns_choose_goods'));
				}
				$field = 'goods_id,store_id,goods_name,goods_image,goods_price,goods_freight';
				$where = array('store_id'=>$_SESSION['store_id'],'goods_id'=>array('in',$goods_id_array));
				$goods_array = Model('goods')->getGoodsList($where, $field);
				if(!empty($goods_array) && is_array($goods_array)){
					$goodsdata	= array();
					foreach($goods_array as $val){
						if( CHARSET == 'GBK') {
							foreach ((array)$val as $k=>$v){
								$val[$k] = Language::getUTF8($v);
							}
						}
						$goodsdata[]	= addslashes(json_encode($val));
					}
				}
				break;
			default:
				showDialog(Language::get('para_error'));
		}

		$model_stracelog = Model('store_sns_tracelog');
		// 插入数据
		$stracelog_array = array();
		$stracelog_array['strace_storeid']	= $this->store_info['store_id'];
		$stracelog_array['strace_storename']= $this->store_info['store_name'];
		$stracelog_array['strace_storelogo']= empty($this->store_info['store_avatar'])?'':$this->store_info['store_avatar'];
		$stracelog_array['strace_title']	= $_POST['title'];
		$stracelog_array['strace_content']	= $content;
                $stracelog_array['strace_mb_image']	= $sns_image;
                $stracelog_array['strace_mb_content']= $_POST["content"];
		$stracelog_array['strace_time']		= time();
		$stracelog_array['strace_type']		= $_POST['type'];
                $stracelog_array['strace_mb_body']		= $_POST['m_body'];
		if(isset($goodsdata) && is_array($goodsdata)){
			$stracelog	= array();
			foreach($goodsdata as $val){
				$stracelog_array['strace_goodsdata']	= $val;
				$stracelog[]	= $stracelog_array;
			}
			$rs	= $model_stracelog->saveStoreSnsTracelogAll($stracelog);
		}else{
			$stracelog_array['strace_goodsdata']	= $goodsdata;
			$rs	= $model_stracelog->saveStoreSnsTracelog($stracelog_array);
		}
		if($rs){
			showDialog(Language::get('nc_common_op_succ'), 'index.php?act=store_sns', 'succ');
		}else{
			showDialog(Language::get('nc_common_op_fail'));
		}
	}
	/**
	 * 动态设置
	 */
	public function settingOp(){
		// 实例化模型
		$model_storesnssetting = Model('store_sns_setting');
		if(chksubmit()){
			$update = array();
			$update['sauto_storeid']		= $_SESSION['store_id'];
			$update['sauto_new']			= isset($_POST['new'])?1:0;
			$update['sauto_newtitle']		= trim($_POST['new_title']);
			$update['sauto_coupon']			= isset($_POST['coupon'])?1:0;
			$update['sauto_coupontitle']	= trim($_POST['coupon_title']);
			$update['sauto_xianshi']		= isset($_POST['xianshi'])?1:0;
			$update['sauto_xianshititle']	= trim($_POST['xianshi_title']);
			$update['sauto_mansong']		= isset($_POST['mansong'])?1:0;
			$update['sauto_mansongtitle']	= trim($_POST['mansong_title']);
			$update['sauto_bundling']		= isset($_POST['bundling'])?1:0;
			$update['sauto_bundlingtitle']	= trim($_POST['bundling_title']);
			$update['sauto_groupbuy']		= isset($_POST['groupbuy'])?1:0;
			$updata['sauto_groupbuytitle']	= trim($_POST['groupbuy_title']);
			$result = $model_storesnssetting->saveStoreSnsSetting($update,true);
			showDialog(Language::get('nc_common_save_succ'), '', 'succ');
		}
		$sauto_info	= $model_storesnssetting->getStoreSnsSettingInfo(array('sauto_storeid' => $_SESSION['store_id']));
		Tpl::output('sauto_info', $sauto_info);
		$this->profile_menu('store_sns_setting');
		Tpl::showpage('store_sns_setting');
	}

	/**
	 * 用户中心右边，小导航
	 *
	 * @param string	$menu_type	导航类型
	 * @param string 	$menu_key	当前导航的menu_key
	 * @return
	 */
	private function profile_menu($menu_key) {
		$menu_array	= array(
				1=>array('menu_key'=>'store_sns_add', 'menu_name'=>Language::get('store_sns_add'), 'menu_url'=>'index.php?act=store_sns&op=add'),
				2=>array('menu_key'=>'store_sns_setting', 'menu_name'=>Language::get('store_sns_setting'), 'menu_url'=>'index.php?act=store_sns&op=setting'),
                                    
				3=>array('menu_key'=>'store_sns_brower', 'menu_name'=>Language::get('store_sns_browse'), 'menu_url'=>urlShop('store_snshome', 'index', array('sid' => $_SESSION['store_id'])), 'target'=>'_blank'),
                                4=>array('menu_key'=>'store_signup_list', 'menu_name'=>'报名活动列表', 'menu_url'=>'index.php?act=store_sns&op=signup_list')
                    );
		Tpl::output('member_menu',$menu_array);
		Tpl::output('menu_key',$menu_key);
	}

	/**
	 * 根据url取得商品信息
	 */
	private function getGoodsByUrl($url){
		$array = parse_url($url);
		if(isset($array['query'])){
			// 未开启伪静态
			parse_str($array['query'],$arr);
			$id = $arr['goods_id'];
		}else{
			// 开启伪静态
			$item = explode('/', $array['path']);
			$item = end($item);
			$id = preg_replace('/item-(\d+)\.html/i', '$1', $item);
		}
		if(intval($id) > 0){
			// 查询商品信息
			$field = 'goods_id,store_id,goods_name,goods_image,goods_price,goods_freight';
			$result = Model('goods')->getGoodsInfoByID($id, $field);
			if(!empty($result) && is_array($result)){
				return $result;
			}else{
				showDialog(Language::get('store_sns_goods_url_error'));
			}
		}else{
			showDialog(Language::get('store_sns_goods_url_error'));
		}

	}
        

    
}
