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
  <form method="post" action="index.php?act=designer_work&op=designer_work_save"  target="_parent" name="designer_wrok_form" id="designer_wrok_form" enctype="multipart/form-data">
    <input type="hidden" name="sn_id" value="<?php echo $output['sn_info']['id'];?>"/>
     <input type="hidden" name="designer_id" value="<?php echo $_GET['designer_id'];?>"/>
    <dl>
      <dt><i class="required">*</i>作品名</dt>
      <dd>
        <input type="text" class="w150 text" name="sn_title" value="<?php echo $output['sn_info']['sn_name'];?>" /><span></span>
      </dd>
    </dl>
     <dl>
      <dt><i class="required">*</i>造价</dt>
      <dd>
        <input type="text" class="w150 text" name="cost" value="<?php echo $output['sn_info']['sn_cost'];?>" /><span></span>
      </dd>
    </dl>
     <dl>
      <dt><i class="required">*</i>面积</dt>
      <dd>
        <input type="text" class="w150 text" name="area" value="<?php echo $output['sn_info']['sn_area'];?>" /><span></span>
      </dd>
    </dl>
    <?php if($_GET['opt']=='editwork'){?>
    <dl>
      <dt>设计师</dt>
      <dd>
          <select  class="sn_designer_id valid">
              <?php $der=$_GET['designer_id']; ?>
             <?php foreach ($output['designers'] as $designer) { ?>
                
              <option <?php if($der==$designer['id']) echo "selected"; ?> value="<?php echo $designer['id']; ?>"><?php echo $designer['sn_title']; ?> </option>
                 <?php  }?> 
          </select>
          
       
      </dd>
    </dl>
    
    <?php } ?>
      <dl>
      <dt>类别</dt>
      <dd>
          <select  class="category" name="category">
              <?php $der=$_GET['sn_category']; ?>
              <?php foreach ($output['category'] as $key => $value) { ?>
                 <option  value="<?php echo $value; ?>"><?php echo $value; ?> </option>  
              <?php } ?>
          </select>
          
       
      </dd>
    </dl>
     <dl>
      <dt>风格</dt>
      <dd>
          <select  class="style valid" name="style">
              <?php $der=$_GET['sn_style']; ?>
             <?php foreach ($output['style'] as $key => $value) { ?>
                
              <option <?php if($der==$designer['id']) echo "selected"; ?> value="<?php echo $value; ?>"><?php echo $value; ?> </option>
                 <?php  }?> 
          </select>
          
       
      </dd>
    </dl>
      <dl>
      <dt>户型</dt>
      <dd>
          <select  class="house_style" name="house_type[]">
              <?php  //$der=$_GET['sn_house_type'][0];$o=1; ?>
             <?php for($o=1; $o<4; $o++) { ?>
                
              <option <?php if($o==$output['sn_info']['sn_house_type'][0]) echo "selected"; ?> value="<?php echo $o; ?>"><?php echo $o; ?>房 </option>
             <?php  }?> 
          </select>
          <select  class="house_style" name="house_type[]">
              <?php //$der=$_GET['sn_house_type'][1]; ?>
             <?php for($i=1; $i<5; $i++) { ?>
                
              <option <?php if($i==$output['sn_info']['sn_house_type'][1]) echo "selected"; ?> value="<?php echo $i; ?>"><?php echo $i; ?>厅 </option>
                 <?php  }?> 
          </select>
          <select  class="house_style" name="house_type[]">
              <?php //$der=$_GET['sn_house_type'][2]; ?>
            <?php for($q=1; $q<5; $q++) { ?>
                
              <option <?php if($q==$output['sn_info']['sn_house_type'][2]) echo "selected"; ?> value="<?php echo $q; ?>"><?php echo $q; ?>卫 </option>
                 <?php  }?> 
          </select>
          
       
      </dd>
    </dl>
        <dl>
      <dt>作品图鉴</dt>
      <dd nc_type="handle_pic" id="thumbnail">
         <ul class="ncsc-store-slider" id="goods_images">
             <?php  $output['sn_info']['sn_work_pic']=explode(',', $output['sn_info']['sn_work_pic']); ?>
      <?php for($i=0;$i<5;$i++){?>
      <li nc_type="handle_pic" id="thumbnail_<?php echo $i;?>">
         
        <div class="picture" nctype="file_<?php echo $i;?>">
          <?php if (empty($output['sn_info']['sn_work_pic'][$i])) {?>
          <i class="icon-picture"></i>
          
          <?php } else {?>
          <img nctype="file_<?php echo $i;?>" src="<?php echo UPLOAD_SITE_URL.'/'.ATTACH_WORK.DS.$output['sn_info']['sn_work_pic'][$i];?>" />
          <?php }?>
          <input type="hidden" name="image_path[]" nctype="file_<?php echo $i;?>" value="<?php echo $output['sn_info']['sn_work_pic'][$i];?>" /><a href="javascript:void(0)" nctype="del" class="del" title="移除">X</a></div>
          
        
         <div class="ncsc-upload-btn"> <a href="javascript:void(0);"><span>
          <input type="file" hidefocus="true" size="1" class="input-file" name="file_<?php echo $i;?>" id="file_<?php echo $i;?>"/>
          <p style="margin-top:35px">作为封面&nbsp;<input  type="radio" value="<?php echo $i;?>" class="main_pic" <?php if($output['sn_info']['sn_work_pic'][$i]==$output['sn_info']['sn_m_pic']){echo 'checked';};?> name="main_pic"/></p>
                 </span>
          <p><i class="icon-upload-alt"></i>上传</p>
          </a></div></li>
      <?php } ?>
    </ul>
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
      <dt>作品介绍</dt>
      <dd>
          <textarea style="width:500px;height: 300px" name="sn_content"><?php echo $output['sn_info']['sn_content'];?></textarea>
     
      </dd>
    </dl>

    
    <div class="bottom">
      <label class="submit-border"><input type="submit" class="submit" value="提交" /></label>
    </div>
  </form>
</div>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/ajaxfileupload/ajaxfileupload.js" charset="utf-8"></script> 
<script src="<?php echo SHOP_RESOURCE_SITE_URL;?>/js/work_upload.js" charset="utf-8"></script>
<script type="text/javascript">
    
var SITEURL = "<?php echo SHOP_SITE_URL;?>";
var SHOP_TEMPLATES_URL = '<?php echo SHOP_TEMPLATES_URL;?>';
var UPLOAD_SITE_URL = '<?php echo UPLOAD_SITE_URL;?>';
var ATTACH_COMMON = '<?php echo ATTACH_COMMON;?>';
var ATTACH_STORE = '<?php echo ATTACH_STORE;?>';
var SHOP_RESOURCE_SITE_URL = '<?php echo SHOP_RESOURCE_SITE_URL;?>';
$(document).ready(function(){
	//页面输入内容验证
        $('.sn_designer_id').change(function(){
           var svalue = $(this).val();
           $("input[name='designer_id']").attr('value',svalue);
        })
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
