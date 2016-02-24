<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

defined('InShopNC') or exit('Access Invalid!');

/**
 * 停车二维码
 * @param array $party_info
 * @return string
 */
function partyQRCode($party_info) {
    
    if (!file_exists(BASE_UPLOAD_PATH. '/' . ATTACH_STORE . '/party/' . $party_info['party_id'] . '.png' )) {
        return UPLOAD_SITE_URL.DS.ATTACH_STORE.DS.'default_qrcode.png';
    }
    return UPLOAD_SITE_URL.DS.ATTACH_STORE.DS.'party'.DS.$party_info['party_id'].'.png';
}