<?php
/**
 * 我的购物车
 *
 *
 *
 *
 * by 33hao.com 好商城V3 运营版
 */

//use Shopnc\Tpl;

defined('InShopNC') or exit('Access Invalid!');

class member_cartControl extends mobileMemberControl {

	public function __construct() {
		parent::__construct();
	}

     /**
     * 购物车列表
     */
    public function cart_item_listOp() {
        $model_cart = Model('cart');
        $condition = array('buyer_id' => $this->member_info['member_id']);
        $cart_list	= $model_cart->listCart('db', $condition);
        $logic_buy_1 = logic('buy_1');
        $cart_list = $logic_buy_1->getGoodsCartList($cart_list);
           
        $model_mansong = Model('p_mansong');
        $model_voucher = Model('voucher');
        $model_store = Model('store');
        $sum = 0;
        foreach ($cart_list as $key => $value) {
            $cart_list[$key]['goods_image_url'] = cthumb($value['goods_image'], $value['store_id']);
            $cart_list[$key]['goods_sum'] = ncPriceFormat($value['goods_price'] * $value['goods_num']);
            $cart_list[$key]['goods_num'] = $value['goods_num'];
            $cart_list[$key]['p_mansong'] = $value['goods_num'];
            $sum += $cart_list[$key]['goods_sum'];
        }
        
        $newarray=array();
        foreach ($cart_list as $key => $value) {
            $newarray[$value['store_id']] = $model_store->getStoreInfoByID($value['store_id']);    
        }
        foreach ($cart_list as $key => $value) {
            $newarray[$value['store_id']]['cart_item_list'][]=$cart_list[$key];
            $newarray[$value['store_id']]['mansong_info'] = $model_mansong->getMansongInfoByStoreID($value['store_id']);
            $_condition['voucher_store_id']=$value['store_id'];
            $newarray[$value['store_id']]['store_voucher_list'] = $model_voucher->getCurrentAvailableVoucher($_condition);
        }
        $newarray2=  array_values($newarray);
        output_data(array('cart_list' => $newarray2, 'sum' => ncPriceFormat($sum)));
    }
    /**
     * 购物车添加
     */
    public function cart_item_addOp() {

        $goods_id = intval($_REQUEST['goods_id']);
        $quantity = intval($_REQUEST['quantity']);
        if($goods_id <= 0 || $quantity <= 0) {
            output_error('参数错误');
        }
        $model_goods = Model('goods');
        $model_cart	= Model('cart');
        $logic_buy_1 = Logic('buy_1');

        $goods_info = $model_goods->getGoodsOnlineInfoAndPromotionById($goods_id);

        //验证是否可以购买
	if(empty($goods_info)) {
            output_error('商品已下架或不存在');
	}

		//抢购
		$logic_buy_1->getGroupbuyInfo($goods_info);
		
		//限时折扣
		$logic_buy_1->getXianshiInfo($goods_info,$quantity);

        if ($goods_info['store_id'] == $this->member_info['store_id']) {
            output_error('不能购买自己发布的商品');
		}
		if(intval($goods_info['goods_storage']) < 1 || intval($goods_info['goods_storage']) < $quantity) {
            output_error('库存不足');
		}

        $param = array();
        $param['buyer_id']	= $this->member_info['member_id'];
        $param['store_id']	= $goods_info['store_id'];
        $param['goods_id']	= $goods_info['goods_id'];
        $param['goods_name'] = $goods_info['goods_name'];
        $param['goods_price'] = $goods_info['goods_price'];
        $param['goods_image'] = $goods_info['goods_image'];
        $param['store_name'] = $goods_info['store_name'];

        $result = $model_cart->addCart($param, 'db', $quantity);
        if($result) {
            output_data('1');
        } else {
            output_error('收藏失败');
        }
    }
    /**
     * 购物车删除
     */
    public function cart_delOp() {
        $cart_id = intval($_REQUEST['cart_item_id']);

        $model_cart = Model('cart');

        if($cart_id > 0) {
            $condition = array();
            $condition['buyer_id'] = $this->member_info['member_id'];
            $condition['cart_id'] = $cart_id;

            $model_cart->delCart('db', $condition);
        }else{
            output_error('参数错误');
        }

        output_data('1');
    }
    
