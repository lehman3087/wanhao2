<?php defined('InShopNC') or exit('Access Invalid!');?>
<style>
    #thumbnail{
        vertical-align: top;
letter-spacing: normal;
word-spacing: normal;
display: inline-block;
width: 162px;
padding: 14px;
margin-left: -1px;
border-left: solid 1px #E6E6E6;
position: relative;
z-index: 1;
    }
    .picture{
        line-height: 0;
background-color: #FFF;
text-align: center;
vertical-align: middle;
display: table-cell;
width: 160px;
height: 100px;
margin: 0 auto;
border: solid 1px #F5F5F5;
overflow: hidden;
    }
    .picture a del{
        font-family: Tahoma;
font-size: 10px;
line-height: 14px;
color: #CCC;
background-color: #FFF;
vertical-align: middle;
text-align: center;
display: none;
width: 14px;
height: 14px;
border: solid 1px;
border-radius: 8px;
position: absolute;
z-index: 2;
top: 8px;
right: 8px;
    }
    .url label{
        font-size: 12px;
line-height: 24px;
color: #777;
height: 24px;
    }
    .ncsc-upload-btn{
        display: block;
width: 80px;
height: 30px;
clear: both;
margin: 10px 0;
    }
    
    .ncsc-upload-btn a{
        display: block;
position: relative;
z-index: 1;
    }
    
</style>
    
<div class="tabmenu">
  <?php include template('layout/submenu');?>
</div>
<div class="ncsc-form-default">
  <form method="post" action="index.php?act=designer&op=designer_save"  target="_parent" name="designer_form" id="designer_form" enctype="multipart/form-data">
    <input type="hidden" name="sn_id" value="<?php echo $output['sn_info']['id'];?>"/>
    <dl>
      <dt><i class="required">*</i>设计师姓名</dt>
      <dd>
        <input type="text" class="w150 text" name="sn_title" value="<?php echo $output['sn_info']['sn_title'];?>" /><span></span>
      </dd>
    </dl>
    
     <dl>
      <dt>擅长风格</dt>
      <input name="sn_designer_style" id="ds" type="hidden" value=""/>
      <dd>
          <select name="" id="sn_designer_style" multiple="multiple"  class="valid">
           
            <?php foreach ($output['style'] as $key => $value) { ?>
              <option <?php if(strpos($output['sn_info']['sn_designer_style'], $value)){ echo 'selected';} ?> value="<?php echo $value; ?>"><?php echo $value; ?></option>
            <?php } ?>
          </select>
          
       
      </dd>
     </dl>
    
    <dl>
      <dt><i class="required">*</i>入行时间<?php echo $lang['nc_colon'];?></dt>
      <dd>
          <input id="start_time" name="sn_designer_enter_time" type="text" class="text w130"  value="<?php echo $output['sn_info']['sn_designer_enter_time']; ?>"/><em class="add-on"><i class="icon-calendar"></i></em><span></span>
          <p class="hint"></p>
      </dd>
    </dl>
        <dl>
      <dt>头像</dt>
      <dd nc_type="handle_pic" id="thumbnail">
         <div class="picture" nctype="file_<?php echo $i;?>">
          <?php if (empty($output['sn_info']['sn_head'])) {?>
          <i class="icon-picture"></i>
          <?php } else {?>
          <img nctype="file" src="<?php echo UPLOAD_SITE_URL.DS.ATTACH_STORE_BARE.DS.$_SESSION['store_id'].DS.ATTACH_DESIGNER_HEADER.DS.$output['sn_info']['sn_head'];?>" />
          <?php }?>
          <input type="hidden" name="image_path[]" nctype="file_<?php echo $i;?>" value="<?php echo $output['sn_info']['sn_head'];?>" /><a href="javascript:void(0)" nctype="del" class="del" title="移除">X</a></div>
        
        
         <div class="ncsc-upload-btn"> <a href="javascript:void(0);"><span>
          <input type="file" hidefocus="true" size="1" class="input-file" name="file_<?php echo $i;?>" id="file_<?php echo $i;?>"/>
          </span>
          <p><i class="icon-upload-alt"></i>上传</p>
          </a></div>
      </dd>
    </dl>
    <dl>
      <dt>是否显示</dt>
      <dd>
        <ul class="ncsc-form-radio-list">
          <li>
            <label for="sn_if_show_0"><input type="radio" class="radio" name="sn_if_show" id="sn_if_show_0" value="1"<?php if($output['sn_info']['sn_if_show'] == '1' || $output['sn_info']['sn_if_show'] == ''){?> checked="checked"<?php }?>/>
            <?php echo $lang['store_payment_yes'];?></label></li>
          <li>
            <label for="sn_if_show_1"><input type="radio" class="radio" name="sn_if_show" id="sn_if_show_1" value="0"<?php if($output['sn_info']['sn_if_show'] == '0'){?> checked="checked"<?php }?>/>
            <?php echo $lang['store_payment_no'];?></label></li>
        </ul>
      </dd>
    </dl>
    <dl>
      <dt>排序</dt>
      <dd>
        <input type="text" class="w50 text" name="sn_sort" value="<?php if($output['sn_info']['sn_sort'] != ''){ echo $output['sn_info']['sn_sort'];}else{echo '255';}?>"/>
      </dd>
    </dl>
    <dl>
      <dt>设计师介绍</dt>
      <dd>
          <textarea name="sn_content" cols="10" style="width:500px;height: 300px"><?php echo $output['sn_info']['sn_content'];?></textarea>

      </dd>
    </dl>

    
    <div class="bottom">
      <label class="submit-border"><input type="submit" class="submit" value="提交" /></label>
    </div>
  </form>
