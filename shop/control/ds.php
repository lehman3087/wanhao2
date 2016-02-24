<?php
/**
 * 店铺导航
 *
 *
 *
 **by 好商城V3 www.33hao.com 运营版*/


defined('InShopNC') or exit('Access Invalid!');
class designer_workControl extends BaseSellerControl {
    public function __construct() {
        parent::__construct();
      
    }

    public function designer_work_listOp() {
        $model_designer_work = Model('designer_work');
        $model_designer = Model('designer');
        $designers = $model_designer->getDesignerList();
        Tpl::output('designers', $designers);
        
        $where=array('designer_work.sn_store_id' => intval($_SESSION['store_id']));
       // $where['sn_store_id']=$_SESSION['store_id'];
        if(!empty($_GET['d_id']) && $_GET['d_id']>0){
            $where['designer_work.sn_designer_id']=$_GET['d_id'];
        }
        if(!empty($_GET['keyword'])){
            $where['designer_work.sn_name'] = array('like', '%' . trim($_GET['keyword']) . '%');
        }
        $fields=' designer_work.sn_if_show,designer_work.id as id,designer_work.sn_name,designer.sn_title,designer_work.sn_store_id,designer_work.sn_designer_id,designer_work.sn_work_pic ';
       // var_dump($where);
        $designer_work_list = $model_designer_work->getDesignerWorkListweb($where,$fields);
	
        
        Tpl::output('designer_work_list', $designer_work_list);
        Tpl::output('show_page', $model_designer_work->showpage());
        
        
	self::profile_menu('designer_work');
	Tpl::showpage('designer_work.list');
    }

    public function designer_work_addOp() {
        $style_arr = Model('decoration')->get_style();
        $category_arr = Model('decoration')->get_category();
	Tpl::output('style',$style_arr);
	Tpl::output('category',$category_arr);
        
        $this->profile_menu('designer_work_add');
        Tpl::showpage('designer_work.form');
    }

    public function designer_work_editOp() {
           $style_arr = Model('decoration')->get_style();
        $category_arr = Model('decoration')->get_category();
	Tpl::output('style',$style_arr);
	Tpl::output('category',$category_arr);
        
        $sn_id = $_REQUEST['sn_id'];
        if($sn_id <= 0) {
           showMessage('参数不正确', urlShop('designer_work', 'designer_work_list'), '', 'error');
        }
        
        $model_designer = Model('designer');
        $designers = $model_designer->getDesignerList();
        Tpl::output('designers', $designers);
        $model_designer_work = Model('designer_work');
        //var_dump($model_designer_work);
        
        $sn_info = $model_designer_work->getDesignerWorkInfo(array('id' => $sn_id));
        if(empty($sn_info) || intval($sn_info['sn_store_id']) !== intval($_SESSION['store_id'])) {
           showMessage(L('wrong_argument'), urlShop('designer_work', 'designer_work_list'), '', 'error');
        }
        
        Tpl::output('sn_info', $sn_info);
        $this->profile_menu('designer_wrok_edit');
        Tpl::showpage('designer_work.form');
    }

    public function designer_work_saveOp() {
        
        $main_pic=$_POST['main_pic'];
        $sn_info = array(
            'sn_name' => $_POST['sn_title'],
            'sn_m_pic'=>$_POST['image_path'][$main_pic],
            'sn_work_pic'=> implode(',', $_POST['image_path']),
            'sn_content' => $_POST['sn_content'],
            'sn_sort' => empty($_POST['sn_sort'])?255:$_POST['sn_sort'],
            'sn_if_show' => $_POST['sn_if_show'],
            'sn_designer_id' => intval($_POST['designer_id']),
            'sn_store_id' => $_SESSION['store_id'],
            'sn_category' => intval($_POST['category']),
            'sn_style' => intval($_POST['style']),
            'sn_house_type' => implode('',$_POST['house_type']),
            'sn_cost' => $_POST['cost'],
            'sn_area' => $_POST['area'],
            'sn_add_time' => TIMESTAMP,
            
        );
        $model_designer_work = Model('designer_work');
        if(!empty($_POST['sn_id']) && intval($_POST['sn_id']) > 0) {
            $this->recordSellerLog('编辑作品，作品编号'.$_POST['sn_id']);
            $condition = array('id' => $_POST['sn_id']);
            $result = $model_designer_work->editDesignerWork($sn_info, $condition);
        } else {
            $result = $model_designer_work->addDesignerWork($sn_info);
            $this->recordSellerLog('编辑作品，作品编号'.$result);
        }
        showDialog(L('nc_common_op_succ'), urlShop('designer', 'designer_list'), 'succ');
    }

    public function designer_delOp() {
        $sn_id = intval($_POST['sn_id']);
        $model_designer_work = Model('designer_work');
       // $sn_id = $_REQUEST['sn_id'];
        if($sn_id <= 0) {
           showMessage('参数不正确', urlShop('designer_work', 'designer_work_list'), '', 'error');
        }
        
        if($sn_id > 0) {
            $condition = array(
                'id' => $sn_id,
                'sn_store_id' => $_SESSION['store_id']
            );
            var_dump($condition);
            $model_designer = Model('designer_work');
            $model_designer->delDesignerWork($condition);
            $this->recordSellerLog('删除设计师，设计师编号'.$sn_id);
            showDialog(L('nc_common_op_succ'), urlShop('designer', 'designer_list'), 'succ');
        } else {
            showDialog(L('nc_common_op_fail'), urlShop('designer', 'designer_list'), 'error');
        }
    }

