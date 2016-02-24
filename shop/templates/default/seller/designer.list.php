<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('layout/submenu');?>
    <a href="<?php echo urlShop('designer', 'designer_add');?>" class="ncsc-btn ncsc-btn-green" title="添加设计师">添加设计师</a> </div>
  <table class="ncsc-default-table">
    <thead>
      <tr>
        <th class="w60">顺序</th>
        <th class="tl">设计师名字</th>
        <th class="w120">是否显示</th>
        <th class="w200"><?php echo $lang['nc_handle'];?></th>
      </tr>
    </thead>
    <tbody>
      <?php if(!empty($output['designer_list'])){?>
      <?php foreach($output['designer_list'] as $key=> $value){?>
      <tr class="bd-line">
        <td><?php echo $value['sn_sort'];?></td>
        <?php $sn_href = empty($value['sn_url'])?urlShop('show_store', 'show_article', array('store_id' => $_SESSION['store_id'], 'sn_id' => $value['sn_id'])):$value['sn_url'];?>
        <td class="tl"><dl class="goods-name"><dt><a href="<?php echo $sn_href;?>" ><?php echo $value['sn_title'];?></a></dt></dl></td>
        <td><?php if($value['sn_if_show']){echo $lang['nc_yes'];}else{echo $lang['nc_no'];}?></td>
        <td class="nscs-table-handle">
            <span><a href="<?php echo urlShop('designer_work', 'designer_work_add', array('designer_id' => $value['id'],'store_id' => $_SESSION['store_id']));?>" class="btn-green"><i class="icon-heart"></i><p>作品</p></a></span>  
            <span><a href="<?php echo urlShop('designer', 'designer_edit', array('sn_id' => $value['id']));?>" class="btn-blue"><i class="icon-edit"></i>
          <p> <?php echo $lang['nc_edit'];?></p>
          </a></span><span> <a href="javascript:;" nctype="btn_del" data-sn-id="<?php echo $value['id'];?>"class="btn-red"><i class="icon-trash"></i>
          <p><?php echo $lang['nc_del'];?></p>
          </a></span></td>
      </tr>
      <?php }?>
      <?php } else { ?>
      <tr>
        <td colspan="20" class="norecord"><div class="warning-option"><i class="icon-warning-sign"></i><span><?php echo $lang['no_record'];?></span></div></td>
      </tr>
      <?php }?>
    </tbody>
  </table>
</div>
<form id="del_form" method="post" action="<?php echo urlShop('designer', 'designer_del');?>">
  <input id="del_sn_id" name="sn_id" type="hidden" />
</form>
<script type="text/javascript">
    $(document).ready(function(){
        $('[nctype="btn_del"]').on('click', function() {
            var sn_id = $(this).attr('data-sn-id');
            if(confirm('确认删除？')) {
                $('#del_sn_id').val(sn_id);
                ajaxpost('del_form', '', '', 'onerror')
            }
        });
    });
</script>