        /**
     * 购物车删除
     */
    public function carts_delOp() {
        $cart_ids_string = $_REQUEST['cart_item_ids'];
        
        $cart_ids=  explode(',', $cart_ids_string);
       // var_dump(empty($cart_ids));
        if(!is_array($cart_ids)||empty($cart_ids_string)){
            output_special_code('10400','参数错误');
        }
        $model_cart = Model('cart');
        
        $condition = array();
            $condition['buyer_id'] = $this->member_info['member_id'];
            $condition['cart_id'] = array('in',$cart_ids);

           $result= $model_cart->delCart('db', $condition);
          // var_dump($result);
         //  exit();
           //$af=mysql_affected_rows();
          
        if($result) {
            output_data('1');
        }else{
            //output_error('参数错误');
             output_special_code('10500','参数错误');
        }

        
    }
    

    /**
     * 更新购物车购买数量
     */
    public function cart_item_edit_quantity1Op() {
        $cart_id = intval(abs($_REQUEST['cart_item_id']));
		$quantity = intval(abs($_REQUEST['quantity']));
		if(empty($cart_id) || empty($quantity)) {
            output_error('参数错误');
		}

		$model_cart = Model('cart');

        $cart_info = $model_cart->getCartInfo(array('cart_id'=>$cart_id, 'buyer_id' => $this->member_info['member_id']));

        //检查是否为本人购物车
        if($cart_info['buyer_id'] != $this->member_info['member_id']) {
            output_error('参数错误');
        }

        //检查库存是否充足
        if(!$this->_check_goods_storage($cart_info, $quantity, $this->member_info['member_id'])) {
            output_error('库存不足');
        }

        $data = array();
        $data['goods_num'] = $quantity;
        $update = $model_cart->editCart($data, array('cart_id'=>$cart_id));
		if ($update) {
                            $return = array();
                        $return['quantity'] = $quantity;
			$return['goods_price'] = ncPriceFormat($cart_info['goods_price']);
			$return['total_price'] = ncPriceFormat($cart_info['goods_price'] * $quantity);
                    output_data($return);
		} else {
            output_error('修改失败');
		}
    }
    
    
    
