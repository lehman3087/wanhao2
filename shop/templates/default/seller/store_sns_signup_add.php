<?php defined('InShopNC') or exit('Access Invalid!');?>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.ajaxContent.pack.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/common_select.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.iframe-transport.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.ui.widget.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fileupload/jquery.fileupload.js" charset="utf-8"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.poshytip.min.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.charCount.js"></script>
<script src="<?php echo SHOP_RESOURCE_SITE_URL;?>/js/leditor.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<style>
     .text-tip{
        font-size: 12px;
    }
    .text-div{
       font-size: 16px; 
    }
    .tools a{
       font-size: 16px;  
    }
    .ncsc-mea-text{
        font-size: 16px;  
    }
</style>
<div class="tabmenu">
  <?php include template('layout/submenu');?>
</div>
<div class="alert alert-block alert-info mt10"> <strong><?php echo $lang['store_sns_type'].$lang['nc_colon'];?></strong>
  <label class="mr20">
    <input type="radio" name="sns_type" value="normal" id="sns_normal"  class="vm mr5" />
    <?php echo $lang['store_sns_normal'];?></label>
  <label class="mr20">
    <input type="radio" name="sns_type" value="recommend" id="sns_recommend" class="vm mr5" />
    <?php echo $lang['store_sns_recommend'];?></label>
  <label class="mr20">
    <input type="radio" name="sns_type" value="hotsell" id="sns_hotsell" class="vm mr5" />
    <?php echo $lang['store_sns_hotsell'];?></label>
  <label class="mr20">
    <input type="radio" name="sns_type" value="new" id="sns_new" class="vm mr5" />
    <?php echo $lang['store_sns_new'];?></label>
    <label class="mr20">
    <input type="radio" name="sns_type" value="signup" id="sns_signup" checked="checked" class="vm mr5" />
    报名活动</label>
    
</div>


