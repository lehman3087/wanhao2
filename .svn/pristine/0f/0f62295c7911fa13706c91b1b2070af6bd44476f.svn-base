<?php
/**
 * 我的收藏
 *
 *
 *
 *
 * by 33hao.com 好商城V3 运营版
 */

//use Shopnc\Tpl;

defined('InShopNC') or exit('Access Invalid!');

class decoraion_socialControl extends mobileMemberControl {

	public function __construct(){
		parent::__construct();
	}

    /**
     * 收藏列表
     */
    public function work_favorites_listOp() {
	$model_favorites = Model('favorites');

        $favorites_list = $model_favorites->getWorkFavoritesList(array('member_id'=>$this->member_info['member_id']), '*', $this->page);
        $page_count = $model_favorites->gettotalpage();
        $favorites_id = '';
        foreach ($favorites_list as $value){
            $favorites_id .= $value['fav_id'] . ',';
        }
        $favorites_id = rtrim($favorites_id, ',');

        $model_work = Model('designer_work');
        $field = '*';
        $work_list = $model_work->getDesignerWorkList(array('id' => array('in', $favorites_id)), $field);
        foreach ($work_list as $key=>$value) {
            $work_list[$key]['fav_id'] = $value['id'];
            $work_list[$key]['work_image_url'] = cthumb($value['sn_work_pic'], 240, $value['store_id']);
        }

        output_data(array('favorites_list' => $work_list), mobile_page($page_count));
    }

    
     /**
     * 收藏列表-装修公司
     */
   	/**
	 * 店铺收藏列表
	 *
	 * @param
	 * @return
	 */
	public function dc_favorites_listOp(){
		$favorites_model = Model('favorites');
		$favorites_list = $favorites_model->getStoreFavoritesList(array('member_id'=>$this->member_info['member_id']), '*', 10);
		 $page_count = $model_favorites->gettotalpage();
                if (!empty($favorites_list) && is_array($favorites_list)){
			$favorites_id = array();//收藏的店铺编号
			foreach ($favorites_list as $key=>$favorites){
				$fav_id = $favorites['fav_id'];
				$favorites_id[] = $favorites['fav_id'];
				$favorites_key[$fav_id] = $key;
			}
			$store_model = Model('store');
			$store_list = $store_model->getStoreList(array('store_id'=>array('in', $favorites_id)));
			if (!empty($store_list) && is_array($store_list)){
				foreach ($store_list as $key=>$fav){
					$fav_id = $fav['store_id'];
					$key = $favorites_key[$fav_id];
					$favorites_list[$key]['store'] = $fav;
				}
			}
		}
                 output_data(array('favorites_list' => $favorites_list), mobile_page($page_count));
	}
    /**
     * 添加作品收藏
     */
    public function favorites_addOp() {
        $goods_id = intval($_POST['work_id']);
	if ($goods_id <= 0){
            output_error('参数错误');
		}

		$favorites_model = Model('favorites');

		//判断是否已经收藏
        $favorites_info = $favorites_model->getOneFavorites(array('fav_id'=>$goods_id,'fav_type'=>'work','member_id'=>$this->member_info['member_id']));
		if(!empty($favorites_info)) {
            output_error('您已经收藏了该商品');
		}

		//判断商品是否为当前会员所有
		$goods_model = Model('designer_work');
		$goods_info = $goods_model->getDesignerWorkInfo(array('id'=>$goods_id));
		$seller_info = Model('seller')->getSellerInfo(array('member_id'=>$this->member_info['member_id']));
		if ($goods_info['sn_store_id'] == $seller_info['store_id']) {
                    output_error('您不能收藏自己发布的作品');
		}

		//添加收藏
		$insert_arr = array();
		$insert_arr['member_id'] = $this->member_info['member_id'];
		$insert_arr['fav_id'] = $goods_id;
		$insert_arr['fav_type'] = 'work';
		$insert_arr['fav_time'] = TIMESTAMP;
		$result = $favorites_model->addFavorites($insert_arr);

		if ($result){
			//增加收藏数量
		$goods_model->editDesignerWork(array('goods_collect' => array('exp', 'goods_collect + 1')), array('id'=>$goods_id));
            output_data('1');
		}else{
            output_error('收藏失败');
		}
    }
  	/**
	 * 增加店铺收藏
	 */
	public function favoritesstoreOp(){
		$fav_id = intval($_GET['fid']);
		if ($fav_id <= 0){
                        output_error('收藏失败');
//			echo json_encode(array('done'=>false,'msg'=>Language::get('favorite_collect_fail','UTF-8')));
//			die;
		}
		$favorites_model = Model('favorites');
		//判断是否已经收藏
		$favorites_info = $favorites_model->getOneFavorites(array('fav_id'=>"$fav_id",'fav_type'=>'store','member_id'=>"{$_SESSION['member_id']}"));
		if(!empty($favorites_info)){
                         output_error('收藏失败');
//			echo json_encode(array('done'=>false,'msg'=>Language::get('favorite_already_favorite_store','UTF-8')));
//			die;
		}
		//判断店铺是否为当前会员所有
		if ($fav_id == $_SESSION['store_id']){
                         output_error('收藏失败');
//			echo json_encode(array('done'=>false,'msg'=>Language::get('favorite_no_my_store','UTF-8')));
//			die;
		}
		//添加收藏
		$insert_arr = array();
		$insert_arr['member_id'] = $_SESSION['member_id'];
		$insert_arr['fav_id'] = $fav_id;
		$insert_arr['fav_type'] = 'store';
		$insert_arr['fav_time'] = time();
		$result = $favorites_model->addFavorites($insert_arr);
		if ($result){
			//增加收藏数量
			$store_model = Model('store');
            $store_model->editStore(array('store_collect'=>array('exp', 'store_collect+1')), array('store_id' => $fav_id));
			output_error('1');
//                        echo json_encode(array('done'=>true,'msg'=>Language::get('favorite_collect_success','UTF-8')));
//			die;
		}else{
                        output_error('收藏失败');
//			echo json_encode(array('done'=>false,'msg'=>Language::get('favorite_collect_fail','UTF-8')));
//			die;
		}
	}
    

    /**
     * 删除收藏
     */
    public function favorites_delOp() {
		$fav_id = intval($_POST['fav_id']);
		if ($fav_id <= 0){
            output_error('参数错误');
		}

		$model_favorites = Model('favorites');

        $condition = array();
        $condition['fav_id'] = $fav_id;
        $condition['member_id'] = $this->member_info['member_id'];
        $model_favorites->delFavorites($condition);
        output_data('1');
    }

}