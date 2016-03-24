<?php
/**
 *
 *
 *
 * @package    library* www.33hao.com 专业团队 提供售后服务
 */
class sendMemberMsg {
    private $code = '';
    private $member_id = 0;
    private $member_info = array();
    private $mobile = '';
    private $email = '';

    /**
     * 设置
     *
     * @param mixed $key
     * @param mixed $value
     */
    public function set($key,$value){
        $this->$key = $value;
    }
    
    
      public function pushAndroidAll($param) {
            // 创建SDK对象.
            
  
            $sdk = new PushSDK();
            
          //  $channelId = '3785562685113372034';

            // message content.
            $message = array (
                // 消息的标题.
                'title' => $param['title'],
                // 消息内容 
                'description' => $param['content'],
                'custom_content'=>array('uri'=>$param['uri'],'invalid'=>$param['invalid']),

            );

            // 设置消息类型为 通知类型.
            $opts = array (
                'msg_type' => 1 
            );

            // 向目标设备发送一条消息
            //$rs = $sdk -> pushMsgToSingleDevice($channelId, $message, $opts);
            $rs = $sdk -> pushMsgToAll($message, $opts);

            // 判断返回值,当发送失败时, $rs的结果为false, 可以通过getError来获得错误信息.
            if($rs === false){
               print_r($sdk->getLastErrorCode()); 
               print_r($sdk->getLastErrorMsg()); 
            }else{
                // 将打印出消息的id,发送时间等相关信息.
                print_r($rs);
            }   
    }
    
    public function send($param = array()) {
        
        
        $msg_tpl = rkcache('member_msg_tpl', true);
//        if (!isset($msg_tpl[$this->code]) || $this->member_id <= 0) {
//            return false;
//        }
        
        
        $this->pushAndroidAll($param);
        
        
        
        $tpl_info = $msg_tpl[$this->code];

        $setting_info = Model('member_msg_setting')->getMemberMsgSettingInfo(array('mmt_code' => $this->code, 'member_id' => $this->member_id), 'is_receive');
        if (empty($setting_info) || $setting_info['is_receive']) {
            // 发送站内信
            if ($tpl_info['mmt_message_switch']) {
                $message = ncReplaceText($tpl_info['mmt_message_content'],$param);
                $this->sendMessage($message);
            }
            // 发送短消息
            if ($tpl_info['mmt_short_switch']) {
                $this->getMemberInfo();
                if (!empty($this->mobile)) $this->member_info['member_mobile'] = $this->mobile;
                if ($this->member_info['member_mobile_bind'] && !empty($this->member_info['member_mobile'])) {
                    $param['site_name'] = C('site_name');
                    $message = ncReplaceText($tpl_info['mmt_short_content'],$param);
                    $this->sendShort($this->member_info['member_mobile'], $message);
                }
            }
            // 发送邮件
            if ($tpl_info['mmt_mail_switch']) {
                $this->getMemberInfo();
                if (!empty($this->email)) $this->member_info['member_email'] = $this->email;
                if ($this->member_info['member_email_bind'] && !empty($this->member_info['member_email'])) {
                    $param['site_name'] = C('site_name');
                    $param['mail_send_time'] = date('Y-m-d H:i:s');
                    $subject = ncReplaceText($tpl_info['mmt_mail_subject'],$param);
                    $message = ncReplaceText($tpl_info['mmt_mail_content'],$param);
                    $this->sendMail($this->member_info['member_email'], $subject, $message);
                }
            }
        }
    }

    /**
     * 会员详细信息
     */
    private function getMemberInfo() {
        if (empty($this->member_info)) {
            $this->member_info = Model('member')->getMemberInfoByID($this->member_id);
        }
    }

    /**
     * 发送站内信
     * @param unknown $message
     */
    private function sendMessage($message) {
        //添加短消息
        $model_message = Model('message');
        $insert_arr = array();
        $insert_arr['from_member_id'] = 0;
        $insert_arr['member_id'] = $this->member_id;
        $insert_arr['msg_content'] = $message;
        $insert_arr['message_type'] = 1;
        $model_message->saveMessage($insert_arr);
    }

    /**
     * 发送短消息
     * @param unknown $number
     * @param unknown $message
     */
    private function sendShort($number, $message) {
        $sms = new Sms();
        $sms->send($number, $message);
    }

    /**
     * 发送邮件
     * @param unknown $number
     * @param unknown $subject
     * @param unknown $message
     */
    private function sendMail($number, $subject, $message) {
    	//即时发送邮箱 v3-b11
    	$email = new Email();
        $email->send_sys_email($number,$subject,$message);
        // 计划任务代码
        /*$insert = array();
        $insert['mail'] = $number;
        $insert['subject'] = $subject;
        $insert['contnet'] = $message;
        Model('mail_cron')->addMailCron($insert);*/
    }
}