    	/**
	 * 购物车更新商品数量
	 */
	public function cart_item_edit_quantityOp() {
		$cart_id	= intval(abs($_REQUEST['cart_item_id']));
		$quantity	= intval(abs($_REQUEST['quantity']));

		if(empty($cart_id) || empty($quantity)) {
                    output_error('更新失败');
			//exit(json_encode(array('msg'=>Language::get('cart_update_buy_fail','UTF-8'))));
		}

		$model_cart = Model('cart');
		$model_goods= Model('goods');
		$logic_buy_1 = logic('buy_1');

		//存放返回信息
		$return = array();

		$cart_info = $model_cart->getCartInfo(array('cart_id'=>$cart_id,'buyer_id'=>$_SESSION['member_id']));
		if ($cart_info['bl_id'] == '0') {

		    //普通商品
		    $goods_id = intval($cart_info['goods_id']);
		    $goods_info	= $logic_buy_1->getGoodsOnlineInfo($goods_id,$quantity);
		    if(empty($goods_info)) {
		       // $return['state'] = 'invalid';
		        //$return['msg'] = '商品已被下架';
		      //  $return['subtotal'] = 0;
		        QueueClient::push('delCart', array('buyer_id'=>$this->member_info['member_id'],'cart_ids'=>array($cart_id)));
		      // output_error('商品已被下架');
                       output_special_code('10400','商品已被下架');
                       // exit(json_encode($return));
		    }

		    //抢购
		    $logic_buy_1->getGroupbuyInfo($goods_info);

		    //限时折扣
		    $logic_buy_1->getXianshiInfo($goods_info,$quantity);

		    $quantity = $goods_info['goods_num'];

		    if(intval($goods_info['goods_storage']) < $quantity) {
		      //  $return['state'] = 'shortage';
		      //  $return['msg'] = '库存不足';
		      //  $return['goods_num'] = $goods_info['goods_num'];
		      //  $return['goods_price'] = $goods_info['goods_price'];
		       // $return['subtotal'] = $goods_info['goods_price'] * $quantity;
		        $model_cart->editCart(array('goods_num'=>$goods_info['goods_storage']),array('cart_id'=>$cart_id,'buyer_id'=>$this->member_info['member_id']));
		        output_special_code('10400','库存不足');
                       // output_error('库存不足');
                       // exit(json_encode($return));
		    }
		} else {

		    //优惠套装商品
		    $model_bl = Model('p_bundling');
		    $bl_goods_list = $model_bl->getBundlingGoodsList(array('bl_id'=>$cart_info['bl_id']));
		    $goods_id_array = array();
		    foreach ($bl_goods_list as $goods) {
		        $goods_id_array[] = $goods['goods_id'];
		    }
		    $goods_list = $model_goods->getGoodsOnlineListAndPromotionByIdArray($goods_id_array);

		    //如果其中有商品下架，删除
		    if (count($goods_list) != count($goods_id_array)) {
		      //  $return['state'] = 'invalid';
		       // $return['msg'] = '该优惠套装已经无效，建议您购买单个商品';
		       // $return['subtotal'] = 0;
		        QueueClient::push('delCart', array('buyer_id'=>$this->member_info['member_id'],'cart_ids'=>array($cart_id)));
		        output_special_code('10400','该优惠套装已经无效，建议您购买单个商品');
                        //exit(json_encode($return));
		    }

		    //如果有商品库存不足，更新购买数量到目前最大库存
		    foreach ($goods_list as $goods_info) {
		        if ($quantity > $goods_info['goods_storage']) {
		           // $return['state'] = 'shortage';
		           // $return['msg'] = '该优惠套装部分商品库存不足，建议您降低购买数量或购买库存足够的单个商品';
		           // $return['goods_num'] = $goods_info['goods_storage'];
		           // $return['goods_price'] = $cart_info['goods_price'];
		            //$return['subtotal'] = $cart_info['goods_price'] * $quantity;
		            $model_cart->editCart(array('goods_num'=>$goods_info['goods_storage']),array('cart_id'=>$cart_id,'buyer_id'=>$_SESSION['member_id']));
		            output_special_code('10400','该优惠套装部分商品库存不足，建议您降低购买数量或购买库存足够的单个商品');
                            //exit(json_encode($return));
		            break;
		        }
		    }
		    $goods_info['goods_price'] = $cart_info['goods_price'];
		}

		$data = array();
        $data['goods_num'] = $quantity;
        $data['goods_price'] = $goods_info['goods_price'];
        $update = $model_cart->editCart($data,array('cart_id'=>$cart_id,'buyer_id'=>$_SESSION['member_id']));
		if ($update) {
		    $return = array();
			$return['state'] = 'true';
			$return['total_price'] = $goods_info['goods_price'] * $quantity;
			$return['goods_price'] = $goods_info['goods_price'];
			$return['quantity'] = $quantity;
                        
//                         $return['quantity'] = $quantity;
//			$return['goods_price'] = ncPriceFormat($cart_info['goods_price']);
//			$return['total_price'] = ncPriceFormat($cart_info['goods_price'] * $quantity);
                        
                        
		} else {
                    output_error('更新失败');
			//$return = array('msg'=>Language::get('cart_update_buy_fail','UTF-8'));
		}
                output_data($return);;
		//exit(json_encode($return));
	}
        
        
        

    /**
     * 检查库存是否充足
     */
    private function _check_goods_storage($cart_info, $quantity, $member_id) {
		$model_goods= Model('goods');
        $model_bl = Model('p_bundling');
        $logic_buy_1 = Logic('buy_1');

		if ($cart_info['bl_id'] == '0') {
            //普通商品
		    $goods_info	= $model_goods->getGoodsOnlineInfoAndPromotionById($cart_info['goods_id']);

		    //抢购
		    $logic_buy_1->getGroupbuyInfo($goods_info);

		    //限时折扣
		    $logic_buy_1->getXianshiInfo($goods_info,$quantity);
 
		    $quantity = $goods_info['goods_num'];
		    if(intval($goods_info['goods_storage']) < $quantity) {
                return false;
		    }
		} else {
		    //优惠套装商品
		    $bl_goods_list = $model_bl->getBundlingGoodsList(array('bl_id' => $cart_info['bl_id']));
		    $goods_id_array = array();
		    foreach ($bl_goods_list as $goods) {
		        $goods_id_array[] = $goods['goods_id'];
		    }
		    $bl_goods_list = $model_goods->getGoodsOnlineListAndPromotionByIdArray($goods_id_array);

		    //如果有商品库存不足，更新购买数量到目前最大库存
		    foreach ($bl_goods_list as $goods_info) {
		        if (intval($goods_info['goods_storage']) < $quantity) {
                    return false;
		        }
		    }
		}
        return true;
    }
    
    
    
