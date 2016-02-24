<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('layout/submenu');?>
    <a href="<?php echo urlShop('store_sns', 'index',array('cat'=>'signup'));?>" class="ncsc-btn ncsc-btn-green" title="添加活动">添加活动</a> </div>
  
  <div style="text-align:right;"><a class="btns" href="javascript:void(0);" id="ncexport"><span><?php echo $lang['nc_export'];?>Excel</span></a>
    
       <form method="get" name="formSearch" id="formSearch">
    <input type="hidden" value="activity" name="act">
    <input type="hidden" value="member" name="op">
    <input type="hidden" value="<?php echo !empty($_GET['id'])?$_GET['id']:$output['act_m_apply_act_id'];?>" name="act_m_apply_act_id">
  </form>
      
      
      
      <table class="ncsc-default-table">
    <thead>
      <tr>
        <th class="w60"><?php echo $lang['store_goods_class_sort'];?></th>
        <th class="tl">会员名</th>
        <th class="w120">电话</th>
        <th class="w110"><?php echo $lang['nc_handle'];?></th>
      </tr>
    </thead>
    <tbody>
      <?php if(!empty($output['list'])){?>
      <?php foreach($output['list'] as $key=> $value){?>
      <tr class="bd-line">
        <td><?php echo $value['activity_sort'];?></td>
        <?php $sn_href = empty($value['sn_url'])?urlShop('show_store', 'show_article', array('store_id' => $_SESSION['store_id'], 'sn_id' => $value['sn_id'])):$value['sn_url'];?>
        <td class="tl"><dl class="goods-name"><dt><a href="<?php echo $sn_href;?>" ><?php echo $value['activity_title'];?></a></dt></dl></td>
        <td><?php if($value['activity_verify']==1){echo '通过';}else if($value['activity_verify']==10){echo '审核中';}else{echo '不通过';}?></td>
        <td class="nscs-table-handle"><span>
                <?php if($value['activity_verify']==1){?>
          <a href="<?php echo urlShop('store_sns', 'member', array('act_m_apply_act_id' => $value['activity_id']));?>" class="btn-blue"><i class="icon-edit"></i>
          <p>查看</p>
          </a>
                <?php } ?>
            </span><span> <a href="javascript:;" nctype="btn_del" data-sn-id="<?php echo $value['sn_id'];?>"class="btn-red"><i class="icon-trash"></i>
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
      <tfoot>
    <?php if (!empty($output['list'])) { ?>
    <tr>
      <td colspan="20"><div class="pagination"><?php echo $output['show_page']; ?></div></td>
    </tr>
    <?php } ?>
  </tfoot>
  
  </table>
</div>
<form id="del_form" method="post" action="<?php echo urlShop('store_navigation', 'navigation_del');?>">
  <input id="del_sn_id" name="sn_id" type="hidden" />
</form>
<script type="text/javascript">
    $(document).ready(function(){
        
           $('#ncexport').click(function(){
    	$('input[name="op"]').val('export_step1');
    	$('#formSearch').submit();
    });
    
    s
        $('[nctype="btn_del"]').on('click', function() {
            var sn_id = $(this).attr('data-sn-id');
            if(confirm('确认删除？')) {
                $('#del_sn_id').val(sn_id);
                ajaxpost('del_form', '', '', 'onerror')
            }
        });
    });
</script>
