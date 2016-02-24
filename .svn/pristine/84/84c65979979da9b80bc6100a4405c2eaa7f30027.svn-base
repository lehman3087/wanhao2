<?php
/**
 * 前台品牌分类
 *
 *
 *
 **by 好商城V3 www.33hao.com 运营版*/


defined('InShopNC') or exit('Access Invalid!');
class bid_documentControl extends BaseSellerControl {
    
    private $bid_states=array(
        '0'=>'放弃',//作废,需要重新发布，
        '1'=>'等待定标',//可以修改
        '2'=>'胜出',//查看其他标书，不可修改
        '3'=>'落选'//查看获胜标书
    );
    public function __construct() {
        parent::__construct();
      
    }
    
    public function testOp($param) {
        $string =  '[{"type":"image","value":"http://localhost/33hao/data/upload/shop/store/goods/1/1_05018074579020438_1280.png"}]';
        $body = json_decode($string, true);
        var_dump($body);
        
    }
    
    public function updateBdOp($param) {
        
        if (chksubmit()) {
            $model_bid = Model('bid');
            
           // var_dump($_REQUEST);
            $condition['bid_work_id']=$_REQUEST['bid_work_id'];
            $condition['bid_user_id']=$_REQUEST['bid_user_id'];
            $data['bid_title']=$_REQUEST['bid_title'];
            $data['bid_highlight']=$_REQUEST['bid_highlight'];
            $data['bid_budget']=$_REQUEST['bid_budget'];
         
            if ($_REQUEST['m_body'] != '') {
               // var_dump($_REQUEST['m_body']);
                $_REQUEST['m_body'] = str_replace('&quot;', '"', $_REQUEST['m_body']);
                $_REQUEST['m_body'] = str_replace('\\', '', $_REQUEST['m_body']);
                $_REQUEST['m_body'] = json_decode($_REQUEST['m_body'], true);
               // var_dump($_REQUEST['m_body']);
                if (!empty($_REQUEST['m_body'])) {
                    $_REQUEST['m_body'] = serialize($_REQUEST['m_body']);
                } else {
                    $_REQUEST['m_body'] = '';
                }
            }
            $data['bid_content']        = $_REQUEST['m_body'];
            
           // $data['bid_content']=$_REQUEST['m_body'];
            $data['bid_lastuptime']=time();
            $data['bid_dc_id']=$_SESSION['store_id'];
            $model_bid->editBid($data,$condition);
 
        }
        showMessage('修改成功',$_REQUEST['ref_url']);
    }
    
    
    public function editBdOp() {
        $condition['dw_id']=$_REQUEST['commonid'];
        $model_work = Model('decoration');
        $model_bid = Model('bid');
        $condition_bid['bid_work_id']=$_REQUEST['commonid'];
        $condition_bid['bid_dc_id']=$_SESSION['store_id'];
        $dw=$model_work->getRequestInfo($condition);
        $bid=$model_bid->getBidInfo($condition_bid);
      // var_dump($bid);
        
        if(!checkbid($_REQUEST)){
            showMessage('已达到最大投标限制，请注意规则',$_REQUEST['ref_url']);
        }
        
        if(chksubmit()){
           // $check=checkbid();
            
            //var_dump($_REQUEST);
            $data['bid_work_id']=$_REQUEST['bid_work_id'];
            $data['bid_user_id']=$_REQUEST['bid_user_id'];
            $data['bid_title']=$_REQUEST['bid_title'];
            $data['bid_highlight']=$_REQUEST['bid_highlight'];
            $data['bid_budget']=$_REQUEST['bid_budget'];
            
            if ($_REQUEST['m_body'] != '') {
               // var_dump($_REQUEST['m_body']);
                $_REQUEST['m_body'] = str_replace('&quot;', '"', $_REQUEST['m_body']);
                $_REQUEST['m_body'] = str_replace('\\', '', $_REQUEST['m_body']);
                $_REQUEST['m_body'] = json_decode($_REQUEST['m_body'], true);
               // var_dump($_REQUEST['m_body']);
                if (!empty($_REQUEST['m_body'])) {
                    $_REQUEST['m_body'] = serialize($_REQUEST['m_body']);
                } else {
                    $_REQUEST['m_body'] = '';
                }
            }
            $data['bid_content']        = $_REQUEST['m_body'];
            
           // $data['bid_content']=$_REQUEST['m_body'];
            $data['bid_addtime']=time();
            $data['bid_dc_id']=$_SESSION['store_id'];
            $model_bid->addBid($data);
        }
        
        Tpl::output('dw', $dw);
        Tpl::output('bid', $bid);
        
       // $this->profile_menu('decoration', 'decoration');
        Tpl::showpage('decoration_bd_form');
    }
    
    
    