    	/**
	 * 加入购物车，登录后存入购物车表
	 * 存入COOKIE，由于COOKIE长度限制，最多保存5个商品
	 * 未登录不能将优惠套装商品加入购物车，登录前保存的信息以goods_id为下标
	 *
	 */
	public function add_blOp() {
	    $model_goods = Model('goods');
	    $logic_buy_1 = Logic('buy_1');
//        if (is_numeric($_REQUEST['goods_id'])) {
//
//            //商品加入购物车(默认)
//            $goods_id = intval($_REQUEST['goods_id']);
//            $quantity = intval($_REQUEST['quantity']);
//            if ($goods_id <= 0) return ;
//            $goods_info	= $model_goods->getGoodsOnlineInfoAndPromotionById($goods_id);
//
//            //抢购
//            $logic_buy_1->getGroupbuyInfo($goods_info);
//
//            //限时折扣
//            $logic_buy_1->getXianshiInfo($goods_info,$quantity);
//
//            $this->_check_goods($goods_info,$_REQUEST['quantity']);
//
//        } elseif (is_numeric($_REQUEST['bl_id'])) {

            //优惠套装加入购物车(单套)
//          $this->member_info['member_id']
            
            $bl_id = intval($_REQUEST['bl_id']);
            if ($bl_id <= 0) return ;
            $model_bl = Model('p_bundling');
            $bl_info = $model_bl->getBundlingInfo(array('bl_id'=>$bl_id));
            if (empty($bl_info) || $bl_info['bl_state'] == '0') {
                
                //exit(json_encode(array('msg'=>'该优惠套装已不存在，建议您单独购买','UTF-8')));
            }

            //检查每个商品是否符合条件,并重新计算套装总价
            $bl_goods_list = $model_bl->getBundlingGoodsList(array('bl_id'=>$bl_id));
            $goods_id_array = array();
            $bl_amount = 0;
            foreach ($bl_goods_list as $goods) {
            	$goods_id_array[] = $goods['goods_id'];
            	$bl_amount += $goods['bl_goods_price'];
            }
            $model_goods = Model('goods');
            $goods_list = $model_goods->getGoodsOnlineListAndPromotionByIdArray($goods_id_array);
            foreach ($goods_list as $goods) {
                $this->_check_goods($goods,1);
            }

            //优惠套装作为一条记录插入购物车，图片取套装内的第一个商品图
            $goods_info    = array();
            $goods_info['store_id']	= $bl_info['store_id'];
            $goods_info['goods_id']	= $goods_list[0]['goods_id'];
            $goods_info['goods_name'] = $bl_info['bl_name'];
            $goods_info['goods_price'] = $bl_amount;
            $goods_info['goods_num']   = 1;
            $goods_info['goods_image'] = $goods_list[0]['goods_image'];
            $goods_info['store_name'] = $bl_info['store_name'];
            $goods_info['bl_id'] = $bl_id;
            $quantity = 1;

            $save_type = 'db';
            $goods_info['buyer_id'] = $this->member_info['member_id'];

        $model_cart	= Model('cart');
        $insert = $model_cart->addCart($goods_info,$save_type,$quantity);
        
        //直接购买
        if ($insert) {
           $cart_id=$insert.'|1';
          $logic_buy = logic('buy');
          $result = $logic_buy->buyStep1($cart_id, $_REQUEST['ifcart'], $this->member_info['member_id'], $this->member_info['store_id']);
        
            //得到购买数据
      //  $result = $logic_buy->buyStep1($cart_id, $_REQUEST['ifcart'], $this->member_info['member_id'], $this->member_info['store_id']);
        
        
        if(!$result['state']) {
           // var_dump($result['msg']);
            output_error($result['msg']);
        } else {
            $result = $result['data'];
        }
        
        //整理数据
        $store_cart_list = array();
        foreach ($result['store_cart_list'] as $key => $value) {
            $store_cart_list[$key]['goods_list'] = $value;
            $store_cart_list[$key]['store_goods_total'] = $result['store_goods_total'][$key];
            if(!empty($result['store_premiums_list'][$key])) {
                $result['store_premiums_list'][$key][0]['premiums'] = true;
                $result['store_premiums_list'][$key][0]['goods_total'] = 0.00;
                $store_cart_list[$key]['goods_list'][] = $result['store_premiums_list'][$key][0];
            }
            $store_cart_list[$key]['store_mansong_rule_list'] = $result['store_mansong_rule_list'][$key];
            $store_cart_list[$key]['store_voucher_list'] = $result['store_voucher_list'][$key];
            if(!empty($result['cancel_calc_sid_list'][$key])) {
                $store_cart_list[$key]['freight'] = '0';
                $store_cart_list[$key]['freight_message'] = $result['cancel_calc_sid_list'][$key]['desc'];
            } else {
                $store_cart_list[$key]['freight'] = '1';
            }
            $store_cart_list[$key]['store_name'] = $value[0]['store_name'];
            $store_cart_list[$key]['store_id'] = $value[0]['store_id'];
             
        }
        
        foreach ($store_cart_list as $key => $value) {
            $store_cart_list[$key]['store_voucher_list']=  array_values($value['store_voucher_list']);
        }
        
        $buy_list = array();
        $buy_list['store_cart_list'] = array_values($store_cart_list);
        
        $buy_list['freight_hash'] = $result['freight_list'];
        $buy_list['address_info'] = $result['address_info'];
        $buy_list['ifshow_offpay'] = $result['ifshow_offpay'];
        $buy_list['vat_hash'] = $result['vat_hash'];
        $buy_list['inv_info'] = $result['inv_info'];
        $buy_list['available_predeposit'] = $result['available_predeposit'];
        $buy_list['available_rc_balance'] = $result['available_rc_balance'];
        
        output_data($buy_list);
        
        
        
            //购物车商品种数记入cookie
            //setNcCookie('cart_goods_num',$model_cart->cart_goods_num,2*3600);
         //   $data = array('state'=>'true', 'num' => $model_cart->cart_goods_num, 'amount' => ncPriceFormat($model_cart->cart_all_price));
        
        
        } else {
            output_error(array('state'=>'false'));
        }
        // output_data($data);
	//  exit(json_encode($data));
	}
      
        
        
