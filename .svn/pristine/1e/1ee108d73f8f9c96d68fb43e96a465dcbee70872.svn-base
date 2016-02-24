/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function(){
    
    
    //报名活动编辑器打开关闭上传图片
    $('a[nctype="show_desc"]').unbind().ajaxContent({
        event:'click', //mouseover
        loaderType:"img",
        loadingMsg:SHOP_TEMPLATES_URL+"/images/loading.gif",
        target:'#des_demo'
    }).click(function(){
        $(this).hide();
        $('a[nctype="del_desc"]').show();
    });
    
    $('a[nctype="del_desc"]').click(function(){
        $('#des_demo').html('');
        $(this).hide();
        $('a[nctype="show_desc"]').show();
    });
    
    //报名活动上传
    $('#add_album').fileupload({
        dataType: 'json',
        url: ADMIN_SITE_URL+'/index.php?act=upload&op=image_upload',
        formData: {id:'add_album'},
        add: function (e,data) {
           // alert('1');
            $('i[nctype="add_album_i"]').removeClass('icon-upload-alt').addClass('icon-spinner icon-spin icon-large').attr('data_type', parseInt($('i[nctype="add_album_i"]').attr('data_type'))+1);
            data.submit();
        },
        done: function (e,data) {
            var _counter = parseInt($('i[nctype="add_album_i"]').attr('data_type'));
            _counter -= 1;
            if (_counter == 0) {
                $('i[nctype="add_album_i"]').removeClass('icon-spinner icon-spin icon-large').addClass('icon-upload-alt');
                $('a[nctype="show_desc"]').click();
            }
            $('i[nctype="add_album_i"]').attr('data_type', _counter);
        }
    });
    
  
    
    
    
    
     /* 手机端 商品描述 */
    // 显示隐藏控制面板
    $('div[nctype="mobile_pannel"]').on('click', '.module', function(){
        mbPannelInit();
        $(this).siblings().removeClass('current').end().addClass('current');
    });
    // 上移
    $('div[nctype="mobile_pannel"]').on('click', '[nctype="mp_up"]', function(){
        var _parents = $(this).parents('.module:first');
        _rs = mDataMove(_parents.index(), 0);
        if (!_rs) {
            return false;
        }
        _parents.clone().insertBefore(_parents.prev()).end().remove();
        mbPannelInit();
    });
    // 下移
    $('div[nctype="mobile_pannel"]').on('click', '[nctype="mp_down"]', function(){
        var _parents = $(this).parents('.module:first');
        _rs = mDataMove(_parents.index(), 1);
        if (!_rs) {
            return false;
        }
        _parents.clone().insertAfter(_parents.next()).end().remove();
        mbPannelInit();
    });
    // 删除
    $('div[nctype="mobile_pannel"]').on('click', '[nctype="mp_del"]', function(){
        var _parents = $(this).parents('.module:first');
        mDataRemove(_parents.index());
        _parents.remove();
        mbPannelInit();
    });
    // 编辑
    $('div[nctype="mobile_pannel"]').on('click', '[nctype="mp_edit"]', function(){
        $('a[nctype="meat_cancel"]').click();
        var _parents = $(this).parents('.module:first');
        var _val = _parents.find('.text-div').html();
        $(this).parents('.module:first').html('')
            .append('<div class="content"></div>').find('.content')
            .append('<div class="ncsc-mea-text" nctype="mea_txt"></div>')
            .find('div[nctype="mea_txt"]')
            .append('<p id="meat_content_count" class="text-tip">')
            .append('<textarea class="textarea valid" data-old="' + _val + '" nctype="meat_content">' + _val + '</textarea>')
            .append('<div class="button"><a class="ncsc-btn ncsc-btn-blue" nctype="meat_edit_submit" href="javascript:void(0);">确认</a><a class="ncsc-btn ml10" nctype="meat_edit_cancel" href="javascript:void(0);">取消</a></div>')
            .append('<a class="text-close" nctype="meat_edit_cancel" href="javascript:void(0);">X</a>')
            .find('#meat_content_count').html('').end()
            .find('textarea[nctype="meat_content"]').unbind().charCount({
                allowed: 500,
                warning: 50,
                counterContainerID: 'meat_content_count',
                firstCounterText:   '还可以输入',
                endCounterText:     '字',
                errorCounterText:   '已经超出'
            });
    });
    // 编辑提交
    $('div[nctype="mobile_pannel"]').on('click', '[nctype="meat_edit_submit"]', function(){
        var _parents = $(this).parents('.module:first');
        var _c = toTxt(_parents.find('textarea[nctype="meat_content"]').val().replace(/[\r\n]/g,''));
        var _cl = _c.length;
        if (_cl == 0 || _cl > 500) {
            return false;
        }
        _data = new Object;
        _data.type = 'text';
        _data.value = _c;
        _rs = mDataReplace(_parents.index(), _data);
        if (!_rs) {
            return false;
        }
        _parents.html('').append('<div class="tools"><a nctype="mp_up" href="javascript:void(0);">上移</a><a nctype="mp_down" href="javascript:void(0);">下移</a><a nctype="mp_edit" href="javascript:void(0);">编辑</a><a nctype="mp_del" href="javascript:void(0);">删除</a></div>')
            .append('<div class="content"><div class="text-div">' + _c + '</div></div>')
            .append('<div class="cover"></div>');

    });
    // 编辑关闭
    $('div[nctype="mobile_pannel"]').on('click', '[nctype="meat_edit_cancel"]', function(){
        var _parents = $(this).parents('.module:first');
        var _c = _parents.find('textarea[nctype="meat_content"]').attr('data-old');
        _parents.html('').append('<div class="tools"><a nctype="mp_up" href="javascript:void(0);">上移</a><a nctype="mp_down" href="javascript:void(0);">下移</a><a nctype="mp_edit" href="javascript:void(0);">编辑</a><a nctype="mp_del" href="javascript:void(0);">删除</a></div>')
        .append('<div class="content"><div class="text-div">' + _c + '</div></div>')
        .append('<div class="cover"></div>');
    });
    // 初始化控制面板
    mbPannelInit = function(){
        $('div[nctype="mobile_pannel"]')
            .find('a[nctype^="mp_"]').show().end()
            .find('.module')
            .first().find('a[nctype="mp_up"]').hide().end().end()
            .last().find('a[nctype="mp_down"]').hide();
    }
    // 添加文字按钮，显示文字输入框
    $('a[nctype="mb_add_txt"]').click(function(){
        
        $('div[nctype="mea_txt"]').show();
        $('a[nctype="meai_cancel"]').click();
    
    $('div[nctype="mobile_editor_area"]').find('textarea[nctype="meat_content"]').unbind().charCount({
        allowed: 500,
        warning: 50,
        counterContainerID: 'meat_content_count',
        firstCounterText:   '还可以输入',
        endCounterText:     '字',
        errorCounterText:   '已经超出'
    })});
    // 关闭 文字输入框按钮
    $('a[nctype="meat_cancel"]').click(function(){
        $(this).parents('div[nctype="mea_txt"]').find('textarea[nctype="meat_content"]').val('').end().hide();
    });
    // 提交 文字输入框按钮
    $('a[nctype="meat_submit"]').click(function(){
        var _c = toTxt($('textarea[nctype="meat_content"]').val().replace(/[\r\n]/g,''));
        var _cl = _c.length;
        if (_cl == 0 || _cl > 500) {
            return false;
        }
        _data = new Object;
        _data.type = 'text';
        _data.value = _c;
        _rs = mDataInsert(_data);
        if (!_rs) {
            return false;
        }
        $('<div class="module m-text"></div>')
            .append('<div class="tools"><a nctype="mp_up" href="javascript:void(0);">上移</a><a nctype="mp_down" href="javascript:void(0);">下移</a><a nctype="mp_edit" href="javascript:void(0);">编辑</a><a nctype="mp_del" href="javascript:void(0);">删除</a></div>')
            .append('<div class="content"><div class="text-div">' + _c + '</div></div>')
            .append('<div class="cover"></div>').appendTo('div[nctype="mobile_pannel"]');
        
        $('a[nctype="meat_cancel"]').click();
    });
    // 添加图片按钮，显示图片空间文字
    $('a[nctype="mb_add_img"]').click(function(){
        $('a[nctype="meat_cancel"]').click();
       // alert('123');
        $('div[nctype="mea_img"]').show().load(ADMIN_SITE_URL+'/index.php?act=album&op=pic_list&item=mobile');
    });
    // 关闭 图片选择url: ADMIN_SITE_URL+'/index.php?act=upload&op=image_upload',
    $('div[nctype="mobile_editor_area"]').on('click', 'a[nctype="meai_cancel"]', function(){
        $('div[nctype="mea_img"]').html('');
    });
    // 插图图片
    insert_mobile_img = function(data){
        _data = new Object;
        _data.type = 'image';
        _data.value = data;
        _rs = mDataInsert(_data);
        if (!_rs) {
            return false;
        }
        $('<div class="module m-image"></div>')
            .append('<div class="tools"><a nctype="mp_up" href="javascript:void(0);">上移</a><a nctype="mp_down" href="javascript:void(0);">下移</a><a nctype="mp_rpl" href="javascript:void(0);">替换</a><a nctype="mp_del" href="javascript:void(0);">删除</a></div>')
            .append('<div class="content"><div class="image-div"><img src="' + data + '"></div></div>')
            .append('<div class="cover"></div>').appendTo('div[nctype="mobile_pannel"]');
        
    }
    // 替换图片
    $('div[nctype="mobile_pannel"]').on('click', 'a[nctype="mp_rpl"]', function(){
        $('a[nctype="meat_cancel"]').click();
       // alert('123');
        $('div[nctype="mea_img"]').show().load(SITEURL+'/index.php?act=store_album&op=pic_list&item=mobile&type=replace');
    });
    // 插图图片
    replace_mobile_img = function(data){
        var _parents = $('div.m-image.current');
        _parents.find('img').attr('src', data);
        _data = new Object;
        _data.type = 'image';
        _data.value = data;
        mDataReplace(_parents.index(), _data);
    }
    // 插入数据
    mDataInsert = function(data){
        _m_data = mDataGet();
        _m_data.push(data);
        return mDataSet(_m_data);
    }
    // 数据移动 
    // type 0上移  1下移
    mDataMove = function(index, type) {
        _m_data = mDataGet();
        _data = _m_data.splice(index, 1);
        if (type) {
            index += 1;
        } else {
            index -= 1;
        }
        _m_data.splice(index, 0, _data[0]);
        return mDataSet(_m_data);
    }
    // 数据移除
    mDataRemove = function(index){
        _m_data = mDataGet();
        _m_data.splice(index, 1);     // 删除数据
        return mDataSet(_m_data);
    }
    // 替换数据
    mDataReplace = function(index, data){
        _m_data = mDataGet();
        _m_data.splice(index, 1, data);
        return mDataSet(_m_data);
    }
    // 获取数据
    mDataGet = function(){
        _m_body = $('input[name="m_body"]').val();
        if (_m_body == '' || _m_body == 'false') {
            var _m_data = new Array;
        } else {
            eval('var _m_data = ' + _m_body);
        }
        return _m_data;
    }
    // 设置数据
    mDataSet = function(data){
        var _i_c = 0;
        var _i_c_m = 20;
        var _t_c = 0;
        var _t_c_m = 5000;
        var _sign = true;
        $.each(data, function(i, n){
            if (n.type == 'image') {
                _i_c += 1;
                if (_i_c > _i_c_m) {
                    alert('只能选择'+_i_c_m+'张图片');
                    _sign = false;
                    return false;
                }
            } else if (n.type == 'text') {
                _t_c += n.value.length;
                if (_t_c > _t_c_m) {
                    alert('只能输入'+_t_c_m+'个字符');
                    _sign = false;
                    return false;
                }
            }
        });
        if (!_sign) {
            return false;
        }
        $('span[nctype="img_count_tip"]').html('还可以选择图片<em>' + (_i_c_m - _i_c) + '</em>张');
        $('span[nctype="txt_count_tip"]').html('还可以输入<em>' + (_t_c_m - _t_c) + '</em>字');
        _data = JSON.stringify(data);
        $('input[name="m_body"]').val(_data);
        return true;
    }
    // 转码
    toTxt = function(str) {
        var RexStr = /\<|\>|\"|\'|\&|\\/g
        str = str.replace(RexStr, function(MatchStr) {
            switch (MatchStr) {
            case "<":
                return "";
                break;
            case ">":
                return "";
                break;
            case "\"":
                return "";
                break;
            case "'":
                return "";
                break;
            case "&":
                return "";
                break;
            case "\\":
                return "";
                break;
            default:
                break;
            }
        })
        return str;
    }
})

/* 插入商品图片 */
function insert_img(name, src) {
    $('input[nctype="goods_image"]').val(name);
    $('img[nctype="goods_image"]').attr('src',src);
}
var body='goods_body';
/* 插入编辑器 */
function insert_editor(file_path) {
    
    KE.appendHtml(body, '<img src="'+ file_path + '">');
}

function setArea(area1, area2) {
    $('#province_id').val(area1).change();
    $('#city_id').val(area2);
}