    public function bd_listOp() {
        $model_bid = Model('bid');
       
        $where = array();
        $where['bid_dc_id']=$_SESSION['store_id'];
        if (intval($_GET['stc_id']) > 0) {
            $where['bid_state'] = $_GET['stc_id'];
        }
        if (trim($_GET['keyword']) != '') {
            switch ($_GET['search_type']) {
                case 'bid_work_id':
                    $where['bid_work_id'] = intval($_GET['keyword']);
                    break;
                case 'bid_title':
                    $where['bid_title'] = array('like', '%' . trim($_GET['keyword']) . '%');
                    break;
                case 'bid_highlight':
                     $where['bid_highlight'] = array('like', '%' . trim($_GET['keyword']) . '%');
                    break;
                case 'bid_budget':
                    $calcufu= $_GET['calculate_type'];
                    $where['bid_budget'] = array($calcufu,  intval($_GET['keyword']));
                    break;
                case 'bid_addtime':
                    $stime = $_GET['search_stime']?strtotime($_GET['search_stime']):0;
                    $etime = $_GET['search_etime']?strtotime($_GET['search_etime']):0;
                    if ($stime > 0 && $etime>0){
                        $where['bid_addtime'] = array('between',array($stime,$etime));
                    }elseif ($stime > 0){
                        $where['bid_addtime'] = array('egt',$stime);
                    }elseif ($etime > 0){
                        $where['bid_addtime'] = array('elt',$etime);
                    }
                    break;
            }
        }
        
        $bid_list = $model_bid->getBidList($where);
        
        
        Tpl::output('bid_states', $this->bid_states);
       // var_dump($bid_list);
        Tpl::output('show_page', $model_bid->showpage());
        Tpl::output('bid_list', $bid_list);

        //$this->profile_menu('work_list', 'work_list');
        Tpl::showpage('decoration_bid_list');
    }
    
    public function drop_bidOp() {
        $condition['bid_id']=$_REQUEST['commonid'];
        //$condition['bid_dc_id']=$_REQUEST['bid_dc_id'];
        $data['bid_state']=0;
        $model_bid = Model('bid');
        $result=$model_bid->editBid($data,$condition);
        
        if($result){
            showDialog('已放弃', 'reload', 'succ');
           // Tpl::showpage('bd_list');
        }
    }
    
    
    public function bd_list2Op() {
        $model_work = Model('decoration');
       
        $where = array();
        //$where['store_id'] = $_SESSION['store_id'];
        if (intval($_GET['stc_id']) > 0) {
            $where['goods_stcids'] = array('like', '%,' . intval($_GET['stc_id']) . ',%');
        }
        if (trim($_GET['keyword']) != '') {
            switch ($_GET['search_type']) {
                case 0:
                    $where['goods_name'] = array('like', '%' . trim($_GET['keyword']) . '%');
                    break;
                case 1:
                    $where['goods_serial'] = array('like', '%' . trim($_GET['keyword']) . '%');
                    break;
                case 2:
                    $where['goods_commonid'] = intval($_GET['keyword']);
                    break;
            }
        }
        $work_list = $model_work->getworkCommonOnlineList($where);
        
        //var_dump($work_list);
        Tpl::output('show_page', $model_work->showpage());
        Tpl::output('work_list', $work_list);

        //$this->profile_menu('work_list', 'work_list');
        Tpl::showpage('decoration_bid_list');
    }
    
}