</div>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/select-multiple.css"  />
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui-timepicker-addon/jquery-ui-timepicker-addon.min.css"  />
<script src="<?php echo RESOURCE_SITE_URL;?>/js/ajaxfileupload/ajaxfileupload.js" charset="utf-8"></script> 
<script src="<?php echo SHOP_RESOURCE_SITE_URL;?>/js/sn_upload.js" charset="utf-8"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui-timepicker-addon/jquery-ui-timepicker-addon.min.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.select-multiple.js"></script>
<script type="text/javascript">
    
var SITEURL = "<?php echo SHOP_SITE_URL;?>";
var SHOP_TEMPLATES_URL = '<?php echo SHOP_TEMPLATES_URL;?>';
var UPLOAD_SITE_URL = '<?php echo UPLOAD_SITE_URL;?>';
var ATTACH_COMMON = '<?php echo ATTACH_COMMON;?>';
var ATTACH_STORE = '<?php echo ATTACH_STORE;?>';
var SHOP_RESOURCE_SITE_URL = '<?php echo SHOP_RESOURCE_SITE_URL;?>';
$(document).ready(function(){
    
    $.post('http://localhost/33hao/mobile/index.php?act=store&op=storeBasiclist',{'conditions':[{'matchType':0,'matchKey':'store_name','matchValue':'f'}],'sortType':0},function(data){
//      for(var i in data){
//          alert(data[i]);
//      }
    })
    function vcache(){
          var ss='';
          var sv=[];
        $('.ms-selected').each(function(){
            //ss+=$('span',this).eq(0).text();
            sv.push($('span',this).eq(0).text());
            
        })
        //$('#sn_designer_style').val(ss);
        //alert($('#sn_designer_style').val());
        for(i in sv){
            ss+=('|'+sv[i]);
           
        }
         $('#ds').val(ss);
       // alert($('#ds').val());
    }
    
    $('#start_time').datetimepicker({
        controlType: 'select'
    });
    
    $('#sn_designer_style').selectMultiple({
  afterSelect: function(){
    vcache();
  },
  afterDeselect: function(){
    vcache();
  }
});


    
	//页面输入内容验证
	$('#store_navigation_form').validate({
	        errorPlacement: function(error, element){
	            var error_td = element.parent('dd').children('span');
	            error_td.append(error);
	        },
	     	submitHandler:function(form){
	    		ajaxpost('add_form', '', '', 'onerror')
	    	},
        rules: {
            sn_title: {
                required: true,
                maxlength: 10
            }
        },
        messages: {
            sn_title: {
                required: '<i class="icon-exclamation-sign"></i><?php echo $lang['store_navigation_name_null'];?>',
                maxlength: '<i class="icon-exclamation-sign"></i><?php echo $lang['store_navigation_name_max'];?>'
            }
        }
    });
});
</script> 
