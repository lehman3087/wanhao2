<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['rec_position'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=rec_position&op=rec_list"><span><?php echo $lang['nc_manage'];?></span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['nc_new'];?></span></a><em></em></li>
      </ul>
    </div>
  </div>
    <div class="fixed-empty">
        
        
    </div>
    注意：图片不可超过1M
  <form id="rec_form" enctype="multipart/form-data" method="post" action="index.php?act=rec_position&op=rec_edit_save">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" name="rec_id" value="<?php echo $output['info']['rec_id'];?>" />
    <input type="hidden" name="opic_type" value="<?php echo $output['info']['pic_type'];?>" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td colspan="2" class="required"><label><?php echo $lang['rec_ps_title'];?>:</label></td>
        </tr>
        <tr class="noborder">
            <td class="vatop rowform"><input type="text" name="rtitle" id="rtitle" class="txt" value="<?php echo $output['info']['title'];?>"></td>
          <td class="vatop tips"><?php echo $lang['rec_ps_title_tips'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label>推荐位<?php echo $lang['rec_ps_type'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><select name="rec_type" id="rec_type">
               <option value="2" <?php if ($output['info']['pic_type'] ==2) echo 'selected';?>><?php echo $lang['rec_ps_pic'];?></option>
              <option value="1" <?php if ($output['info']['pic_type'] ==1) echo 'selected';?>><?php echo $lang['rec_ps_txt'];?></option>
            </select></td>
          <td class="vatop tips"><?php echo $lang['rec_ps_type_tips'];?></td>
        </tr>
      </tbody>
      <tbody id="tr_pic_type" style="display:none">
      <tr><td colspan="2" class="required">内容类型</td></tr>
        <tr class="noborder">
          <td class="vatop rowform">
              <ul>
              <li>
                <label>
                  <input name="pic_type" <?php if($output['info']['rec_content_type']==1){echo 'checked';} ?> id="pic_type_1" type="radio" value="1" >
                  单张图片</label>
              </li>
              <li>
                <label>
                  <input type="radio" <?php if($output['info']['rec_content_type']==2){echo 'checked';} ?> name="pic_type" id="pic_type_2" value="2">
                  文章</label>
              </li>
              <li>
                <label>
                  <input type="radio" name="pic_type" <?php if($output['info']['rec_content_type']==3){echo 'checked';} ?> id="pic_type_3" value="3">
                 商户推荐
                </label>
              </li>
              <li>
                <label>
                  <input type="radio" name="pic_type" <?php if($output['info']['rec_content_type']==4){echo 'checked';} ?> id="pic_type_4" value="4">
                 平台活动
                </label>
              </li>
              
              
            </ul>
          </td>
         
        </tr>
      </tbody>
    </table>
    <table id="local_txt" class="table tb-type2" style="display:none">
      <thead class="thead">
        <tr class="space">
          <th colspan="10"><label class="validation"><?php echo $lang['rec_ps_ztxt'];?>:</label></th>
        </tr>
        <tr class="noborder">
          <th><?php echo $lang['rec_ps_ztxt'];?></th>
          <th><?php echo $lang['rec_ps_gourl'];?></th>
          <th></th>
          <th class="align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody id="RemoteBoxTxt">
        <tr>
          <td class="name w270"><input type="text" value="" name="txt[]" hidefocus="true"></td>
          <td class="name w270"><input type="text" value="<?php  if($output['info']['rec_content_type']==1){echo $output['info']['content']['body']['requesturl'];}else{ echo 'http://';} ?>" name="urltxt[]"></td>
          <td></td>
          <td class="w150 align-center"></td>
        </tr>
        <tr>
          <td colspan="4"><a id="addRemoteTxt" class="btn-add marginleft" href="javascript:void(0);"><span><?php echo $lang['rec_ps_addjx'];?></span></a></td>
        </tr>
      </tbody>
    </table>
      
      <table  class="table tb-type3" >
      <thead class="thead">
        <tr class="space">
          <th colspan="10"><label class="validation">位置:</label></th>
        </tr>
      </thead>
      <tbody id="RemoteBoxTxt">
        <tr class="noborder">
          <td class="vatop rowform">
              <ul>
              <li>
                <label>
                    <input type="radio" name="rec_position" <?php if($output['info']['rec_position']==1){echo 'checked';}?> id="rec_position_1" value="1"  >
                 其他</label>
              </li>
              <li>
                <label>
                  <input name="rec_position" <?php if($output['info']['rec_position']==2){echo 'checked';}?> id="rec_position_2" type="radio" value="2">
                 首页轮播图</label>
              </li>
              <li>
                <label>
                  <input type="radio" <?php if($output['info']['rec_position']==3){echo 'checked';}?> name="rec_position" id="rec_position_3" value="3">
                  首页信息流</label>
              </li>
              
            </ul>
          </td>
         
        </tr>
        
      </tbody>
    </table>
      
      
    <table id="local_pic" class="table tb-type2" style="display:none">
      <thead class="thead">
        <tr class="space">
          <th colspan="10"><label class="validation"><?php echo $lang['rec_ps_selfile'];?>:</label></th>
        </tr>
        <tr class="noborder">
          <th><?php echo $lang['rec_ps_selfile_local'];?></th>
          <th><?php echo $lang['rec_ps_gourl'];?></th>
          <th></th>
          <th class="align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody id="UpFileBox">
        <tr>
          <td class="vatop rowform w270"><span class="type-file-box">
            <input type="text" name="textfield" class="type-file-text" />
            <input type="button" name="button" value="" class="type-file-button" />
             <input name="default_pic_img" type="hidden" value="<?php echo $output['info']['content']['body']['imageurl']; ?>"/>
            <input class="type-file-file" type="file" title="" nc_type="change_default_goods_image" hidefocus="true" size="30" name="pic">
            </span>
          
          <span class="type-file-show">
          		<img class='show_image' src="<?php echo ADMIN_TEMPLATES_URL; ?>/images/preview.png">
                        <div class="type-file-preview" style="display: none;"><img src="<?php echo rec_thumb($output['info']['content']['body']['imageurl']); ?>" onload="javascript:DrawImage(this,500,500);" width="500" height="168"></div>
            </span>
              
          </td>
          <td class="name w270">
              <input type="text" value="<?php  if($output['info']['rec_content_type']==1){echo !empty($output['info']['content']['body']['requesturl'])?$output['info']['content']['body']['requesturl']:'http://';}else{ echo 'http://';} ?>" name="urlup"/>
          </td>
          <td></td>
          <td class="w150 align-center"></td>
        </tr>
        <tr>
          <td colspan="4"><a id="addUpFile" class="btn-add marginleft" href="javascript:void(0);"><span><?php echo $lang['rec_ps_addjx'];?></span></a></td>
        </tr>
      </tbody>
    </table>
    <table id="remote_pic" class="table tb-type2" style="display:none">
      <thead class="thead">
        <tr class="space">
          <th colspan="10"><label class="validation">请选择文章:</label></th>
        </tr>
               <tr class="noborder">
                  <th>横幅图片</th>
                  <th>文章</th>
                  <th></th>
                  <th class="align-center"></th>
                </tr>
      </thead>
      <tbody >
        <tr>
            
            <td class="vatop rowform w270"><span class="type-file-box">
            <input type="text" name="textfield" class="type-file-text" />
            <input type="button" name="button" value="" class="type-file-button" />
            <input class="type-file-file" type="file" title="" nc_type="change_default_goods_image" hidefocus="true" size="30" name="article_pic">
            <input name="default_article_img" type="hidden" value="<?php echo $output['info']['content']['body']['imageurl']; ?>"/>
                </span>
            
            <span class="type-file-show">
          		<img class='show_image' src="<?php echo ADMIN_TEMPLATES_URL; ?>/images/preview.png">
                        <div class="type-file-preview" style="display: none;"><img src="<?php echo rec_thumb($output['info']['content']['body']['imageurl']); ?>" onload="javascript:DrawImage(this,500,500);" width="500" height="168"></div>
            </span>
            
            </td>
            
            
         <td class="name ">
                 <select id="article_class" name="article_class">
                     <option>请选择分类</option>
              <?php if(!empty($output['article_class_list']) && is_array($output['article_class_list'])) {?>
              <?php foreach($output['article_class_list'] as $value) {?>
              <option value="<?php echo $value['class_id'];?>" <?php if($value['class_id'] == $output['info']['content']['body']['cat_id']) echo 'selected';?>><?php echo $value['class_name'];?></option>
              <?php } ?>
              <?php } ?>
            </select>
             <select class="article" name="article_id">
                 
             </select>
             <script>
                 function getSubArticle(id,aid){
                     var url='./index.php?act=rec_position&op=article_list_ajax';
                     $.get(url,{'id':id},function(data){
                         $('.article').empty();
                         //alert(data);
                         var jdata=eval("("+data+")");
                        // alert(jdata);
                         for(var i in jdata){
                            // alert(aid);
                             if(aid!='undefined'&&jdata[i]['article_id']==aid){
                                 $("<option selected value="+jdata[i]['article_id']+">"+jdata[i]['article_title']+"</option>").appendTo('.article');
                             }else{
                                 $("<option  value="+jdata[i]['article_id']+">"+jdata[i]['article_title']+"</option>").appendTo('.article');
 
                             }
                             
                            }
                        
                     })
                 }
                 
                 $(function(){
                     if($('#pic_type_2').attr('checked')){
                         var id=$("#article_class").val();
                          var aid=<?php echo !empty($output['info']['content']['body']['targetid'])?$output['info']['content']['body']['targetid']:'undefined'; ?>;
                            if(id!=0){
                              getSubArticle(id,aid);  
                            }
                     }
                     
                     
                     $("#article_class").change(function(){
                         //alert('123');
                     var id=$("#article_class").val();
                     
                     getSubArticle(id,'undefined');
                    })
                 })
                 
                 </script>
                 
             
<!--             <input type="text" value="http://" name="pic[]" hidefocus="true">-->
         </td>
<!--          <td class="name w270"><input type="text" value="http://" name="pic[]" hidefocus="true"></td>-->
<!--          <td class="name w270"><input type="text" value="http://" name="urlremote[]"></td>-->
          <td></td>
          <td class="w150 align-center"></td>
        </tr>
<!--        <tr>
          <td colspan="4"><a id="addRemote" class="btn-add marginleft" href="javascript:void(0);"><span><?php echo $lang['rec_ps_addjx'];?></span></a></td>
        </tr>-->
      </tbody>
    </table>
      
      <table id="p_activity" class="table tb-type4" style="display:none">
      <thead class="thead">
        <tr class="space">
          <th colspan="10"><label class="validation">请选择活动:</label></th>
        </tr>
               <tr class="noborder">
                  <th>横幅图片</th>
                  <th>活动</th>
                  <th></th>
                  <th class="align-center"></th>
                </tr>
      </thead>
      <tbody id="RemoteBox">
        <tr>
            
            <td class="vatop rowform w270"><span class="type-file-box">
            <input type="text" name="textfield" class="type-file-text" />
            <input type="button" name="button" value="" class="type-file-button" />
            <input class="type-file-file" type="file" title="" nc_type="change_default_goods_image" hidefocus="true" size="30" name="actiity_pic">
            <input name="default_img" type="hidden" value="<?php echo $output['info']['content']['body']['imageurl']; ?>"/>
                </span>
            
                <span class="type-file-show">
          		<img class='show_image' src="<?php echo ADMIN_TEMPLATES_URL; ?>/images/preview.png">
                        <div class="type-file-preview" style="display: none;"><img src="<?php echo rec_thumb($output['info']['content']['body']['imageurl']); ?>" onload="javascript:DrawImage(this,500,500);" width="500" height="168"></div>
            </span>
                
            </td>
         <td class="name ">
                 <select id="activity_type" name="activity_type">
                     <option value="0">请选择分类</option>
                     <option <?php if($output['info']['content']['body']['contenttype']=='pf_goods'){echo 'selected';} ?> value="pf_goods">商品</option>
                     <option value="pf_signup" <?php if($output['info']['content']['body']['contenttype']=='pf_signup'){echo 'selected';} ?>>报名活动</option>
            </select>
             <select class="activity" name="activity_id">
                 
             </select>
             
             <script>
                 function getSub(id,aid){
                     var url='./index.php?act=rec_position&op=activity_list_ajax';
                     $.get(url,{'id':id},function(data){
                         $('.activity').empty();
                         //alert(data);
                         var jdata=eval("("+data+")");
                        // alert(jdata);
                         for(var i in jdata){
                             //alert(jdata[i]['activity_id']);
                             if(aid!='undefined'&&jdata[i]['activity_id']==aid){
                               
                                 $("<option selected value="+jdata[i]['activity_id']+">"+jdata[i]['activity_title']+'-有效商品数：'+jdata[i]['detail_count']+"</option>").appendTo('.activity');
                             }else{
                                $("<option  value="+jdata[i]['activity_id']+">"+jdata[i]['activity_title']+'-有效商品数：'+jdata[i]['detail_count']+"</option>").appendTo('.activity'); 
                             }
                             
                              
                         }
                        
                     })
                 }
                 
                 $(function(){
                     if($('#pic_type_4').attr('checked')){
                         var id=$("#activity_type").val();
                          var aid=<?php echo !empty($output['info']['content']['body']['targetid'])?$output['info']['content']['body']['targetid']:'undefined'; ?>;
                            if(id!=0){
                              getSub(id,aid);  
                            }
                     }
                     
                     
                     $("#activity_type").change(function(){
                         //alert('123');
                     var id=$("#activity_type").val();
                     
                     getSub(id,'undefined');
                    })
                 })
                 
                 </script>
<!--             <input type="text" value="http://" name="pic[]" hidefocus="true">-->
         </td>
<!--          <td class="name w270"><input type="text" value="http://" name="pic[]" hidefocus="true"></td>-->
<!--          <td class="name w270"><input type="text" value="http://" name="urlremote[]"></td>-->
          <td></td>
          <td class="w150 align-center"></td>
        </tr>
<!--        <tr>
          <td colspan="4"><a id="addRemote" class="btn-add marginleft" href="javascript:void(0);"><span><?php echo $lang['rec_ps_addjx'];?></span></a></td>
        </tr>-->
      </tbody>
    </table>
      
      
    <table class="table tb-type2" id="rec_width">
      <tbody>
        <tr>
          <td colspan="2" class="required"><label><?php echo $lang['rec_ps_kcg'];?>:</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><?php echo $lang['rec_ps_image_width'];?>:
            <input type="text" class="txt" value="<?php echo $output['info']['pic_width'] ?>" style="width:30px" name="rwidth">
            px&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $lang['rec_ps_image_height'];?>:
            <input type="text" class="txt" value="<?php echo $output['info']['pic_height'] ?>" style="width:30px" name="rheight">
            px</td>
          <td class="vatop tips"><?php echo $lang['rec_ps_kcg_tips'];?></td>
        </tr>
        <tr>
          <td colspan="2" class="required"><label>有效时间:</label></td>
        </tr>
      </tbody>
    </table>  
      
      
     <table class="table tb-type2" >
       <tbody>
        <tr>
            <td class="vatop rowform" style="width: 700px">
              
                <label>
                    <input type="text" id="stime" name="stime" class="txt date" value="<?php echo date('Y-m-d h:m:s',$output['info']['rec_start_time']); ?>"></label>
              
              ～
                <label>
                    <input type="text" id="etime" name="etime" class="txt date" value="<?php echo date('Y-m-d h:m:s',$output['info']['rec_stop_time']); ?>">
                 </label>
              </td>
          <td class="vatop tips"></td>
        </tr>
        <tr>
           <td colspan="2" class="required"><label>是否有效:</label></td>
        </tr>
       </tbody>
     </table>
      
      <table class="table tb-type2" >
        <tbody>
            <tr>
                 <td class="vatop rowform"><ul>
              <li>
                <label>
                  <input name="rec_state" <?php if($output['info']['rec_state']==1){echo 'checked';}?>  type="radio" value="1" >
                  有效</label>
              </li>
              <li>
                <label>
                  <input type="radio" <?php if($output['info']['rec_state']==0){echo 'checked';}?> name="rec_state" value="0">
                  无效</label>
              </li>
            </ul></td>
            </tr>
            <tr>
              <td colspan="2" class="required"><label><?php echo $lang['rec_ps_target'];?>:</label></td>   
            </tr>
        </tbody>
      </table>
      
      
       <table class="table tb-type2" >
        <tbody>
            <tr>
                 <td class="vatop rowform"><ul>
              <li>
                <label>
                    <input name="rec_app" <?php if($output['info']['rec_app']==1){echo 'checked';}?> type="checkbox" value="1" >
                  APP端</label>
              </li>
              
            </ul></td>
            </tr>
            
        </tbody>
      </table>
      
      
      
      
      
      
    <table class="table tb-type2" >
      <tbody>
        <tr>
          <td class="vatop rowform"><ul>
              <li>
                <label>
                  <input name="rtarget"  type="radio" value="1" checked="checked">
                  <?php echo $lang['rec_ps_tg1'];?></label>
              </li>
              <li>
                <label>
                  <input type="radio" name="rtarget" value="2">
                  <?php echo $lang['rec_ps_tg2'];?></label>
              </li>
            </ul></td>
          <td class="vatop tips"></td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="15" ><a href="JavaScript:void(0);" class="btn" id="submitBtn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        </tr>
      </tfoot>
    </table>
      

      
      
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />


<script type="text/javascript">
//按钮先执行验证再提交表单

$(function(){
        
	function _check(){
           // alert($('#rec_type').val());
		if ($('#rec_type').val() == 1){
			flag = false;
			$('input[name="txt[]"]').each(function(){
				if ($(this).val() != '') flag = true;
			});
			if (flag == false){
                           // alert('1');
				alert('<?php echo $lang['rec_ps_error_ztxt'];?>');return false;
			}else{
				flag = false;
			}
		}else{
			if ($('#pic_type_1').attr('checked')){
                            $('#p_activity').hide();
                               $('#remote_pic').hide(); 
                               $('#local_pic').show(); 
//				flag = false;
//				$('#UpFileBox').find('input[name="pic[]"]').each(function(){
//					if ($(this).val() != '') flag = true;
//				});
//				if (flag == false){
//					alert('111111111<?php echo $lang['rec_ps_error_pics'];?>');return false;
//				}else{
//					flag = false;
//				}
			}else{
                        
                            if($('#pic_type_2').attr('checked')){
                               $('#p_activity').hide();
                               $('#remote_pic').show(); 
                               $('#local_pic').hide(); 
//				flag = false;
//				$('#RemoteBox').find('input[name="pic[]"]').each(function(){
//					if ($(this).val() != '' && $(this).val() != 'http://') flag = true;
//				});
//				if (flag == false){
//					alert('<?php echo $lang['rec_ps_error_picy'];?>');return false;
//				}else{
//					flag = false;
//				}
                            }else if($('#pic_type_3').attr('checked')){
                               
                               $('#remote_pic').hide(); 
                               $('#local_pic').hide(); 
                               $('#p_activity').hide();
                            } else if($('#pic_type_4').attr('checked')){
                                $('#p_activity').show();
                               $('#remote_pic').hide(); 
                               $('#local_pic').hide(); 
                            }
                        }
		}
		return true;
	}
    _check();
	$("#submitBtn").click(function(){
		if(_check()){
			$("#rec_form").submit();
		}
	});
	$("#addUpFile").live('click',function(){
		if ($('#UpFileBox').find('input[name="pic[]"]').size() >= 5){
			alert('<?php echo $lang['rec_ps_error_jz'];?>');return;
		}
		$(this).parent().parent().remove();
   		$('#UpFileBox').append("<tr><td class=\"vatop rowform w270\"><span class=\"type-file-box\"><input type=\"text\" name=\"textfield\" class=\"type-file-text\" /><input type=\"button\" name=\"button\" value=\"\" class=\"type-file-button\" /><input class=\"type-file-file\" type=\"file\" title=\"\" nc_type=\"change_default_goods_image\" hidefocus=\"true\" size=\"30\" name=\"pic[]\"></span></td><td class=\"name w270\"><input type=\"text\" value=\"http://\" name=\"urlup[]\"></td><td></td><td class=\"w150 align-center\"><a id=\"delUpFile\" href=\"javascript:void(0);\"><?php echo $lang['nc_del'];?></a></td></tr><tr><td colspan=\"4\"><a id=\"addUpFile\" class=\"btn-add marginleft\" href=\"javascript:void(0);\"><span><?php echo $lang['rec_ps_addjx'];?></span></a></td></tr>");
	});
	$("#addRemote").live('click',function(){
		if ($('#RemoteBox').find('input[name="pic[]"]').size() >= 5){
			alert('<?php echo $lang['rec_ps_error_jz'];?>');return;
		}
		$(this).parent().parent().remove();
   		$('#RemoteBox').append("<tr><td class=\"name w270\"><input type=\"text\" value=\"http://\" name=\"pic[]\" hidefocus=\"true\"></td><td class=\"name w270\"><input type=\"text\" value=\"http://\" name=\"urlremote[]\"></td><td></td><td class=\"w150 align-center\"><a id=\"delUpFile\" href=\"javascript:void(0);\"><?php echo $lang['nc_del'];?></a></td></tr><tr><td colspan=\"4\"><a id=\"addRemote\" class=\"btn-add marginleft\" href=\"javascript:void(0);\"><span><?php echo $lang['rec_ps_addjx'];?></span></a></td></tr>");
	});
	$("#addRemoteTxt").live('click',function(){
		if ($('#RemoteBoxTxt').find('input[name="txt[]"]').size() >= 5){
			alert('<?php echo $lang['rec_ps_error_jz'];?>');return;
		}
		$(this).parent().parent().remove();
   		$('#RemoteBoxTxt').append("<tr><td class=\"name w270\"><input type=\"text\" value=\"\" name=\"txt[]\" hidefocus=\"true\"></td><td class=\"name w270\"><input type=\"text\" value=\"http://\" name=\"urltxt[]\"></td><td></td><td class=\"w150 align-center\"><a id=\"delUpFile\" href=\"javascript:void(0);\"><?php echo $lang['nc_del'];?></a></td></tr><tr><td colspan=\"4\"><a id=\"addRemoteTxt\" class=\"btn-add marginleft\" href=\"javascript:void(0);\"><span><?php echo $lang['rec_ps_addjx'];?><span></a></td></tr>");
	});	
	$('#delUpFile').live('click',function(){
		$(this).parent().parent().remove();$(this).remove();
	});
	$('input[name="pic_type"]').live('click',function(){
		if($(this).val() == 1) {
			$('#local_pic').show();$('#remote_pic').hide();
		}else if($(this).val() == 2){
                    $('#p_activity').hide();
			$('#local_pic').hide();$('#remote_pic').show();
		}else if($(this).val() == 4){
                    $('#remote_pic').hide();
                    $('#local_pic').hide();
                    $('#p_activity').show();
                }else{
                   $('#remote_pic').hide();
                    $('#local_pic').hide();
                    $('#p_activity').hide();
                }
	});
	$('#rec_type').change(function(){
		if ($(this).val() == 1){
			$('#local_txt').show();$('#tr_pic_type').hide();$('#local_pic').hide();$('#remote_pic').hide();$('#rec_width').hide();
		}else{
			$('#local_txt').hide();$('#tr_pic_type').show();$('#local_pic').show();$('#pic_type_1').attr('checked',true);$('#rec_width').show();
		}
	});
	//$('#local_pic').show();
	$('#tr_pic_type').show();
});
</script>
<script type="text/javascript">
$(function(){
	$('input[nc_type="change_default_goods_image"]').live("change", function(){
		$(this).parent().find('input[class="type-file-text"]').val($(this).val());
	});
});
</script> 
<script language="javascript">
$(function(){
    
	$('#stime').datepicker({dateFormat: 'yy-mm-dd'});
	$('#etime').datepicker({dateFormat: 'yy-mm-dd'});
});
</script>