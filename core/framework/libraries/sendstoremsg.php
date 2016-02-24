<?php
/**
 *
 *
 *
 * @package    library* www.33hao.com 专业团队 提供售后服务
 */
class sendStoreMsg {
    private $code = '';
    private $store_id = 0;

    /**
     * 设置
     *
     * @param mixed $key
     * @param mixed $value
     */
    public function set($key,$value){
        $this->$key = $value;
    }

    public function send($param = array()) {
        $msg_tpl = rkcache('store_msg_tpl', true);
        if (!isset($msg_tpl[$this->code]) || $this->store_id <= 0) {
            return false;
        }

        $tpl_info = $msg_tpl[$this->code];

        $setting_info = Model('store_msg_setting')->getStoreMsgSettingInfo(array('smt_code' => $this->code, 'store_id' => $this->store_id));
        // 发送站内信
        if ($tpl_info['smt_message_switch'] && ($tpl_info['smt_message_forced'] || $setting_info['sms_message_switch'])) {
            $message = ncReplaceText($tpl_info['smt_message_content'],$param);
            $this->sendMessage($message);
        }
        // 发送短消息
        if ($tpl_info['smt_short_switch'] && $setting_info['sms_short_number'] != '' && ($tpl_info['smt_short_forced'] || $setting_info['sms_short_switch'])) {
            $param['site_name'] = C('site_name');
            $message = ncReplaceText($tpl_info['smt_short_content'],$param);
            $this->sendShort($setting_info['sms_short_number'], $message);
        }
        // 发送邮件
        if ($tpl_info['smt_mail_switch'] && $setting_info['sms_mail_number'] != '' && ($tpl_info['smt_mail_forced'] || $setting_info['sms_mail_switch'])) {
            $param['site_name'] = C('site_name');
            $param['mail_send_time'] = date('Y-m-d H:i:s');
            $subject = ncReplaceText($tpl_info['smt_mail_subject'],$param);
            $message = ncReplaceText($tpl_info['smt_mail_content'],$param);
            $this->sendMail($setting_info['sms_mail_number'], $subject, $message);
        }
        
        $this->push();
    }
    
    /*
     * 推送消息
     */
    private function push() {
        $this->pushAndroidAll();
    }
    
    /*
     * 推送安卓消息
     */
    private function pushAndroidAll() {
            // 创建SDK对象.
            $sdk = new PushSDK();

          //  $channelId = '3785562685113372034';

            // message content.
            $message = array (
                // 消息的标题.
                'title' => 'Hi!',
                // 消息内容 
                'description' => "hello, wanhao来了." 
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

    /**
     * 发送站内信
     * @param unknown $message
     */
    private function sendMessage($message) {
        $insert = array();
        $insert['smt_code'] = $this->code;
        $insert['store_id'] = $this->store_id;
        $insert['sm_content'] = $message;
        Model('store_msg')->addStoreMsg($insert);
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
        // 即时发动代码  v3-b11
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
