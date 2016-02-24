<?php
/**
 * 店铺导航
 *
 *
 *
 **by 好商城V3 www.33hao.com 运营版*/


defined('InShopNC') or exit('Access Invalid!');
class decorationControl extends BaseSellerControl {
    public function __construct() {
        parent::__construct();
      
    }

       public function work_listOp() {
        $model_work = Model('decoration');
        //$where['dw_verify']=10;
        $where = array();
        //$where['dw_store_id'] = intval($_SESSION['store_id']);
        if (intval($_GET['stc_id']) > 0) {
            $where['dw_state'] = $_GET['stc_id'];
        }
        if (trim($_GET['keyword']) != '') {
            //var_dump($_GET['search_type']);
            switch ($_GET['search_type']) {
                case 'dw_name':
                    $where['dw_name'] = array('like', '%' . trim($_GET['keyword']) . '%');
                    break;
                case 'dw_content':
                    $where['dw_content'] = array('like', '%' . trim($_GET['keyword']) . '%');
                    break;
                case 'dw_address':
                    $where['dw_address'] = array('like', '%' . trim($_GET['keyword']) . '%');
                    break;
                case 'dw_category':
                    $where['dw_category'] = intval($_GET['keyword']);
                    break;
                case 'dw_style':
                    $where['dw_style'] = intval($_GET['keyword']);
                    break;
                case 'dw_budget':
                    $calcufu= $_GET['calculate_type'];
                    $where['dw_budget'] = array($calcufu,  intval($_GET['keyword']));
                    break;
                case 'dw_addtime':
                    $stime = $_GET['search_stime']?strtotime($_GET['search_stime']):0;
                    $etime = $_GET['search_etime']?strtotime($_GET['search_etime']):0;
                    if ($stime > 0 && $etime>0){
                        $where['dw_addtime'] = array('between',array($stime,$etime));
                    }elseif ($stime > 0){
                        $where['dw_addtime'] = array('egt',$stime);
                    }elseif ($etime > 0){
                        $where['dw_addtime'] = array('elt',$etime);
                    }
                    break;
            }
        }
        $states=$model_work->getStoreStates();
        Tpl::output('states', $states);
        $work_list = $model_work->getworkCommonOnlineListForDc($where);
        Tpl::output('show_page', $model_work->showpage());
        Tpl::output('work_list', $work_list);

        $this->profile_menu('work_list', 'work_list');
        Tpl::showpage('decoration_work_list.online');
    }
    
    
    public function lookup_winOp() {
        error_reporting(0);
        $where['bid_id']=$_REQUEST['id'];
        $bid=Model('bid')->getBidInfo($where);
        
        Tpl::output('bid', $bid);
        Tpl::showpage('decoration.lookwin', 'null_layout');
    }
    

    public function designer_addOp() {
        $this->profile_menu('designer_add');
        Tpl::showpage('designer.form');
    }

    public function designer_editOp() {
        
        $sn_id = $_REQUEST['sn_id'];
        if($sn_id <= 0) {
           showMessage(L('wrong_argument'), urlShop('designer', 'designer_list'), '', 'error');
        }
        $model_designer = Model('designer');
        $sn_info = $model_designer->getDesignerInfo(array('id' => $sn_id));
        if(empty($sn_info) || intval($sn_info['sn_store_id']) !== intval($_SESSION['store_id'])) {
           showMessage(L('wrong_argument'), urlShop('designer', 'designer_list'), '', 'error');
        }
        Tpl::output('sn_info', $sn_info);
        $this->profile_menu('designer_edit');
        Tpl::showpage('designer.form');
    }
    
    

    

    public function designer_saveOp() {
      
        $sn_info = array(
            'sn_title' => $_POST['sn_title'],
            'sn_head' => $_POST['image_path'][0],
            'sn_content' => $_POST['sn_content'],
            'sn_sort' => empty($_POST['sn_sort'])?255:$_POST['sn_sort'],
            'sn_if_show' => $_POST['sn_if_show'],
            'sn_store_id' => $_SESSION['store_id'],
            'sn_add_time' => TIMESTAMP
        );
        $model_designer = Model('designer');
        if(!empty($_POST['sn_id']) && intval($_POST['sn_id']) > 0) {
            $this->recordSellerLog('编辑设计师，设计师编号'.$_POST['sn_id']);
            $condition = array('id' => $_POST['sn_id']);
            $result = $model_designer->editDesigner($sn_info, $condition);
        } else {
            $result = $model_designer->addDesigner($sn_info);
            $this->recordSellerLog('新增设计师，设计师编号'.$result);
        }
        showDialog(L('nc_common_op_succ'), urlShop('designer', 'designer_list'), 'succ');
    }

    public function designer_delOp() {
        $sn_id = intval($_POST['sn_id']);
        if($sn_id > 0) {
            $condition = array(
                'id' => $sn_id,
                'sn_store_id' => $_SESSION['store_id']
            );
            $model_designer = Model('designer');
            $model_designer->delDesigner($condition);
            $this->recordSellerLog('删除店铺导航，导航编号'.$sn_id);
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
	public function dorp_imgOp(){
		/**
		 * 模型实例化
		 */
		$model_upload = Model('upload');
		$file_info = $model_upload->getOneUpload(intval($_GET['file_id']));
		if(!$file_info){
		}else{
			@unlink(BASE_UPLOAD_PATH.DS.ATTACH_HEADER.DS.$file_info['file_name']);
			$model_upload->del(intval($_GET['file_id']));
		}
		echo json_encode(array('succeed'=>Language::get('nc_common_save_succ','UTF-8')));die;
	}
        
        

}

