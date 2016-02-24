<?php defined('InShopNC') or exit('Access Invalid!');?>
<style>
    .show-default {
            display: block;
    width: 120px;
    height: 30px;
    padding: 90px 0 0;
    border: solid 1px #F5F5F5;
    position: absolute;
    z-index: 2;
    top: 10px;
    left: 10px;
    cursor: pointer;
    }
    .upload-thumb{
            line-height: 0;
    background-color: #FFF;
    text-align: center;
    vertical-align: middle;
    display: table-cell;
    width: 120px;
    height: 120px;
    border: solid 1px #F5F5F5;
    position: absolute;
    z-index: 1;
    top: 10px;
    left: 10px;
    overflow: hidden;
    }
    a.del{
            font-family: Tahoma, Geneva, sans-serif;
    font-size: 9px;
    font-weight: lighter;
    background-color: #FFF;
    line-height: 14px;
    text-align: center;
    display: none;
    width: 14px;
    height: 14px;
    border-style: solid;
    border-width: 1px;
    border-radius: 8px;
    position: absolute;
    z-index: 3;
    top: -8px;
    right: -8px;
    }
    .show-default:hover{
        border-color: #27A9E3;
    }
    .show-default p{
        color: #28B779;
    line-height: 20px;
    filter: progid:DXImageTransform.Microsoft.gradient(enabled='true',startColorstr='#E5FFFFFF', endColorstr='#E5FFFFFF');
    background: rgba(255,255,255,0.9);
    display: none;
    height: 20px;
    padding: 5px;
    }
     .show-default:hover p {
    color: #27A9E3;
    display: block;
}
.type-file-preview {
    background: #FFF;
    display: none;
    padding: 5px;
    border: solid 5px #71CBEF;
    position: absolute;
    z-index: 999;
}
</style>
<div class="tabmenu">
  <?php include template('layout/submenu');?>
  <div class="text-intro">海报要求：宽：<?php echo $output['adv_info']['pic_width'];?>px/高：<?php echo $output['adv_info']['pic_height'];?>px｜ <?php echo '展位主题：';?> <?php echo $output['adv_info']['title'];?></div>
</div>
<form method="GET">
  <input type="hidden" name="act" value="store_promotion_booth"/>
  <input type="hidden" name="op" value="adposition_apply"/>
  <input type="hidden" value="<?php echo intval($_GET['adv_id']);?>" name="adv_id"/>
  <table class="ncsc-default-table" >
    <thead>
      <tr>
        <th class="w50">海报</th>
        <th class="w300 tl">名称</th>
        <th>类型</th>
        <th>有效时间</th>
        <th class="w120">审核状态</th>
      </tr>
    </thead>
    <tbody>
      <?php if(!empty($output['list']) and is_array($output['list'])){?>
      <?php foreach ($output['list'] as $k=>$v){ ?>
      <tr class="bd-line">
          <td>
              <div class="" >
                  <img class="show_image"  src="<?php echo act_thumb($v['rec_img'], 60);?>">
                     <div class="type-file-preview"><img src="<?php echo act_thumb($v['rec_img'], 360);?>" onload="javascript:DrawImage(this,500,500);"></div>
                     
<!--                  <img src="<?php echo rec_thumb($v['rec_img'], 60);?>">-->
              </div>
          </td>
        <td class="tl"><dl class="goods-name">
            <dt><a target="_blank" href="<?php echo urlShop('goods', 'index', array('goods_id' => $v['goods_id']));?>"><?php echo $v['goods_name'];?></a></dt>
            <dd><?php echo $v['item_name'];?></dd>
          </dl></td>
        <td><?php echo str_replace(array('activity','store_sns_tracelog','goods','groupbuy','p_xianshi','p_mansong','p_bundling'), array('报名活动','新闻','商品','抢购','限时折扣','满送','优惠套餐'), $v['item_cate']); ?></td>
        <td>
        <?php if((!empty($v['start_time']))&&(!empty($v['end_time']))){ ?>
            <?php echo date('Y-m-d',$v['start_time']);?>~<?php echo date('Y-m-d',$v['end_time']);?>
        <?php } ?>
        </td>
        <td><?php if($v['adp_apply_state']=='1'){
          			echo '已通过';
          		  }elseif(in_array($v['adp_apply_state'],array('0','3'))){
          		  	echo '审核中';
          		  }
          	?></td>
      </tr>
      <?php }?>
      <?php }else{?>
      <tr>
        <td colspan="20" class="norecord"><div class="warning-option"><i class="icon-warning-sign"></i><span><?php echo $lang['no_record'];?></span></div></td>
      </tr>
      <?php }?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="20"></td>
      </tr>
    </tfoot>
  </table>
