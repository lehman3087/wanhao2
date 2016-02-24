<?php
/**
 * 我的地址
 *
 *
 *
 *
 * by 33hao.com 好商城V3 运营版
 */

//use Shopnc\Tpl;

defined('InShopNC') or exit('Access Invalid!');

class member_addressControl extends mobileMemberControl {
	public function __construct() {
		parent::__construct();
	}

    /**
     * 地址列表
     */
    public function address_listOp() {
	$model_address = Model('address');
        $address_list = $model_address->getAddressList(array('member_id'=>$this->member_info['member_id']));
        output_data(array('address_list' => $address_list));
    }

    /**
     * 地址详细信息
     */
    public function address_infoOp() {
	$address_id = intval($_REQUEST['address_id']);

	$model_address = Model('address');

        $condition = array();
        $condition['address_id'] = $address_id;
        $address_info = $model_address->getAddressInfo($condition);
        if(!empty($address_id) && $address_info['member_id'] == $this->member_info['member_id']) {
            output_data(array('address_info' => $address_info));
        } else {
            output_error('地址不存在');
        }
    }

    /**
     * 删除地址
     */
    public function address_delOp() {
		$address_id = intval($_REQUEST['address_id']);

		$model_address = Model('address');

        $condition = array();
        $condition['address_id'] = $address_id;
        $condition['member_id'] = $this->member_info['member_id'];
        $model_address->delAddress($condition);
        output_data('1');
    }

    /**
     * 新增地址
     */
    public function address_addOp() {
        $model_address = Model('address');
        $address_info = $this->_address_valid();

        $result = $model_address->addAddress($address_info);
        if($result) {
            output_data(array('address_id' => $result));
        } else {
            output_error('保存失败');
        }
    }

    /**
     * 编辑地址
     */
    public function address_editOp() {
        $address_id = intval($_REQUEST['address_id']);

        $model_address = Model('address');

        //验证地址是否为本人
        $address_info = $model_address->getOneAddress($address_id);
        if ($address_info['member_id'] != $this->member_info['member_id']) {
            output_error('参数错误');
        }

        $address_info = $this->_address_valid();

        $result = $model_address->editAddress($address_info, array('address_id' => $address_id));
        if($result) {
            output_data('1');
        } else {
            output_error('保存失败');
        }
    }

    /**
     * 验证地址数据
     */
    private function _address_valid() {
        $obj_validate = new Validate();
        $obj_validate->validateparam = array(
            array("input"=>$_REQUEST["true_name"],"require"=>"true","message"=>'姓名不能为空'),
            array("input"=>$_REQUEST["area_info"],"require"=>"true","message"=>'地区不能为空'),
            array("input"=>$_REQUEST["address"],"require"=>"true","message"=>'地址不能为空'),
            array("input"=>$_REQUEST['tel_phone'].$_REQUEST['mob_phone'],'require'=>'true','message'=>'联系方式不能为空')
        );
        $error = $obj_validate->validate();
        if ($error != ''){
            output_error($error);
        }

        $data = array();
        $data['member_id'] = $this->member_info['member_id'];
        $data['true_name'] = $_REQUEST['true_name'];
        $data['area_id'] = intval($_REQUEST['area_id']);
        $data['city_id'] = intval($_REQUEST['city_id']);
        $data['area_info'] = $_REQUEST['area_info'];
        $data['address'] = $_REQUEST['address'];
        $data['tel_phone'] = $_REQUEST['tel_phone'];
        $data['is_default'] = $_REQUEST['is_default'];
        $data['mob_phone'] = $_REQUEST['mob_phone'];
        return $data;
    }

    /**
     * 地区列表
     */
    public function area_listOp() {
        $area_id = intval($_REQUEST['area_id']);

        $model_area = Model('area');

        $condition = array();
        if($area_id > 0) {
            $condition['area_parent_id'] = $area_id;
        } else {
            $condition['area_deep'] = 1;
        }
        $area_list = $model_area->getAreaList($condition, 'area_id,area_name');
        //var_dump($area_list);
        output_data(array('area_list' => $area_list));
    }
    
        /**
     * 所有地区列表
     */
    public function all_area_listOp() {
        $area_id = intval($_REQUEST['area_id']);

        $model_area = Model('area');

        $condition = array();

        $condition['area_deep'] = 1;
        
        $area_list = $model_area->getAreaList($condition, 'area_id,area_name');
        foreach ($area_list as $key => $value) {
            $condition2['area_deep'] = 2;
            $condition2['area_parent_id'] = $value['area_id'];
            $area_list2 = $model_area->getAreaList($condition2, 'area_id,area_name');
            $area_list[$key]['chindren_list']=$area_list2;
            foreach ($area_list[$key]['chindren_list'] as $key2 => $value2) {
                $condition3['area_deep'] = 3;
                $condition3['area_parent_id'] = $value2['area_id'];
                $area_list3 = $model_area->getAreaList($condition3, 'area_id,area_name');
                $area_list[$key]['chindren_list'][$key2]['chindren_list']=$area_list3;
            }
        }
        //var_dump($area_list);
        output_data(array('area_list' => $area_list));
    }
    

}
