<?php
/**
 * 会员聊天
 *
 *
 *
 *
 * by 33hao.com 好商城V3 运营版
 */
defined('InShopNC') or exit('Access Invalid!');
//use Shopnc\Tpl;
class member_messageControl extends mobileMemberControl {

	public function __construct(){
		parent::__construct();
	}

	/**
	 * 消息列表
	 *
	 * @param
	 * @return
	 */
	public function message_all_listOp(){
		$model_message	= Model('message');
		$page	= new Page();
		$page->setEachNum(10);
		//$page->setStyle('admin');
                $types=  $model_message->msgType;
                $array=array(1,3,4,5);
                $message_list=array();
                foreach ($array as $value) {
                  $message_array = $model_message->listMessage(array('from_member_id'=>'0','message_type'=>$value,'to_member_id'=>$this->member_info['member_id'],'no_del_member_id'=>$this->member_info['member_id']),$page);
                    if (!empty($message_array) && is_array($message_array)){
			foreach ($message_array as $k=>$v){
				$v['message_open'] = '0';
				if (!empty($v['read_member_id'])){
					$tmp_readid_arr = explode(',',$v['read_member_id']);
					if (in_array($this->member_info['member_id'],$tmp_readid_arr)){
						$v['message_open'] = '1';
                                              //  $msgTypeCount[$message_type]+=1;
					}
				}
				//$v['from_member_name'] = Language::get('home_message_system_message');
				$message_array[$k]	= $v;
			}
                    } 
                    $type=$types[$value];
                    $message_list[$type]=$message_array;
                }
		
                $msgTypeCount=$model_message->msgTypeCount(array('message_open_common'=>0,'from_member_id'=>'0','message_type_in'=>"1,3,4,5",'to_member_id'=>$this->member_info['member_id'],'no_del_member_id'=>$this->member_info['member_id']),$page);

                
		//Tpl::output('show_page',$page->show());
		output_data(array('message_list'=>$message_list,'msg_type_unread_ount'=>$msgTypeCount));
               // output_data($datas, $extend_data);
		// 新消息数量

	}
        
        /**
     * 最近联系人
     */
	/**
	 * 消息列表
	 *
	 * @param
	 * @return
	 */
	public function message_listOp(){
		$model_message	= Model('message');
                $types=  $model_message->msgType;
                $message_type=$_REQUEST['message_type'];
                if(empty($message_type)||$message_type<0){
                    output_special_code('10500');
                }
		$page	= new Page();
		$page->setEachNum($this->page);
		//$page->setStyle('admin');
                
		$message_array	= $model_message->listMessage(array('from_member_id'=>'0','message_type'=>$message_type,'to_member_id'=>$this->member_info['member_id'],'no_del_member_id'=>$this->member_info['member_id']),$page);

                $msgTypeCount=$model_message->msgTypeCount(array('message_open_common'=>0,'from_member_id'=>'0','message_type_in'=>$message_type,'to_member_id'=>$this->member_info['member_id'],'no_del_member_id'=>$this->member_info['member_id']),$page);

                if (!empty($message_array) && is_array($message_array)){
			foreach ($message_array as $k=>$v){
				$v['message_open'] = '0';
				if (!empty($v['read_member_id'])){
					$tmp_readid_arr = explode(',',$v['read_member_id']);
					if (in_array($this->member_info['member_id'],$tmp_readid_arr)){
						$v['message_open'] = '1';
                                               // $msgTypeCount[$message_type]+=1;
					}
				}
				//$v['from_member_name'] = Language::get('home_message_system_message');
				$message_array[$k]	= $v;
			}
		}
                
		//Tpl::output('show_page',$page->show());
                
		output_data(array('message_list'=>$message_array,'msg_type_unread_ount'=>$msgTypeCount[$type[$message_type]]),mobile_page($page->getTotalPage()));
               // output_data($datas, $extend_data);
		// 新消息数量

	}
        
	/**
	 * 会员信息
	 *
	 */
	public function get_infoOp(){
		$val = '';
		$member = array();
		$model_chat	= Model('web_chat');
		$types = array('member_id','member_name','store_id','member');
		$key = $_POST['t'];
		$member_id = intval($_POST['u_id']);
		if(trim($key) != '' && in_array($key,$types)){
			$member_info = $model_chat->getMember($member_id);
			output_data(array('member_info' => $member_info));
		}
	}

	/**
	 * 发消息
	 *
	 */
	public function send_msgOp(){
		$member = array();
		$model_chat	= Model('web_chat');
		$member_id = $this->member_info['member_id'];
		$member_name = $this->member_info['member_name'];
		$t_id = intval($_POST['t_id']);
		$t_name = trim($_POST['t_name']);
		$member = $model_chat->getMember($t_id);
		if ($t_name != $member['member_name']) output_error('接收消息会员账号错误');

		$msg = array();
		$msg['f_id'] = $member_id;
		$msg['f_name'] = $member_name;
		$msg['t_id'] = $t_id;
		$msg['t_name'] = $t_name;
		$msg['t_msg'] = trim($_POST['t_msg']);
		if ($msg['t_msg'] != '') $chat_msg = $model_chat->addMsg($msg);
		if ($chat_msg['m_id']) {
			output_data(array('msg' => $chat_msg));
		} else {
			output_error('发送失败，请稍后重新发送');
		}
	}

	/**
	 * 商品图片和名称
	 *
	 */
	public function get_goods_infoOp(){
	    $model_chat	= Model('web_chat');
	    $goods_id = intval($_POST['goods_id']);
	    $goods = $model_chat->getGoodsInfo($goods_id);
	    output_data(array('goods' => $goods));
	}

	/**
	 * 聊天记录查询
	 *
	 */
	public function get_chat_logOp(){
		$member_id = $this->member_info['member_id'];
		$t_id = intval($_POST['t_id']);
		$add_time_to = date("Y-m-d");
		$time_from = array();
		$time_from['7'] = strtotime($add_time_to)-60*60*24*7;
		$time_from['15'] = strtotime($add_time_to)-60*60*24*15;
		$time_from['30'] = strtotime($add_time_to)-60*60*24*30;

		$key = $_POST['t'];
		if(trim($key) != '' && array_key_exists($key,$time_from)){
			$model_chat	= Model('web_chat');
			$list = array();
			$condition_sql = " add_time >= '".$time_from[$key]."' ";
			$condition_sql .= " and ((f_id = '".$member_id."' and t_id = '".$t_id."') or (f_id = '".$t_id."' and t_id = '".$member_id."'))";
			$list = $model_chat->getLogList($condition_sql,$this->page);

			$total_page = $model_chat->gettotalpage();
			output_data(array('list' => $list), mobile_page($total_page));
		}
	}

	/**
	 * node信息
	 *
	 */
	public function get_node_infoOp(){
		$member_id = $this->member_info['member_id'];
		$model_chat	= Model('web_chat');
		$member_info = $model_chat->getMember($member_id);
        Tpl::output('member_info', $member_info);
        Tpl::showpage('node_info');
	}
}