</form>

  <div class="div-goods-select">
    <form method="GET">
      <input type="hidden" name="act" value="store_promotion_booth"/>
      <input type="hidden" name="op" value="adposition_apply"/>
      <input type="hidden" name="adp_id" value="<?php echo $_GET['adp_id'];?>"/>
      <table class="search-form">
        <tr>
          <th class="w250"><strong>选择参加推广的内容，勾选并提交平台审核</strong></th>
          <td class="w50"><select name="rec_content_type">
                  <option value="1" <?php if($_GET['rec_content_type']==1) echo 'selected'; ?> >商品</option>
                  <option value="2" <?php if($_GET['rec_content_type']==2) echo 'selected'; ?> >促销</option>
                  <option value="3" <?php if($_GET['rec_content_type']==3) echo 'selected'; ?> >新鲜事</option>
                  <option value="4" <?php if($_GET['rec_content_type']==4) echo 'selected'; ?> >报名</option>
              </select></td>
          <td class="w160"><input type="text" class="text w150" name="name" value="<?php echo $output['search']['name'];?>" placeholder="搜索内容名称"/></td>
          <td class="w70 tc"><label class="submit-border">
              <input type="submit" class="submit" value="提交"/>
            </label></td><td></td>
        </tr>
      </table>
    </form>
    <form method="POST" id="apply_form" onsubmit="ajaxpost('apply_form','','','onerror');" action="index.php?act=store_promotion_booth&op=adposition_apply_save">
      <input type="hidden" name="adp_id" value="<?php echo $_GET['adp_id'];?>"/>
      <input type="hidden" name="rec_content_type" value="<?php echo $_GET['rec_content_type'];?>"/>
      <input type="hidden" name="name" value="<?php echo $_GET['name'];?>"/>
      <?php if(!empty($output['pos']) and is_array($output['pos'])){?>
      <div class="search-result">
        <ul class="goods-list">
          <?php foreach ($output['pos'] as $po){?>
          <li>
              
              <div class="ncsc-goodspic-upload goods-thumb" style="font-size: 12px;
   width: 180px;
    height: 180px;
/*    border-left: solid 1px #E6E6E6;*/
    position: relative;
    z-index: 1;
    zoom: 1;">    
            <div class="upload-thumb"><img src="<?php echo act_thumb($po['img'], 240);?>" nctype="file_<?php echo $po['id'];?>">
              <input type="hidden" name="img[<?php echo $po['id'];?>][name]" value="<?php echo $output['img'][$po['id']]['goods_image'];?>" nctype="file_<?php echo $po['id'];?>">
            </div>
            <div class="show-default<?php if ($output['img'][$value['sp_value_id']][$i]['is_default'] == 1) {echo ' selected';}?>" nctype="file_<?php echo $value['sp_value_id'] . $i;?>">
              <p><i class="icon-ok-circle"></i>海报主图
                <input type="hidden" name="img[<?php echo $po['id'];?>][default]" value="<?php if ( $output['img'][$value['sp_value_id']][$i]['is_default'] == 1) {echo '1';}else{echo '0';}?>">
              </p><a href="javascript:void(0)" nctype="del" class="del" title="移除">X</a>
            </div >
                  <div class="show-sort" style="display:none">排序：<input name="img[<?php echo $value['sp_value_id'];?>][<?php echo $i;?>][sort]" type="text" class="text" value="<?php echo intval($output['img'][$value['sp_value_id']][$i]['goods_image_sort']);?>" size="1" maxlength="1">
            </div>
            <div class="ncsc-upload-btn"><a href="javascript:void(0);"><span><input type="file" hidefocus="true" size="1" class="input-file" name="file_<?php echo $po['id'];?>" id="file_<?php echo $po['id'];?>"></span><p><i class="icon-upload-alt"></i>上传</p>
              </a></div>
           </div>
         
          
          
<!--              <div class="goods-thumb"><a href="javascript:void(0);" target="_blank"><img src="<?php echo cthumb($po['img'], 240, $_SESSION['store_id']);?>"></a></div>-->
            <dl class="goods-info">
              <dt>
                <input type="checkbox" value="<?php echo $po['id'];?>" class="vm" name="item_id[]"/>
                <input type="hidden"  value="<?php echo $po['type'];?>" class="vm" name="item_cate[]"/>
                <input type="hidden"  value="<?php echo $po['name'];?>" class="vm" name="item_name[]"/>
                <label><?php echo $po['name'];?></label>
              </dt>
              <dd>类型：<?php echo str_replace(array('activity','store_sns_tracelog','goods','groupbuy','p_xianshi','p_mansong','p_bundling'), array('报名活动','新鲜事','商品','抢购','限时折扣','满送','优惠套餐'), $po['type']); ?></dd>
            </dl>
          </li>
          <?php }?>
          <div class="clear"></div>
        </ul>
      </div>
      <div class="pagination"><?php echo $output['show_page'];?></div>
      <?php }else{?>
      <div class="warning-option"><i class="icon-warning-sign"></i><span><?php echo $lang['no_record'];//您尚未发布任何商品?></span></div>
      <?php }?>
      <?php if(!empty($output['pos']) and is_array($output['pos'])){?>
      <div class="bottom tc p10">
          <?php if($output['adv_info']['rec_stop_time']<time()){?>
          
          活动已结束
          <?php }else{ ?>
        <input type="submit" class="submit" style="display: inline; *display: inline; zoom: 1;" value="选择完毕，参加活动"/>
          <?php } ?>
           
      </div>
      <?php }?>
    </form>
  </div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/ajaxfileupload/ajaxfileupload.js" charset="utf-8"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.ajaxContent.pack.js" type="text/javascript"></script>

