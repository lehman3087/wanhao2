<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['activity_index_manage'];?></h3>
      <ul class="tab-base">
        <li><a href="index.php?act=rec_position&op=rec_list" ><span>管理</span></a></li>
        <li><a href="index.php?act=rec_position&op=rec_add" ><span>新建</span></a></li>
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo '处理请求';?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" name="formSearch">
  	<input type="hidden" name="id" value="<?php echo $_GET['rec_id']; ?>">
    <input type="hidden" name="act" value="rec_position">
    <input type="hidden" name="op" value="detail">
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
             
          <th><label for="searchtitle">商户名</label></th>
          <td><input type="text" name="searchstore" id="searchstore" class="txt" value='<?php echo $_GET['searchstore'];?>'></td>
          <th><label for="searchtitle">标题</label></th>
          <td><input type="text" name="searchapplys" id="searchgoods" class="txt" value='<?php echo $_GET['searchgoods'];?>'></td>
          <td><select name="searchstate">
              <option value="0" <?php if (!$_GET['searchstate']){echo 'selected=selected';}?>>审核状态</option>
              <option value="1" <?php if ($_GET['searchstate'] == 1){echo 'selected=selected';}?>>待审核</option>
              <option value="2" <?php if ($_GET['searchstate'] == 2){echo 'selected=selected';}?>>通过</option>
              <option value="3" <?php if ($_GET['searchstate'] == 3){echo 'selected=selected';}?>>不通过</option>
            </select>
          </td>
          <td><a href="javascript:document.formSearch.submit();" class="btn-search " title="<?php echo $lang['nc_query']; ?>">&nbsp;</a></td>
        </tr>
      </tbody>
    </table>
  </form>

  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th class="nobg" colspan="12"><div class="title">
            <h5><?php echo $lang['nc_prompts'];?></h5>
            <span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td><ul>
            <li>一个展位只可对应一个申报对象</li>
            <li><?php echo $lang['activity_detail_index_tip2'];?></li>
            <li><?php echo $lang['activity_detail_index_tip3'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>

  <form method='post' action="index.php" id="listform">
    <table class="table tb-type2">
      <thead>
        <tr class="thead">
          <th></th>
          <th><?php echo $lang['nc_sort'];?></th>
          <th><label for="searchtitle">海报</label></th>
          <th>申报对象</th>
          <th>对象类型</th>
          <th>店铺</th>
          <th class="align-center">状态</th>
          <th class="align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody id="treet1">
        <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
        <?php foreach($output['list'] as $k => $v){ ?>
        <tr class="hover">
            
          <td class="w24"><input type="checkbox" name='activity_detail_id[]' value="<?php echo $v['adp_apply_id'];?>" class="checkitem"></td>
          <td class="w48 sort"><span class=" editable" title="<?php echo $lang['nc_editable'];?>" style="cursor:pointer;"  required="1" fieldid="<?php echo $v['adp_apply_id'];?>" ajax_branch='rec_detail_sort' fieldname="adp_apply_sort" nc_type="inline_edit"><?php echo $v['adp_apply_sort'];?></span></td>
          
             <td><div class="pic-thumb" >
                     
                     <img class="show_image"  src="<?php echo act_thumb($v['rec_img'], 60);?>">
                     <div class="type-file-preview"><img src="<?php echo act_thumb($v['rec_img'], 360);?>" onload="javascript:DrawImage(this,500,500);"></div>
                 </div>
             </td>
          <td><?php echo $v['item_name'];?></td>
          <td><?php echo str_replace(array('activity','store_sns_tracelog','goods','groupbuy','p_xianshi','p_mansong','p_bundling'), array('报名活动','新闻','商品','抢购','限时折扣','满送','优惠套餐'), $v['item_cate']); ?></td>
          <td><?php echo $v['store_name'];?></td>
          <td class="align-center">
          	<?php switch($v['adp_apply_state']){
					case '0':echo '审核中';break;
					case '1':echo '通过';break;
					case '2':echo '不通过';break;
					//case '3':echo $lang['activity_detail_index_apply_again'];break;
				}?>
		  </td>
          <td class="w150 align-center">
          	<?php if($v['adp_apply_state']!='1'){?>
            	<a href="index.php?act=rec_position&op=deal&ap_type=<?php echo $_GET['rp_type'];?>&adp_apply_id=<?php echo $v['adp_apply_id'];?>&state=1&adpid=<?php echo $v['adp_id'];?>"><?php echo '通过';?></a>
            <?php }?>
            <?php if($v['adp_apply_state']=='0'){?>
            	&nbsp;|&nbsp;
            <?php }?>
            <?php if($v['adp_apply_state']!='2'){?>
            	<a href="index.php?act=rec_position&op=deal&adp_apply_id=<?php echo $v['adp_apply_id'];?>&state=2"><?php echo '拒绝';?></a>
            <?php }?>
            <?php if ($v['adp_apply_state']=='0' || $v['adp_apply_state']=='2'){?>
            	&nbsp;|&nbsp;<a href="javascript:void(0)" onclick="if(confirm('<?php echo $lang['nc_ensure_del'];?>')){location.href='index.php?act=rec_position&op=del_detail&adp_apply_id=<?php echo $v['adp_apply_id'];?>';}">删除</a></td>
            <?php }?>
        </tr>
        <?php } ?>
        <?php }else { ?>
        <tr class="no_data">
          <td colspan="10"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <?php if(!empty($output['list']) && is_array($output['list'])){ ?>
      <tfoot>
        <tr class="tfoot">
          <td><input type="checkbox" class="checkall" id="checkall_1"></td>
          <td colspan="16" id="batchAction">
          	<label for="checkall_1"><?php echo $lang['nc_select_all']; ?></label>&nbsp;&nbsp;
            <a href="JavaScript:void(0);" class="btn" onclick="javascript:submit_form('pass');"><span>通过</span></a>
            <a href="JavaScript:void(0);" class="btn" onclick="javascript:submit_form('refuse');"><span>拒绝</span></a>
            <a href="JavaScript:void(0);" class="btn" onclick="javascript:submit_form('del');"><span><?php echo $lang['nc_del'];?></span></a>
            <div class="pagination"><?php echo $output['show_page'];?></div>
          </td>
        </tr>
      </tfoot>
      <?php } ?>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.edit.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.goods_class.js" charset="utf-8"></script>
<script type="text/javascript">
function submit_form(op){
	if(op=='del'){
		if(!confirm('<?php echo $lang['nc_ensure_del'];?>')){
			return false;
		}
		$('#listform').attr('action','index.php?act=rec_position&op=del_detail');
	}else if(op=='pass'){
		if(!confirm('<?php echo $lang['activity_detail_index_pass_all'];?>')){
			return false;
		}
		$('#listform').attr('action','index.php?act=rec_position&op=deal&state=1');
	}else if(op=='refuse'){
		if(!confirm('<?php echo $lang['activity_detail_index_refuse_all'];?>')){
			return false;
		}
		$('#listform').attr('action','index.php?act=rec_position&op=deal&state=2');
	}
	$('#listform').submit();
}
</script>