<div class="ncsc-form-default" nctype="signup" style=" display: none;">
    
    <div class="alert">
    <h4><?php echo $lang['store_sns_explain'].$lang['nc_colon'];?></h4>
    <ul>
      <li>报名活动需审核后才可发布</li>
      <li>推荐经审核通过后会在推荐位展示</li>
    </ul>
  </div>
    
  <form method="post" action="index.php?act=store_sns&op=newActivity" id="normal_form1">
    <input type="hidden" name="activity_type" value="11" />
     <input type="hidden" name="form_submit" value="ok" />
    <dl>
      <dt><i class="required">*</i>标题：</dt>
      <dd>
        <input class="w400 text" name="activity_title" type="text" id="activity_title" value="" maxlength="30"  />
        <span></span>
       
      </dd>
    </dl>
    
    
        <dl>
      <dt><i class="required">*</i>开始时间<?php echo $lang['nc_colon'];?></dt>
      <dd>
          <input id="activity_start_date" name="activity_start_date" type="text" class="text w130" /><em class="add-on"><i class="icon-calendar"></i></em><span></span>
         
      </dd>
    </dl>
    <dl>
      <dt><i class="required">*</i>结束时间<?php echo $lang['nc_colon'];?></dt>
      <dd>
          <input id="activity_end_date" name="activity_end_date" type="text" class="text w130"/><em class="add-on"><i class="icon-calendar"></i></em><span></span>


      </dd>
    </dl>
    
    <dl>
      <dt><i class="required">*</i>活动地点：</dt>
      <dd>
        <input class="w400 text" name="activity_location" type="text" id="activity_location" value="" maxlength="30"  />
        <span></span>
       
      </dd>
    </dl>
     
         <dl>
      <dt><i class="required">*</i>联系电话：</dt>
      <dd>
        <input class="w400 text" name="contact_phone" type="text" id="activity_location" value="<?php echo $output['activity']['contact_phone'];?>" maxlength="30"  />
        <span></span>
       
      </dd>
    </dl>
    
     
     
    <dl>
      <dt><?php echo $lang['store_sns_image'].$lang['nc_colon'];?></dt>
      <dd>
        <div class="ncsc-upload-thumb store-sns-pic">
          <p><img nctype="normal_img1" src="<?php echo SHOP_TEMPLATES_URL?>/images/member/default_image.png"/></p>
          <input type="hidden" name="sns_image" id="sns_image1" value="" />
        </div>
        <div class="handle">
          <div class="ncsc-upload-btn"> <a href="javascript:void(0);"><span>
            <input type="file" hidefocus="true" size="1" class="input-file" name="normal_file" id="normal_file1">
            </span>
            <p><i class="icon-upload-alt"></i>图片上传</p>
            </a> </div>
            <a class="ncsc-btn mt5" nctype="get_img" href="index.php?act=store_album&op=pic_list&item=store_sns_normal"><i class="icon-picture"></i>从图片空间选择</a> <a href="javascript:void(0);" nctype="del_img" class="ncsc-btn ml5 mt5" style="display: none;"><i class="icon-circle-arrow-up"></i>关闭相册</a></div>
        <div id="get_img_ajaxContent" class="ajax-albume"></div>
        <p class="hint"><?php printf($lang['store_sns_normal_tips'],intval(C('image_max_filesize'))/1024);?></p>
      </dd>
    </dl>
     
     <dl>
        <dt>内容描述：</dt>
        <dd id="ncProductDetails">
          <div class="tabs">
         <dl>   <ul class="ui-tabs-nav" jquery1239647486215="2">
              <li class="ui-tabs-selected"><a href="#panel-1" jquery1239647486215="8"><i class="icon-desktop"></i>电脑端</a></li>
              <li class="selected"><a href="#panel-2" jquery1239647486215="9"><i class="icon-mobile-phone"></i>手机端</a></li>
            </ul>
            <div id="panel-1" class="ui-tabs-panel" jquery1239647486215="4">
              <?php showEditor('activity_desc',$output['activity']['activity_desc'],'100%','480px','visibility:hidden;',"false",$output['editor_multimedia']);?>
              <div class="hr8">
                <div class="ncsc-upload-btn"> <a href="javascript:void(0);"><span>
                  <input type="file" hidefocus="true" size="1" class="input-file" name="add_album" id="add_activity_album" multiple="multiple">
                  </span>
                  <p><i class="icon-upload-alt" data_type="0" nctype="add_album_i"></i>图片上传</p>
                  </a> </div>
                <a class="ncsc-btn mt5" nctype="show_desc1" href="index.php?act=store_album&op=pic_list&item=des"><i class="icon-picture"></i><?php echo $lang['store_goods_album_insert_users_photo'];?></a> <a href="javascript:void(0);" nctype="del_desc1" class="ncsc-btn mt5" style="display: none;"><i class=" icon-circle-arrow-up"></i>关闭相册</a> </div>
              
              
                <p id="des_demo1"></p>
            </div>
            <div id="panel-2" class="ui-tabs-panel ui-tabs-hide" jquery1239647486215="5">
              <div class="ncsc-mobile-editor">
                <div class="pannel">
                  <div class="size-tip"><span nctype="img_count_tip">图片总数得超过<em>20</em>张</span><i>|</i><span nctype="txt_count_tip">文字不得超过<em>5000</em>字</span></div>
                  <div class="control-panel" nctype="mobile_pannel">
                    <?php if (!empty($output['activity']['activity_mb_body'])) {?>
                    <?php foreach ($output['activity']['activity_mb_body'] as $val) {?>
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
                  <textarea class="textarea valid" style="font-size:12px" nctype="meat_content"></textarea>
                  <div class="button"><a class="ncsc-btn ncsc-btn-blue" nctype="meat_submit" href="javascript:void(0);">确认</a><a class="ncsc-btn ml10" nctype="meat_cancel" href="javascript:void(0);">取消</a></div>
                  <a class="text-close" nctype="meat_cancel" href="javascript:void(0);">X</a>
                </div>
              </div>
              <input name="m_body" autocomplete="off" type="hidden" value='<?php echo $output['activity']['mobile_body'];?>'>
            </div>
          </div>
        </dd>
      </dl>
              
<!--              <dl  style="display: none">
      <dt><i class="required">*</i><?php //echo $lang['store_sns_cotent'].$lang['nc_colon'];?></dt>
      
      <dd>
          
        <textarea name="content" class="textarea w450 h100" id="content_normal" nctype="normal"></textarea>
 
          <?php //showEditor('content','123','100%','480px','visibility:hidden;',"false",$output['editor_multimedia']);?>
              <div class="hr8">
                <div class="ncsc-upload-btn"> <a href="javascript:void(0);"><span>
                  <input type="file" hidefocus="true" size="1" class="input-file" name="add_album" id="add_album2" multiple="multiple">
                  </span>
                  <p><i class="icon-upload-alt" data_type="0" nctype="add_album_i"></i>图片上传</p>
                  </a> </div>
                <a class="ncsc-btn mt5" nctype="show_desc" href="index.php?act=store_album&op=pic_list&item=des"><i class="icon-picture"></i><?php echo $lang['store_goods_album_insert_users_photo'];?></a> <a href="javascript:void(0);" nctype="del_desc" class="ncsc-btn mt5" style="display: none;"><i class=" icon-circle-arrow-up"></i>关闭相册</a> </div>
              <p id="des_demo"></p>
        <p class="w450"><a href="javascript:void(0)" nc_type="smiliesbtn" data-param='{"txtid":"normal"}' class="ncsc-btn-mini ncsc-btn-orange"><i class="icon-smile"></i><?php echo $lang['store_sns_face'];?></a> <span id="weibocharcount_normal" class="weibocharcount"></span></p>
      </dd>
    </dl>-->
     

     
     
    <div class="bottom">
      <label class="submit-border"><input type="submit" class="submit" value="<?php echo $lang['store_sns_release'];?>" /></label>
    </div>
  </form>
</div>

<!-- 时间 -->

<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui-timepicker-addon/jquery-ui-timepicker-addon.min.css"  />
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.ajaxContent.pack.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui-timepicker-addon/jquery-ui-timepicker-addon.min.js"></script>


<!-- 表情弹出层 -->
<div id="smilies_div" class="smilies-module"></div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/sns_store.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/smilies/smilies_data.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/smilies/smilies.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.caretInsert.js" charset="utf-8"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.charCount.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.ajaxContent.pack.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/ajaxfileupload/ajaxfileupload.js"></script> 
<script>
$(function(){
    
    $(".tabs").tabs();
    
    $("input[name='sns_type']").click(function(){
       // alert($(this).attr('id'));
        if($(this).attr('id')=='sns_signup'){
           window.location.href='.index.php?act=store_sns&op=index&cat=signup'; 
        }else{
            window.location.href='.index.php?act=store_sns&op=index'; 
        }
        
    })
    $('#activity_start_date').datetimepicker({
        controlType: 'select'
    });

    $('#activity_end_date').datetimepicker({
        controlType: 'select'
    });
    
    
	/* ajax添加商品  */
	$('a[nctype="get_img"]').ajaxContent({
		event:'click', //mouseover
		loaderType:"img",
		loadingMsg:SHOP_TEMPLATES_URL+"/images/transparent.gif",
		target:'#get_img_ajaxContent'
	}).click(function(){
	    $(this).hide();
	    $('a[nctype="del_img"]').show();
    });
    $('a[nctype="del_img"]').click(function(){
        $(this).hide();
        $('a[nctype="get_img"]').show();
        $('#get_img_ajaxContent').html('');
    });
	
	$('body').click(function(){ $("#smilies_div").html(''); $("#smilies_div").hide();});
	$('input[name="sns_type"]').each(function(){
		if($(this).attr('checked')){
			$('.ncsc-form-default').hide();
			$('.ncsc-form-default[nctype="'+$(this).val()+'"]').show();
		}
	});
	
	$('input[name="sns_type"]').change(function(){
		$('.ncsc-form-default').hide();
		$('.ncsc-form-default[nctype="'+$(this).val()+'"]').show();
	});

	$('textarea[name="content"]').each(function(){
		$(this).charCount({
			//allowed: 140,
			warning: 10,
			counterContainerID:	'weibocharcount_'+$(this).attr('nctype'),
			firstCounterText:	'<?php echo $lang['sns_charcount_tip1'];?>',
			endCounterText:		'<?php echo $lang['sns_charcount_tip2'];?>',
			errorCounterText:	'<?php echo $lang['sns_charcount_tip3'];?>'
		});
	});

	$('#normal_form').validate({
		errorLabelContainer: $('#warning'),
		invalidHandler: function(form, validator) {
			$('#warning').show();
		},
		submitHandler:function(form){
			ajaxpost('normal_form', '', '', 'onerror') 
		},
		rules : {
			content : {
				required : true
			}
		},
		messages : {
			content : {
				required : '<?php echo $lang['store_sns_content_not_null'];?>'
			}
		}
	});
    
	$('#recommend_form').validate({
		errorLabelContainer: $('#warning'),
		invalidHandler: function(form, validator) {
			$('#warning').show();
		},
		submitHandler:function(form){
			ajaxpost('recommend_form', '', '', 'onerror')
		},
		rules : {
			content : {
				required : true
			},
			goods_url : {
				required : true,
				url : true
			}
		},
		messages : {
			content : {
				required : '<?php echo $lang['store_sns_content_not_null'];?>'
			},
			goods_url : {
				required : '<?php echo $lang['store_sns_input_goods_url'];?>',
				url : '<?php echo $lang['store_sns_input_goods_url'];?>'
			}
		}
	});
    
	$('#hotsell_form').validate({
		errorLabelContainer: $('#warning'),
		invalidHandler: function(form, validator) {
			$('#warning').show();
		},
		submitHandler:function(form){
			// 验证是否选中商品
			if($('#hotsell_form').find('input[type="checkbox"]:checked').length == 0){
				$('#hotsell_form').find('ul').after('<label class="error" for="content" generated="true"><?php echo $lang['store_sns_choose_goods'];?></label>');
				return false;
			}else{
				$('#hotsell_form').find('ul').next('label').remove();
			}
			ajaxpost('hotsell_form', '', '', 'onerror')
		},
		rules : {
			content : {
				required : true
			}
		},
		messages : {
			content : {
				required : '<?php echo $lang['store_sns_content_not_null'];?>'
			}
		}
	});
    
	$('#new_form').validate({
		errorLabelContainer: $('#warning'),
		invalidHandler: function(form, validator) {
			$('#warning').show();
		},
                submitHandler:function(form){
    		// 验证是否选中商品
			if($('#new_form').find('input[type="checkbox"]:checked').length == 0){
				$('#new_form').find('ul').after('<label class="error" for="content" generated="true"><?php echo $lang['store_sns_choose_goods'];?></label>');
				return false;
			}else{
				$('#new_form').find('ul').next().remove('label');
			}
    		ajaxpost('new_form', '', '', 'onerror')
    	},
		rules : {
			content : {
				required : true
			}
		},
		messages : {
			content : {
				required : '<?php echo $lang['store_sns_content_not_null'];?>'
			}
		}
	});

	// 图片上传js
	$('#normal_file').unbind().live('change', function(){
		$('img[nctype="normal_img"]').attr('src',SHOP_TEMPLATES_URL+"/images/loading.gif");

		$.ajaxFileUpload
		(
			{
				url:'index.php?act=store_sns&op=image_upload',
				secureuri:false,
				fileElementId:'normal_file',
				dataType: 'json',
				data:{id:'normal_file'},
				success: function (data, status)
				{
					if(typeof(data.error) != 'undefind'){
						$('img[nctype="normal_img"]').attr('src',data.image);
						$('#sns_image').val(data.filename);
					}else{
						alert(data.error);
					}
				},
				error: function (data, status, e)
				{
					alert(e);
				}
			}
		)
		return false;

	});
        
	// 图片上传js
	$('#normal_file1').unbind().live('change', function(){
		$('img[nctype="normal_img1"]').attr('src',SHOP_TEMPLATES_URL+"/images/loading.gif");

		$.ajaxFileUpload
		(
			{
				url:'index.php?act=store_goods_add&op=image_upload&cat=p',
				secureuri:false,
				fileElementId:'normal_file1',
				dataType: 'json',
				data:{id:'normal_file',name:'normal_file'},
				success: function (data, status)
				{
					if(typeof(data.error) != 'undefind'){
						$('img[nctype="normal_img1"]').attr('src',data.thumb_name);
						$('#sns_image1').val(data.name);
					}else{
						alert(data.error);
					}
				},
				error: function (data, status, e)
				{
					alert(e);
				}
			}
		)
		return false;

	});
});
//从图片空间中插入图片
function sns_insert(data){
	$('img[nctype="normal_img"]').attr('src',data);
	$('#sns_image').val(data);
}
</script>