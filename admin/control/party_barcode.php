<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

defined('InShopNC') or exit('Access Invalid!');
class party_barcodeControl extends SystemControl{
    
    
    public function __construct(){
		parent::__construct();		
    }
        
        
    public function indexOp(){
        $model_party_barcode = Model('party_barcode');
        
        /**
         * 查询条件
         */
        $where = array();
        if ($_GET['search_PB_code'] != '') {
            $where['code'] = array('like', '%' . trim($_GET['search_PB_code']) . '%');
        }
        if ($_GET['search_PB_address']!= '') {
             $where['address'] = array('like', '%' . trim($_GET['search_PB_address']) . '%');
        }
        
      //  var_dump($where);
        
	$payment_list = $model_party_barcode->getPBList($where);
	Tpl::output('party_barcode_list',$payment_list);
        Tpl::output('page', $model_party_barcode->showpage(2));
      //  var_dump($model_party_barcode->showpage(2));
	Tpl::showpage('party_barcodes.index');
            
    }
    
    
    
    
    /**
	 * 添加停车位
	 */
	public function party_addOp(){
          
            require_once(BASE_RESOURCE_PATH.DS.'phpqrcode'.DS.'index.php');
            $PhpQRCode = new PhpQRCode();
            $PhpQRCode->set('pngTempDir',BASE_UPLOAD_PATH.DS.ATTACH_STORE.DS.'party'.DS);
            
            
		//$lang	= Language::getLangContent();
		$model_party_barcode = Model('party_barcode');
		if (chksubmit()){
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
				array("input"=>$_POST["code"], "require"=>"true", "message"=>"请输入编码"),
                                array("input"=>$_POST["address"], "require"=>"true", "message"=>"请输入地址")
			);
			$error = $obj_validate->validate();
			if ($error != ''){
				showMessage($error);
			}else {
				$PB = array();
				$PB['code']		= $_POST['code'];
				$PB['address']	= $_POST['address'];
                                $PB['lastuptime']=time();
				
				$return = $model_party_barcode->addPB($PB);
                                 // 生成商品二维码
        if (!empty($return)) {
            //QueueClient::push('createGoodsQRCode', array('store_id' => $_SESSION['store_id'], 'goodsid_array' => $goodsid_array));
             // 生成停车位二维码
            
                    $PhpQRCode->set('date',$return);
                    $PhpQRCode->set('pngTempName', $return . '.png');
                    $PhpQRCode->init();
//                    $model_party_barcode->editPB(
//					array('barcodeurl'=>trim($_GET['value'])),
//					'spec'
//				);
	}
        
        
				if($return) {
					$url = array(
						array(
							'url'=>'index.php?act=party_barcode&op=party_add',
							'msg'=>"继续添加"
						),
						array(
							'url'=>'index.php?act=party_barcode&op=index',
							'msg'=>"查看所有"
						)
					);
					$this->log('新建停车位['.$_POST['s_name'].']',1);
					showMessage("添加成功", $url);
				}else {
					$this->log('[新建停车位'.$_POST['s_name'].']',0);
					showMessage("添加失败");
				}
			}
		}
		// 一级商品分类
		//$gc_list = H('party_codes') ? H('party_codes') : H('party_codes', true);
		//Tpl::output('gc_list', $gc_list);
		
		Tpl::showpage('party_barcode.add');
	}
        
        	/**
	 * ajax操作
	 */
	public function ajaxOp(){
		//规格模型
		$model_party_barcode = Model('party_barcode');
		
		switch ($_GET['branch']){
			case 'change_value':
//			case 'name':
				$return = $model_party_barcode->editPB(
					array($_GET['column']=>trim($_GET['value'])),
					array('id'=>intval($_GET['id'])),
					'spec'
				);
				if($return){
					$this->log('更改数据'.'[ID:'.intval($_GET['id']).']',1);
					echo 'true';exit;
				}else{
					echo 'false';exit;
				}
				break;
		}
	}
        
        public function delOp($param) {
            $model_party_barcode = Model('party_barcode');
            $id=$_GET['del_id'];
            
            $condition=array('id'=>$id);
            $return=$model_party_barcode->delPB($condition);
            if($return) {
					$url = array(
						array(
							'url'=>'index.php?act=party_barcode&op=index',
							'msg'=>"删除成功"
						)
					);
					//$this->log('新建停车位['.$_POST['s_name'].']',1);
					showMessage("添加成功", $url);
				}
        }
    
    
    
}