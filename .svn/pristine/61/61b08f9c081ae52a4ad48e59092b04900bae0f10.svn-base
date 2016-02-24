<?php defined('InShopNC') or exit('Access Invalid!');?>

<link href="<?php echo ADMIN_TEMPLATES_URL;?>/css/mobileeditor.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />


<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['activity_index_manage'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=activity&op=activity"><span><?php echo $lang['nc_manage'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_new'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="add_form" method="post" enctype="multipart/form-data">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2"><label class="validation" for="activity_title"><?php echo $lang['activity_index_title'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" id="activity_title" name="activity_title" class="txt"></td>
          <td class="vatop tips"><?php //echo $lang['activity_new_title_tip'];?></td>
        </tr>
        <tr style="">
          <td colspan="2" class="required"><label class="validation" ><?php echo $lang['activity_index_type'];?>:</label></td>
        </tr>
        <tr class="noborder" >
          <td class="vatop rowform"><select name="activity_type">
              <option value="1"><?php echo $lang['activity_index_goods'];?></option>
              <option value="10">报名活动</option>
              </optgroup>
            </select></td>
          <td class="vatop tips"><?php echo $lang['activity_new_type_tip'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation" ><?php echo $lang['activity_index_start'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" id="activity_start_date" name="activity_start_date" class="txt date"/></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation" ><?php echo $lang['activity_index_end'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" id="activity_end_date" name="activity_end_date" class="txt date"/></td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label class="validation" ><?php echo $lang['activity_index_banner'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class=" type-file-box">
              <input type="file" class="type-file-file" id="activity_banner" name="activity_banner" size="30" hidefocus="true"  nc_type="upload_activity_banner" title="<?php echo $lang['activity_index_banner'];?>">
          </td>
          <td class="vatop tips"><?php echo $lang['activity_new_banner_tip'];?></td>
        </tr>
        <tr style="display:none;">
          <td colspan="2" class="required"><label><?php echo $lang['activity_new_style'];?>:</label></td>
        </tr>
        <tr class="noborder" style="display:none;">
          <td class="vatop rowform"><select id="activity_style" name="activity_style">
              <option value="default_style"><?php echo $lang['activity_index_default'];?></option>
            </select></td>
          <td class="vatop tips"><?php echo $lang['activity_new_style_tip'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="activity_desc"><?php echo $lang['activity_new_desc'];?>:</label></td>
        </tr>
        
        
        <tr>
       
            <td id="ncProductDetails" style="width:80%">
          <div class="tabs">
            <ul class="ui-tabs-nav" jquery1239647486215="2">
              <li class="ui-tabs-selected"><a href="#panel-1" jquery1239647486215="8"><i class="icon-desktop"></i> 电脑端</a></li>
              <li class="selected"><a href="#panel-2" jquery1239647486215="9"><i class="icon-mobile-phone"></i>手机端</a></li>
            </ul>
            <div id="panel-1" class="ui-tabs-panel" jquery1239647486215="4">
              <?php showEditor('activity_desc',$output['goods']['goods_body'],'100%','480px','visibility:hidden;',"false",$output['editor_multimedia']);?>
              <div class="hr8">
                <div class="ncsc-upload-btn"> <a href="javascript:void(0);"><span>
                  <input type="file" hidefocus="true" size="1" class="input-file" name="add_album" id="add_album" multiple="multiple">
                  </span>
                  <p><i class="icon-upload-alt" data_type="0" nctype="add_album_i"></i>图片上传</p>
                  </a> </div>
                <a class="ncsc-btn mt5" nctype="show_desc" href="<?php echo ADMIN_SITE_URL; ?>/index.php?act=album&op=pic_list&item=des"><i class="icon-picture"></i><?php echo $lang['store_goods_album_insert_users_photo'];?></a> <a href="javascript:void(0);" nctype="del_desc" class="ncsc-btn mt5" style="display: none;"><i class=" icon-circle-arrow-up"></i>关闭相册</a> </div>
                <p id="des_demo"></p>
            </div>
            <div id="panel-2" class="ui-tabs-panel ui-tabs-hide" jquery1239647486215="5">
              <div class="ncsc-mobile-editor">
                <div class="pannel">
                  <div class="size-tip"><span nctype="img_count_tip">图片总数得超过<em>20</em>张</span><i>|</i><span nctype="txt_count_tip">文字不得超过<em>5000</em>字</span></div>
                  <div class="control-panel" nctype="mobile_pannel">
                    <?php if (!empty($output['goods']['mb_body'])) {?>
                    <?php foreach ($output['goods']['mb_body'] as $val) {?>
                    <?php if ($val['type'] == 'text') {?>
                    <div class="module m-text">
                      <div class="tools"><a nctype="mp_up" href="javascript:void(0);">上移</a><a nctype="mp_down" href="javascript:void(0);">下移</a><a nctype="mp_edit" href="javascript:void(0);">编辑</a><a nctype="mp_del" href="javascript:void(0);">删除</a></div>
                      <div class="content">
                        <div class="text-div"><?php echo $val['value'];?></div>
                      </div>
                      <div class="cover"></div>
                    </div>
                    <?php }?>
                    <?php if ($val['type'] == 'image') {?>
                    <div class="module m-image">
                      <div class="tools"><a nctype="mp_up" href="javascript:void(0);">上移</a><a nctype="mp_down" href="javascript:void(0);">下移</a><a nctype="mp_rpl" href="javascript:void(0);">替换</a><a nctype="mp_del" href="javascript:void(0);">删除</a></div>
                      <div class="content">
                        <div class="image-div"><img src="<?php echo $val['value'];?>"></div>
                      </div>
                      <div class="cover"></div>
                    </div>
                    <?php }?>
                    <?php }?>
                    <?php }?>
                  </div>
                  <div class="add-btn">
                    <ul class="btn-wrap">
                      <li><a href="javascript:void(0);" nctype="mb_add_img"><i class="icon-picture"></i>
                        <p>图片</p>
                        </a></li>
                      <li><a href="javascript:void(0);" nctype="mb_add_txt"><i class="icon-font"></i>
                        <p>文字</p>
                        </a></li>
                    </ul>
                  </div>
                </div>
                <div class="explain">
                  <dl>
                    <dt>1、基本要求：</dt>
                    <dd>（1）手机详情总体大小：图片+文字，图片不超过20张，文字不超过5000字；</dd>
                    <dd>建议：所有图片都是本宝贝相关的图片。</dd>
                  </dl><dl>
                    <dt>2、图片大小要求：</dt>
                    <dd>（1）建议使用宽度480 ~ 620像素、高度小于等于960像素的图片；</dd>
                    <dd>（2）格式为：JPG\JEPG\GIF\PNG；</dd>
                    <dd>举例：可以上传一张宽度为480，高度为960像素，格式为JPG的图片。</dd>
                  </dl><dl>
                    <dt>3、文字要求：</dt>
                    <dd>（1）每次插入文字不能超过500个字，标点、特殊字符按照一个字计算；</dd>
                    <dd>建议：不要添加太多的文字，这样看起来更清晰。</dd>
                  </dl>
                </div>
              </div>
              <div class="ncsc-mobile-edit-area" nctype="mobile_editor_area">
                <div nctype="mea_img" class="ncsc-mea-img" style="display: none;"></div>
                <div class="ncsc-mea-text" nctype="mea_txt" style="display: none;">
                  <p id="meat_content_count" class="text-tip"></p>
                  <textarea class="textarea valid" nctype="meat_content"></textarea>
                  <div class="button"><a class="ncsc-btn ncsc-btn-blue" nctype="meat_submit" href="javascript:void(0);">确认</a><a class="ncsc-btn ml10" nctype="meat_cancel" href="javascript:void(0);">取消</a></div>
                  <a class="text-close" nctype="meat_cancel" href="javascript:void(0);">X</a>
                </div>
              </div>
              <input name="m_body" autocomplete="off" type="hidden" value='<?php echo $output['goods']['mobile_body'];?>'>
            </div>
          </div>
        </td>
      </tr>
      
      
        
        <tr>
          <td colspan="2" class="required"><label class="validation"  for="activity_sort"><?php echo $lang['nc_sort'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" id="activity_sort" name="activity_sort" class="txt" value="0"></td>
          <td class="vatop tips"><?php echo $lang['activity_new_sort_tip1'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label for="activity_sort"><?php echo $lang['activity_openstate'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform onoff">
          	<label for="activity_state1" class="cb-enable selected" ><span><?php echo $lang['activity_openstate_open'];?></span></label>
            <label for="activity_state0" class="cb-disable"><span><?php echo $lang['activity_openstate_close'];?></span></label>
            <input id="activity_state1" name="activity_state" checked="checked" value="1" type="radio">
            <input id="activity_state0" name="activity_state" value="0" type="radio"></td>
          <td class="vatop tips"></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="2"><a href="JavaScript:void(0);" class="btn" id="submitBtn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>

<script src="<?php echo RESOURCE_SITE_URL."/js/jquery-ui/jquery.ui.js";?>"></script> 
<script src="<?php echo RESOURCE_SITE_URL."/js/jquery-ui/i18n/zh-CN.js";?>" charset="utf-8"></script> 
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.ajaxContent.pack.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/common_select.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.iframe-transport.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.ui.widget.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.fileupload.js" charset="utf-8"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.poshytip.min.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.charCount.js"></script>
<!--[if lt IE 8]>
  <script src="<?php echo RESOURCE_SITE_URL;?>/js/json2.js"></script>
<![endif]-->

<script src="<?php echo RESOURCE_SITE_URL;?>/js/leditor.js"></script>
<script>
var SITEURL = "<?php echo SHOP_SITE_URL; ?>";
var DEFAULT_GOODS_IMAGE = "<?php echo thumb(array(), 60);?>";
var SHOP_RESOURCE_SITE_URL = "<?php echo SHOP_RESOURCE_SITE_URL;?>";
var SHOP_TEMPLATES_URL = '<?php echo SHOP_TEMPLATES_URL;?>';
var ADMIN_SITE_URL='<?php echo ADMIN_SITE_URL; ?>'
//按钮先执行验证再提交表单
$(function(){
    $(".tabs").tabs();
})
$(function(){$("#submitBtn").click(function(){
    if($("#add_form").valid()){
     $("#add_form").submit();
	}
	});
});
$(document).ready(function(){
	$("#activity_start_date").datepicker({dateFormat: 'yy-mm-dd'});
	$("#activity_end_date").datepicker({dateFormat: 'yy-mm-dd'});
	$("#add_form").validate({
		errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },
        rules : {
        	activity_title: {
        		required : true
        	},
        	activity_start_date: {
        		required : true,
				date      : false
        	},
        	activity_end_date: {
        		required : true,
				date      : false
        	},
        	activity_banner: {
        		required: true,
				accept : 'png|jpe?g|gif'	
			},
        	activity_sort: {
        		required : true,
        		min:0,
        		max:255
        	}
        },
        messages : {
        	activity_title: {
        		required : '<?php echo $lang['activity_new_title_null'];?>'
        	},
        	activity_start_date: {
        		required : '<?php echo $lang['activity_new_startdate_null'];?>'
        	},
        	activity_end_date: {
        		required : '<?php echo $lang['activity_new_enddate_null'];?>'
        	},
			activity_banner: {
        		required : '<?php echo $lang['activity_new_banner_null'];?>',
				accept   : '<?php echo $lang['activity_new_ing_wrong'];?>'	
			},
        	activity_sort: {
        		required : '<?php echo $lang['activity_new_sort_null'];?>',
        		min:'<?php echo $lang['activity_new_sort_minerror'];?>',
        		max:'<?php echo $lang['activity_new_sort_maxerror'];?>'
        	}
        }
	});
});

$(function(){
// 模拟活动页面横幅Banner上传input type='file'样式
	var textButton="<input type='text' name='textfield' id='textfield1' class='type-file-text' /><input type='button' name='button' id='button1' value='' class='type-file-button' />"
    $(textButton).insertBefore("#activity_banner");
    $("#activity_banner").change(function(){
	$("#textfield1").val($("#activity_banner").val());
    });
});
</script> 