    /**
     * 用户中心右边，小导航
     *
     * @param string 	$menu_key	当前导航的menu_key
     * @return
     */
    private function profile_menu($menu_key = '') {
        $menu_array = array();
        $menu_array[] = array(
            'menu_key' => 'store_navigation',
            'menu_name' => '导航列表',
            'menu_url' => urlShop('store_navigation', 'navigation_list')
        );
        if($menu_key == 'navigation_add') {
            $menu_array[] = array(
                'menu_key' => 'navigation_add',
                'menu_name' => '添加导航',
                'menu_url' => urlShop('store_navigation', 'navigation_add')
            );
        }
        if($menu_key == 'navigation_edit') {
            $menu_array[] = array(
                'menu_key' => 'navigation_edit',
                'menu_name' => '编辑导航',
                'menu_url' => urlShop('store_navigation', 'navigation_edit')
            );
        }
        Tpl::output('member_menu', $menu_array);
        Tpl::output('menu_key', $menu_key);
    }
    
        //ajax上传头像
    	public function designer_image_uploadOp(){
		$upload = new UploadFile();
		$upload->set('default_dir',ATTACH_HEADER);
		$upload->set('max_size',C('image_max_filesize'));
		$result = $upload->upfile($_POST['id']);
		$output	= array();
		if(!$result){
			/**
			 * 转码
			 */
			if (strtoupper(CHARSET) == 'GBK'){
				$upload->error = Language::getUTF8($upload->error);
			}
			$output['error']	= $upload->error;
			echo json_encode($output);die;
		}
		$img_path = $upload->file_name;
		/**
		 * 模型实例化
		 */
		$model_upload = Model('upload');
		if(intval($_POST['file_id']) > 0){
			$file_info = $model_upload->getOneUpload($_POST['file_id']);
			@unlink(BASE_UPLOAD_PATH.DS.ATTACH_HEADER.DS.$file_info['file_name']);

			$update_array	= array();
			$update_array['upload_id']	= intval($_POST['file_id']);
			$update_array['file_name']	= $img_path;
			$update_array['file_size']	= $_FILES[$_POST['id']]['size'];
			$model_upload->update($update_array);

			$output['file_id']	= intval($_POST['file_id']);
			$output['id']		= $_POST['id'];
			$output['file_name']	= $img_path;
			echo json_encode($output);die;
                }else{
			/**
			 * 图片数据入库
			 */
			$insert_array = array();
			$insert_array['file_name']		= $img_path;
			$insert_array['upload_type']	= '3';
			$insert_array['file_size']		= $_FILES[$_POST['id']]['size'];
			$insert_array['item_id']		= $_SESSION['store_id'];
			$insert_array['upload_time']	= time();

			$result = $model_upload->add($insert_array);

			if(!$result){
				@unlink(BASE_UPLOAD_PATH.DS.ATTACH_HEADER.DS.$img_path);
				$output['error']	= Language::get('store_slide_upload_fail','UTF-8');
				echo json_encode($output);die;
			}

			$output['file_id']	= $result;
			$output['id']		= $_POST['id'];
			$output['file_name']	= $img_path;
			echo json_encode($output);die;
		}
	}
	/**
	 * ajax删除头像
	*/
        //ajax上传头像
    	public function designer_work_image_uploadOp(){
		$upload = new UploadFile();
		$upload->set('default_dir',ATTACH_WORK);
		$upload->set('max_size',C('image_max_filesize'));

		$result = $upload->upfile($_POST['id']);


		$output	= array();
		if(!$result){
			/**
			 * 转码
			 */
			if (strtoupper(CHARSET) == 'GBK'){
				$upload->error = Language::getUTF8($upload->error);
			}
			$output['error']	= $upload->error;
			echo json_encode($output);die;
		}

		$img_path = $upload->file_name;

		/**
		 * 模型实例化
		 */
		$model_upload = Model('upload');

		if(intval($_POST['file_id']) > 0){
			$file_info = $model_upload->getOneUpload($_POST['file_id']);
			@unlink(BASE_UPLOAD_PATH.DS.ATTACH_WORK.DS.$file_info['file_name']);

			$update_array	= array();
			$update_array['upload_id']	= intval($_POST['file_id']);
			$update_array['file_name']	= $img_path;
			$update_array['file_size']	= $_FILES[$_POST['id']]['size'];
			$model_upload->update($update_array);

			$output['file_id']	= intval($_POST['file_id']);
			$output['id']		= $_POST['id'];
			$output['file_name']	= $img_path;
			echo json_encode($output);die;
		}else{
			/**
			 * 图片数据入库
			 */
			$insert_array = array();
			$insert_array['file_name']		= $img_path;
			$insert_array['upload_type']	= '3';
			$insert_array['file_size']		= $_FILES[$_POST['id']]['size'];
			$insert_array['item_id']		= $_SESSION['store_id'];
			$insert_array['upload_time']	= time();

			$result = $model_upload->add($insert_array);

			if(!$result){
				@unlink(BASE_UPLOAD_PATH.DS.ATTACH_WORK.DS.$img_path);
				$output['error']	= Language::get('store_slide_upload_fail','UTF-8');
				echo json_encode($output);die;
			}

			$output['file_id']	= $result;
			$output['id']		= $_POST['id'];
			$output['file_name']	= $img_path;
			echo json_encode($output);die;
		}
	}

	/**
	 * ajax删除头像
	 */
	public function dorp_imgOp(){
		/**
		 * 模型实例化
		 */
		$model_upload = Model('upload');
		$file_info = $model_upload->getOneUpload(intval($_GET['file_id']));
		if(!$file_info){
		}else{
			@unlink(BASE_UPLOAD_PATH.DS.ATTACH_WORK.DS.$file_info['file_name']);
			$model_upload->del(intval($_GET['file_id']));
		}
		echo json_encode(array('succeed'=>Language::get('nc_common_save_succ','UTF-8')));die;
	}
        
        
        
        

}

