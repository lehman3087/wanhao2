<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="tabmenu">
  <?php include template('layout/submenu');?>
</div>
<table class="ncsc-default-table">
  <?php if(!empty($output['ad_positions']) && is_array($output['ad_positions'])){?>
  <thead>
    <tr>
      <th class="w20">&nbsp;</th>
      <th class="tl w200">名称</th>
      <th class="tl">类型</th>
      <th class="w150"><?php echo $lang['store_activity_start_time'];?></th>
      <th class="w150"><?php echo $lang['store_activity_end_time'];?></th>
      <th class="w90"><?php echo $lang['nc_handle'];?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($output['ad_positions'] as $k => $v){?>
    <tr>
      <td></td>
      <td class="tl"><a target="_blank" href="index.php?act=activity&activity_id=<?php echo $v['rec_id'];?>"><?php echo $v['title']; ?></a><?php if($v['rec_stop_time']<time()){ echo "----<span style='color:red'>活动已结束"; }?></td>
      <td class="tl"><?php if($v['pic_type']==0){ echo '文字';}else{ echo '图片 高度:'.$v['pic_height'].'宽度:'.$v['pic_width'];}?></td>
      <td class="goods-time"></td>
      <td class="goods-time"></td>
      <td class="nscs-table-handle"><span><a id="a_<?php echo $v['rec_id'];?>" href="index.php?act=store_promotion_booth&op=adposition_apply&adp_id=<?php echo $v['rec_id'];?>"  class="btn-green"><i class="icon-edit"></i>
        <p>参加</p>
        </a></span></td>
    </tr>
    <?php } } else { ?>
    <tr>
      <td colspan="20" class="norecord"><div class="warning-option"><i class="icon-warning-sign"></i><span><?php echo $lang['no_record'];?></span></div></td>
    </tr>
    <?php } ?>
  </tbody>
  <tfoot>
    <?php if(!empty($output['list']) && is_array($output['list'])){?>
    <tr>
      <td colspan="20"><div class="pagination"><?php echo $output['show_page'];?></div></td>
    </tr>
    <?php }?>
  </tfoot>
</table>