<script>
    	$('.show_image').hover(
		function(){
			$(this).next().css('display','block');
		},
		function(){
			$(this).next().css('display','none');
		}
	);

    
    var SITEURL = "<?php echo SHOP_SITE_URL; ?>";
var DEFAULT_GOODS_IMAGE = "<?php echo UPLOAD_SITE_URL.DS.defaultGoodsImage(240);?>";
var SHOP_RESOURCE_SITE_URL = "<?php echo SHOP_RESOURCE_SITE_URL;?>";
var ADMIN_SITE_URL="<?php echo ADMIN_SITE_URL; ?>";

    $('input[type="file"]').unbind().bind('change', function(){
        var id = $(this).attr('id');
        ajaxFileUpload(id);
    });
    
//    $(function(){
//        $('.submit').click()
//    })
    // 图片上传ajax
function ajaxFileUpload(id, o) {
    $('img[nctype="' + id + '"]').attr('src', SHOP_TEMPLATES_URL + "/images/loading.gif");

    $.ajaxFileUpload({
        url : SITEURL + '/index.php?act=store_goods_add&op=image_upload&cat=r',
        //url: ADMIN_SITE_URL+'/index.php?act=upload&op=image_upload',
        secureuri : false,
        fileElementId : id,
        dataType : 'json',
        data : {name : id},
        success : function (data, status) {
                    if (typeof(data.error) != 'undefined') {
                        alert(data.error);
                        $('img[nctype="' + id + '"]').attr('src',DEFAULT_GOODS_IMAGE);
                    } else {
                        $('input[nctype="' + id + '"]').val(data.name);
                        $('img[nctype="' + id + '"]').attr('src', data.thumb_name);
                        selectDefaultImage($('div[nctype="' + id + '"]'));      // 选择默认主图
                    }
                    $.getScript(SHOP_RESOURCE_SITE_URL+ '/js/store_goods_add.step3.js');
                },
        error : function (data, status, e) {
                    alert(e);
                    $.getScript(SHOP_RESOURCE_SITE_URL+ '/js/store_goods_add.step3.js');
                }
    });
    return false;

}

    </script>