<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('layout/submenu');?>
 <form method="get" action="index.php">
  <table class="search-form">
    <input type="hidden" name="act" value="designer_work" />
    <input type="hidden" name="op" value="designer_work_list" />
    <tr>
      <td>&nbsp;</td>
      <th>设计师</th>
      <td class="w160"><select name="d_id" class="w150">
          <option value="0">不限制</option>
          <?php if(is_array($output['designers']) && !empty($output['designers'])){?>
          <?php foreach ($output['designers'] as $val) {?>
          <option value="<?php echo $val['id']; ?>" <?php if ($_GET['d_id'] == $val['id']){ echo 'selected=selected';}?>><?php echo $val['sn_title']; ?></option>
          <?php }?>
          <?php }?>
        </select></td>
        <th>作品名</th>
      <td class="w160"><input type="text" class="text w150" name="keyword" value="<?php echo $_GET['keyword']; ?>"/></td>
      <td class="tc w70"><label class="submit-border">
          <input type="submit" class="submit" value="<?php echo $lang['nc_search'];?>" />
        </label></td>
    </tr>
  </table>
</form>   
  <table class="ncsc-default-table">
    <thead>
      <tr>
        <th class="w60">作品名</th>
        <th class="w60">设计师</th>
        <th class="w120">是否显示</th>
        <th class="w110"><?php echo $lang['nc_handle'];?></th>
      </tr>
    </thead>
    <tbody>
      <?php if(!empty($output['designer_work_list'])){?>
      <?php foreach($output['designer_work_list'] as $key=> $value){?>
      <tr class="bd-line">
        <td><?php echo $value['sn_name'];?></td>
        <?php $sn_href = empty($value['sn_url'])?urlShop('designer', 'designer_edit', array('store_id' => $_SESSION['store_id'], 'sn_id' => $value['id'])):$value['sn_url'];?>
        <td><a href="<?php echo $sn_href;?>" ><?php echo $value['sn_title'];?></a></td>
        <td><?php if($value['sn_if_show']>0){echo '是';}else{echo '否';}?></td>
        <td class="nscs-table-handle"><span><a href="<?php echo urlShop('designer_work', 'designer_work_edit', array('sn_id' => $value['id'],'opt'=>'editwork','designer_id'=>$value['sn_designer_id'],'sn_category'=>$value['sn_category'],'sn_style'=>$value['sn_style']));?>" class="btn-blue"><i class="icon-edit"></i>
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
      <tr>
      <td colspan="20"><div class="pagination"> <?php echo $output['show_page']; ?> </div></td>
    </tr>
    
    </tbody>
  </table>
</div>
<form id="del_form" method="post" action="<?php echo urlShop('designer_work', 'designer_del');?>">
  <input id="del_sn_id" name="sn_id" type="hidden" />
</form>
<script type="text/javascript">
    $(document).ready(function(){
        $('[nctype="btn_del"]').on('click', function() {
            var sn_id = $(this).attr('data-sn-id');
            alert(sn_id);
            if(confirm('确认删除？')) {
                $('#del_sn_id').val(sn_id);
                ajaxpost('del_form', '', '', 'onerror')
            }
        });
    });
</script>
