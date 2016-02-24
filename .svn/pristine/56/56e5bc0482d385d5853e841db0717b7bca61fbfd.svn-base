<?php defined('InShopNC') or exit('Access Invalid!');?>
<style>
    .QRcode {
    background: #F5F5F5;
    display: none;
    width: 160px;
    padding: 5px;
    border: solid 1px #CCC;
    position: absolute;
    z-index: 99;
    top: -90px;
    right: -10px;
    box-shadow: 0 0 5px rgba(0,0,0,0.15);
}

.qr {
    color: #555;
    vertical-align: middle;
    display: inline-block;
    margin-right: 6px;
    position: relative;
    z-index: 1;
    cursor: default;
}

</style>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/ToolTip.js"></script>

  
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>停车位</h3>
      <ul class="tab-base">
        <li><a class="current" href="JavaScript:void(0);"><span><?php echo $lang['nc_manage'];?></span></a></li>
        <li><a href="index.php?act=party_barcode&op=party_add"><span><?php echo $lang['nc_new'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" name="formSearch" id="formSearch">
    <input type="hidden" name="act" value="party_barcode">
    <input type="hidden" name="op" value="index">
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><label for="search_PB_code">编号</label></th>
          <td><input type="text" value="<?php echo $output['search']['search_PB_code'];?>" name="search_PB_code" id="search_PB_code" class="txt"></td>
          <th><label for="search_PB_address">地址</label></th>
          <td><input type="text" value="<?php echo $output['search']['search_PB_address']?>" name="search_PB_address" id="search_PB_address" class="txt" /></td>
            
          <td ><a href="javascript:void(0);" id="ncsubmit" class="btn-search " title="<?php echo $lang['nc_query'];?>">&nbsp;</a></td>
          <td class="w120">&nbsp;</td>
        </tr>

      </tbody>
    </table>
  </form>
  
  
  
  

  <form id="form_PB" method="get">
    <input type="hidden" name="act" value="party_barcode" />
    <input type="hidden" name="op" value="del" />
    <div style="text-align: right;"><a class="btns" href="index.php?act=party_barcode&op=export_step1"><span><?php echo $lang['nc_export'];?>Excel</span></a></div>
    <table class="table tb-type2">
      <thead>
        <tr class="thead">
          <th></th>
          <th>编码</th>
          <th>地址</th>
          <th class="align-center"><?php echo $lang['nc_handle'];?></th>
        </tr>
      </thead>
      <tbody>
        <?php if ( !empty($output['party_barcode_list']) && is_array($output['party_barcode_list']) ) {?>
        <?php foreach ($output['party_barcode_list'] as $val) {?>
        <tr class="hover edit">
          <td class="w12"><input type="checkbox" name="del_id[]" value="<?php echo $val['sp_id'];?>" <?php if($val['sp_id'] == '1'){?>disabled="disabled"<?php }else{?>class="checkitem"<?php }?> /></td>
          <td class="w96 sort"><span class="editable" maxvalue="255" title=""  fieldid="<?php echo $val['id'];?>" ajax_branch="change_value" fieldname="code" nc_type="inline_edit"><?php echo $val['code'];?></span></td>
          <td class="w50pre name">
          <span title="<?php echo $lang['nc_editable'];?>" required="1" fieldid="<?php echo $val['id'];?>" ajax_branch="change_value" fieldname="address" nc_type="inline_edit" class="editable "><?php echo $val['address'];?></span>
          </td>

          <td class="w48 align-center">
              <span class="qr" title="停车位二维码"><i class="icon-qrcode"></i>
            <div class="QRcode"><a target="_blank" href="<?php echo partyQRCode(array('party_id' => $val['id']));?>">下载标签</a>
              <p><img src="<?php echo partyQRCode(array('party_id' => $val['id']));?>"/></p>
            </div>
            </span>
             
              
            
              
                  <?php if($val['id'] != '1'){?>|
              
              <a onclick="if(confirm('<?php echo $lang['nc_ensure_del'];?>')){location.href='index.php?act=party_barcode&op=del&del_id=<?php echo $val['id'];?>';}else{return false;}" href="javascript:void(0)"><?php echo $lang['nc_del'];?></a><?php }?> </td>
        </tr>
        <?php }?>
        <?php }else{ ?>
        <tr class="no_data">
          <td colspan="10"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php }?>
      </tbody>
      <?php if(!empty($output['party_barcode_list']) && is_array($output['party_barcode_list'])){ ?>
      <tfoot>
        <tr>
          <td><input type="checkbox" class="checkall" id="checkallBottom" /></td>
          <td id="dataFuncs" colspan="16"><label for="checkallBottom"><?php echo $lang['nc_select_all'];?></label>
            <a class="btn" onclick="submit_form('del');" href="JavaScript:void(0);"> <span><?php echo $lang['nc_del'];?></span> </a>
            <div class="pagination"> <?php echo $output['page'];?> </div></td>
        <tr>
      </tfoot>
      <?php }?>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.edit.js" charset="utf-8"></script> 
<script type="text/javascript">
    
$('#ncsubmit').click(function(){
        $('input[name="op"]').val('index');$('#formSearch').submit();
});

    $('.qr').hover(function(){
        $(this).children('.QRcode').show();
            //$('.QRcode',this).show();
      },function(){
           $(this).children('.QRcode').hide();
      });

function submit_form(type){
	var id='';
	$('input[type=checkbox]:checked').each(function(){
		if(!isNaN($(this).val())){
			id += $(this).val();
		}
	});
	if(id == ''){
		alert('<?php echo $lang['spec_index_no_checked'];?>');
		return false;
	}
	if(type=='del'){
		if(!confirm('<?php echo $lang['nc_ensure_del'];?>')){
			return false;
		}
	}
	$('#form_PB').submit();
}
</script>