      public function check_bl_add_cartOp() {   
	 $model_goods = Model('goods');
	 $logic_buy_1 = Logic('buy_1');
         $bl_ids_string = $_REQUEST['bl_item_ids'];
        
        $bl_ids=  explode(',', $bl_ids_string);
        $bl_ids=array_filter($bl_ids);
       // var_dump(empty($cart_ids));
        if(!is_array($bl_ids)){
            output_error('参数错误');
           // output_special_code('10400','参数错误');
        }
        
        
        $datar=array();
        
         $model_cart	= Model('cart');
         $model_cart->beginTransaction();
         
        foreach ($bl_ids as $key => $value) {
            
            $bl_id_count=  explode('|', $value);
            
            $bl_id = intval($bl_id_count[0]);
            if ($bl_id <= 0) return ;
            $model_bl = Model('p_bundling');
            $bl_info = $model_bl->getBundlingInfo(array('bl_id'=>$bl_id));
            if (empty($bl_info) || $bl_info['bl_state'] == '0') {
                output_special_code('10400',array('bl_id'=>$value,'message'=>'优惠套装已结束'));
               // output_error();
                //exit(json_encode(array('msg'=>'该优惠套装已不存在，建议您单独购买','UTF-8')));
            }

            //检查每个商品是否符合条件,并重新计算套装总价
            $bl_goods_list = $model_bl->getBundlingGoodsList(array('bl_id'=>$bl_id));
            $goods_id_array = array();
            $bl_amount = 0;
            foreach ($bl_goods_list as $goods) {
            	$goods_id_array[] = $goods['goods_id'];
            	$bl_amount += $goods['bl_goods_price'];
            }
            $model_goods = Model('goods');
            $goods_list = $model_goods->getGoodsOnlineListAndPromotionByIdArray($goods_id_array);
            foreach ($goods_list as $goods) {
                $this->_check_goods_and_roolback($goods,$bl_id_count[1],$model_cart,$bl_id_count[0]);
            }

            //优惠套装作为一条记录插入购物车，图片取套装内的第一个商品图
            $goods_info    = array();
            $goods_info['store_id']	= $bl_info['store_id'];
            $goods_info['goods_id']	= $goods_list[0]['goods_id'];
            $goods_info['goods_name'] = $bl_info['bl_name'];
            $goods_info['goods_price'] = $bl_amount;
            $goods_info['goods_num']   = 1;
            $goods_info['goods_image'] = $goods_list[0]['goods_image'];
            $goods_info['store_name'] = $bl_info['store_name'];
            $goods_info['bl_id'] = $bl_id;
            $quantity = $bl_id_count[1];

            $save_type = 'db';
            $goods_info['buyer_id'] = $this->member_info['member_id'];

       
        $insert = $model_cart->addCart($goods_info,$save_type,$quantity);
        
        //插入成功
            if ($insert) {
                $datac['cart_id']=$insert;
                $datac['bl_id']=$bl_id;
                $datar[]=$datac;
             //   $datar[]=$insert.'|'.$bl_id_count[1];
               // output_data(array('cart_id'=>$insert));
             } else {
                 $model_cart->rollback();
                output_error(array('state'=>'false'));
            } 
        }
        
       $model_cart->commit();   
       output_data(array('bl_carts'=>$datar));
        // output_data($data);
	  //  exit(json_encode($data));
    }
    
