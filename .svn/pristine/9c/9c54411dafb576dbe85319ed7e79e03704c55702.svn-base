<?php
/**
 * 我的代金券
 *
 *
 *
 *
 * by 33hao.com 好商城V3 运营版
 */

//use Shopnc\Tpl;

defined('InShopNC') or exit('Access Invalid!');

class voucherControl extends mobileMemberControl {

	public function __construct() {
		parent::__construct();
                if (C('voucher_allow') != 1){
                    output_error('暂不支持代金券设置');
			//showDialog(L('voucher_pointunavailable'),'index.php','error');
		}
                
	}

    /**
     * 代金券列表
     */
    public function voucher_listOp() {
	$model_voucher = Model('voucher');
        $voucher_list = $model_voucher->getMemberVoucherList($this->member_info['member_id'], $_POST['voucher_state'], $_POST['pageCount']);
        $page_count = $model_voucher->gettotalpage();

        output_data(array('voucher_list' => $voucher_list), mobile_page($page_count));
    }
    
    
    /*
     * 
     */
    public function store_vouchersOp($param) {
        $logic_buy_1 = Logic('buy_1');
        $logic_buy_1->getStoreAvailableVoucherList();
        
        
    }
    	/*
	 * 获取店铺代金券
	 */
    /**
	 * 代金券列表
	 */
	public function store_voucher_listOp(){
//                //查询会员及其附属信息
//                parent::pointshopMInfo();

		$model_voucher = Model('voucher');

		//代金券模板状态
		$templatestate_arr = $model_voucher->getTemplateState();

		//查询会员信息
		$member_info = Model('member')->getMemberInfoByID($this->member_info['member_id']);

		//查询代金券列表
		$where = array();
                $where['voucher_t_store_id']=$_REQUEST['store_id'];
		$where['voucher_t_state'] = $templatestate_arr['usable'][0];
		$where['voucher_t_end_date'] = array('gt',time());
		if (intval($_REQUEST['sc_id']) > 0){
		    $where['voucher_t_sc_id'] = intval($_REQUEST['sc_id']);
		}
		if (intval($_REQUEST['price']) > 0){
		    $where['voucher_t_price'] = intval($_REQUEST['price']);
		}
		//查询仅我能兑换和所需积分
		$points_filter = array();
		if (intval($_REQUEST['isable']) == 1){
		    $points_filter['isable'] = $member_info['member_points'];
		}
		if (intval($_REQUEST['points_min']) > 0){
		    $points_filter['min'] = intval($_REQUEST['points_min']);
		}
		if (intval($_REQUEST['points_max']) > 0){
		    $points_filter['max'] = intval($_REQUEST['points_max']);
		}
		if (count($points_filter) > 0){
		    asort($points_filter);
		    if (count($points_filter) > 1){
		        $points_filter = array_values($points_filter);
		        $where['voucher_t_points'] = array('between',array($points_filter[0],$points_filter[1]));
		    } else {
		        if ($points_filter['min']){
		            $where['voucher_t_points'] = array('egt',$points_filter['min']);
		        } elseif ($points_filter['max']) {
		            $where['voucher_t_points'] = array('elt',$points_filter['max']);
		        } elseif ($points_filter['isable']) {
		            $where['voucher_t_points'] = array('elt',$points_filter['isable']);
		        }
		    }
		}
		//排序
		switch ($_REQUEST['orderType']){
			case 'exchangenumdesc':
			    $orderby = 'voucher_t_giveout desc,';
			    break;
			case 'exchangenumasc':
			    $orderby = 'voucher_t_giveout asc,';
			    break;
	        case 'pointsdesc':
	            $orderby = 'voucher_t_points desc,';
	            break;
            case 'pointsasc':
                $orderby = 'voucher_t_points asc,';
                break;
		}
		$orderby .= 'voucher_t_id desc';
		$voucherlist = $model_voucher->getVoucherTemplateList($where, '*', 0, 0, $orderby);
                $count=$model_voucher->where($where)->count();
                output_data(array("voucher_list"=>$voucherlist));

	}
    
}