        /**
	 * 检查商品是否符合加入购物车条件
	 * @param unknown $goods
	 * @param number $quantity
	 */
	private function _check_goods($goods_info, $quantity) {
		if(empty($quantity)) {
                    output_error();
			//exit(json_encode(array('msg'=>Language::get('wrong_argument','UTF-8'))));
		}
		if(empty($goods_info)) {
                    output_error();
			//exit(json_encode(array('msg'=>Language::get('cart_add_goods_not_exists','UTF-8'))));
		}
		if ($goods_info['store_id'] == $_SESSION['store_id']) {
                    output_error();
			//exit(json_encode(array('msg'=>Language::get('cart_add_cannot_buy','UTF-8'))));
		}
		if(intval($goods_info['goods_storage']) < 1) {
                    output_error();
			//exit(json_encode(array('msg'=>Language::get('cart_add_stock_shortage','UTF-8'))));
		}
		if(intval($goods_info['goods_storage']) < $quantity) {
                    output_error();
			//exit(json_encode(array('msg'=>Language::get('cart_add_too_much','UTF-8'))));
		}
		if ($goods_info['is_virtual'] || $goods_info['is_fcode'] || $goods_info['is_presell']) {
                    output_error();
		  //  exit(json_encode(array('msg'=>'该商品不允许加入购物车，请直接购买','UTF-8')));
		}
	}
  
                	/**
	 * 检查商品是否符合加入购物车条件
	 * @param unknown $goods
	 * @param number $quantity
	 */
	private function _check_goods_and_roolback($goods_info, $quantity,$model,$bl_id) {
		if(empty($quantity)) {
                    $model->rollback();
                    output_error();
			//exit(json_encode(array('msg'=>Language::get('wrong_argument','UTF-8'))));
		}
		if(empty($goods_info)) {
                    $model->rollback();
                    output_error();
                    
			//exit(json_encode(array('msg'=>Language::get('cart_add_goods_not_exists','UTF-8'))));
		}
		if ($goods_info['store_id'] == $this->member_info['store_id']) {
                    $model->rollback();
                    output_error();
			//exit(json_encode(array('msg'=>Language::get('cart_add_cannot_buy','UTF-8'))));
		}
		if(intval($goods_info['goods_storage']) < 1) {
                    $model->rollback();
                    output_special_code('10400',array('bl_id'=>$bl_id,'message'=>'暂无商品库存'));
			//exit(json_encode(array('msg'=>Language::get('cart_add_stock_shortage','UTF-8'))));
		}
		if(intval($goods_info['goods_storage']) < $quantity) {
                    $model->rollback();
                    output_special_code('10400',array('bl_id'=>$bl_id,'message'=>'暂无商品库存'));
			//exit(json_encode(array('msg'=>Language::get('cart_add_too_much','UTF-8'))));
		}
		if ($goods_info['is_virtual'] || $goods_info['is_fcode'] || $goods_info['is_presell']) {
                   $model->rollback();
                    output_error();
		  //  exit(json_encode(array('msg'=>'该商品不允许加入购物车，请直接购买','UTF-8')));
		}
	}
        

}
