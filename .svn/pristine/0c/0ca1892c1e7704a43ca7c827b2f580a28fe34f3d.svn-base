<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="tabmenu">
  <?php include template('layout/submenu');?>
 <!--好商城V3-B11-->
<form method="get" action="index.php">
  <table class="search-form">
    <input type="hidden" name="act" value="bid_document" />
    <input type="hidden" name="op" value="bd_list" />
    <tr>
      <td>&nbsp;</td>
      <th><?php echo $lang['store_goods_index_store_goods_class'];?></th>
      <td class="w160"><select name="stc_id" class="w150">
          <option value=""><?php echo $lang['nc_please_choose'];?></option>
          <?php foreach ($output['bid_states'] as $key => $val){?>
              <option value="<?php echo $key;?>" <?php if($_GET['search_state'] != '' && $output['search']['search_state'] == $key){?>selected<?php }?>><?php echo $val;?></option>
          <?php }?>
              
          <?php if(is_array($output['store_goods_class']) && !empty($output['store_goods_class'])){?>
          <?php foreach ($output['store_goods_class'] as $val) {?>
          <option value="<?php echo $val['stc_id']; ?>" <?php if ($_GET['stc_id'] == $val['stc_id']){ echo 'selected=selected';}?>><?php echo $val['stc_name']; ?></option>
          <?php if (is_array($val['child']) && count($val['child'])>0){?>
          <?php foreach ($val['child'] as $child_val){?>
          <option value="<?php echo $child_val['stc_id']; ?>" <?php if ($_GET['stc_id'] == $child_val['stc_id']){ echo 'selected=selected';}?>>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $child_val['stc_name']; ?></option>
          <?php }?>
          <?php }?>
          <?php }?>
          <?php }?>
        </select></td>
      <th> <select class="typeselect" name="search_type">
          <option value="bid_work_id" <?php if ($_GET['search_type'] == 'bid_work_id') {?>selected="selected"<?php }?>>需求编号</option>
          <option value="bid_title" <?php if ($_GET['search_type'] == 'bid_title') {?>selected="selected"<?php }?>>标题</option>
          <option value="bid_highlight" <?php if ($_GET['search_type'] == 'bid_highlight') {?>selected="selected"<?php }?>>陈述</option>
          <option value="bid_budget" <?php if ($_GET['search_type'] == 'bid_budget') {?>selected="selected"<?php }?>>预算</option>
          <option value="bid_addtime" <?php if ($_GET['search_type'] == 'bid_addtime') {?>selected="selected"<?php }?>>发布日期</option>
        </select>
      </th>
      <th class="calculate_type" style="display: none">
          <select name='calculate_type'>
              <option value="gt">运算符</option>
              <option value="gt">></option>
              <option value="lt">></option>
          </select>
      </th>
    <script>
        $(function(){
           var tsv = $('.typeselect').val();
           if(tsv=='bid_addtime'){
               $('.datatable').show();
               $('.textdata').hide();
           }else if(tsv=='bid_budget'){
               $('.calculate_type').show();
           }
            $('.typeselect').change(function(e){
                //alert($(this).val());
                    $('.datatable').hide();
                    $('.calculate_type').hide();
                    $('.textdata').show();
                    
                if($(this).val()=='bid_addtime'){
                    $('.datatable').show();
                    $('.textdata').hide();
                }
                
                if($(this).val()=='bid_budget'){
                    $('.calculate_type').show();
                }
            })
        })
    </script>
      <td  class="w260 datatable" style="display: none ;">
          <input type="text" class="txt date" value="<?php echo $_GET['search_stime'];?>" name="search_stime" id="search_stime" class="txt">
            <label for="search_etime">~</label>
            <input type="text" class="txt date" value="<?php echo $_GET['search_etime'];?>" name="search_etime" id="search_etime" class="txt">
              
      </td>    
      
      <td class="w160 textdata"><input type="text" class="text w150" name="keyword" value="<?php echo $_GET['keyword']; ?>"/></td>
      <td class="tc w70"><label class="submit-border">
          <input type="submit" class="submit" value="<?php echo $lang['nc_search'];?>" />
        </label></td>
    </tr>
  </table>
</form>
<table class="ncsc-default-table">
  <thead>
    <tr nc_type="table_header">
      <th class="w30">&nbsp;</th>
      <th class="w50">&nbsp;</th>
      <th coltype="editable" column="goods_name" checker="check_required" inputwidth="230px"><?php echo $lang['store_goods_index_goods_name'];?></th>
      <th class="w100">预算</th>
      <th class="w100">状态</th>
      <th class="w100">发布时间</th>
      <th class="w120"><?php echo $lang['nc_handle'];?></th>
    </tr>
    <?php if (!empty($output['work_list'])) { ?>
    <tr>
      <td class="tc"><input type="checkbox" id="all" class="checkall"/></td>
      <td colspan="20"><label for="all" ><?php echo $lang['nc_select_all'];?></label>
        <a href="javascript:void(0);" class="ncsc-btn-mini" nc_type="batchbutton" uri="<?php echo urlShop('store_goods_online', 'drop_goods');?>" name="commonid" confirm="<?php echo $lang['nc_ensure_del'];?>"><i class="icon-trash"></i><?php echo $lang['nc_del'];?></a> <a href="javascript:void(0);" class="ncsc-btn-mini" nc_type="batchbutton" uri="<?php echo urlShop('store_goods_online', 'goods_unshow');?>" name="commonid"><i class="icon-level-down"></i><?php echo $lang['store_goods_index_unshow'];?></a> <a href="javascript:void(0);" class="ncsc-btn-mini" nctype="batch" data-param="{url:'<?php echo urlShop('store_goods_online', 'edit_jingle');?>', sign:'jingle'}"><i></i>设置广告词</a> <a href="javascript:void(0);" class="ncsc-btn-mini" nctype="batch" data-param="{url:'<?php echo urlShop('store_goods_online', 'edit_plate');?>', sign:'plate'}"><i></i>设置关联版式</a></td>
    </tr>
    <?php } ?>
  </thead>
  <tbody>
    <?php if (!empty($output['bid_list'])) { ?>
    <?php foreach ($output['bid_list'] as $val) { ?>
    <tr>
      <th class="tc">
   
      </th>
      <th colspan="20">需求编号：<?php echo $val['bid_work_id'];?></th>
    </tr>
    <tr>
      <td class="trigger"><i class="tip icon-plus-sign" nctype="ajaxGoodsList" data-comminid="<?php echo $val['id'];?>" title="点击展开查看此商品全部规格；规格值过多时请横向拖动区域内的滚动条进行浏览。"></i></td>
      <td >
    
      </td>
      <td class="tl" ><dl class="goods-name" >
          <dt style="max-width: 450px !important;">
            <?php if ($val['is_virtual'] ==1) {?>
            <span class="type-virtual" title="虚拟兑换商品">虚拟</span>
            <?php }?>
            <?php if ($val['is_fcode'] ==1) {?>
            <span class="type-fcode" title="F码优先购买商品">F码</span>
            <?php }?>
            <?php if ($val['is_presell'] ==1) {?>
            <span class="type-presell" title="预先发售商品">预售</span>
            <?php }?>
            <?php if ($val['is_appoint'] ==1) {?>
            <span class="type-appoint" title="预约销售提示商品">预约</span>
            <?php }?>
            <a href="<?php echo urlShop('goods', 'index', array('goods_id' => $output['storage_array'][$val['goods_commonid']]['goods_id']));?>" target="_blank"><?php echo $val['bid_title']; ?></a></dt>
          <dd><?php echo '陈述'.$lang['nc_colon'];?><?php echo $val['bid_highlight'];?></dd>
          <dd class="serve" style="display:none">
              <span class="<?php if ($val['sn_commend'] == 1) { echo 'open';}?>" title="店铺推荐商品"><i class="commend">荐</i></span> <span class="<?php if ($val['mobile_body'] != '') { echo 'open';}?>" title="手机端商品详情"><i class="icon-tablet"></i></span> <span class="" title="商品页面二维码"><i class="icon-qrcode"></i>
            <div class="QRcode"><a target="_blank" href="<?php echo goodsQRCode(array('goods_id' => $output['storage_array'][$val['goods_commonid']]['goods_id'], 'store_id' => $_SESSION['store_id']));?>">下载标签</a>
              <p><img src="<?php echo goodsQRCode(array('goods_id' => $output['storage_array'][$val['goods_commonid']]['goods_id'], 'store_id' => $_SESSION['store_id']));?>"/></p>
            </div>
            </span>
            <?php if ($val['is_fcode'] ==1) {?>
            <span><a class="ncsc-btn-mini ncsc-btn-red" href="<?php echo urlShop('store_goods_online', 'download_f_code_excel', array('commonid' => $val['goods_commonid']));?>">下载F码</a></span>
            <?php }?>
          </dd>
        </dl></td>
      <td><span><?php echo $lang['currency'].$val['bid_budget']; ?></span></td>
      <td><span <?php if ($output['storage_array'][$val['goods_commonid']]['alarm']) { echo 'style="color:red;"';}?>><?php echo $output['bid_states'][$val['bid_state']]; ?></span></td>
      <td class="goods-time"><?php echo @date('Y-m-d',$val['bid_addtime']);?></td>
      <td class="nscs-table-handle">
        
          
          <?php if($val['bid_state']==1){ ?>
          <span><a href="<?php echo urlShop('bid_document', 'editBd', array('commonid' => $val['bid_work_id']));?>" class="btn-blue"><i class="icon-edit"></i>
        <p>修改<?php echo $val['bid_state'];  ?></p>
        </a></span> 
          
          <span><a href="javascript:void(0);" onclick="ajax_get_confirm('确定要放弃吗？', '<?php echo urlShop('bid_document', 'drop_bid', array('commonid' => $val['bid_id']));?>');" class="btn-red"><i class="icon-trash"></i>
        <p>放弃</p>
        </a>
          </span>
        <?php } else{?>
        <span><a href="<?php echo urlShop('bid_document', 'editBd', array('lock' => 1,'commonid' => $val['bid_work_id']));?>" class="btn-blue"><i class="icon-edit"></i>
         <p>查看</p>
        </a></span>
        <?php } ?>

      </td>
         
  
    </tr>
    <tr style="display:none;">
      <td colspan="20"><div class="ncsc-goods-sku ps-container"></div></td>
    </tr>
    <?php } ?>
    <?php } else { ?>
    <tr>
      <td colspan="20" class="norecord"><div class="warning-option"><i class="icon-warning-sign"></i><span><?php echo $lang['no_record'];?></span></div></td>
    </tr>
    <?php } ?>
  </tbody>
  <tfoot>
    <?php  if (!empty($output['work_list'])) { ?>

    <tr>
      <td colspan="20"><div class="pagination"> <?php echo $output['show_page']; ?> </div></td>
    </tr>
    <?php } ?>
  </tfoot>
</table>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.poshytip.min.js"></script> 
<script src="<?php echo SHOP_RESOURCE_SITE_URL;?>/js/store_goods_list.js"></script>

<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />

<script>
$(function(){
    
    $('#search_stime').datepicker({dateFormat: 'yy-mm-dd'});
    $('#search_etime').datepicker({dateFormat: 'yy-mm-dd'});
    
    //Ajax提示
    $('.tip').poshytip({
        className: 'tip-yellowsimple',
        showTimeout: 1,
        alignTo: 'target',
        alignX: 'center',
        alignY: 'top',
        offsetY: 5,
        allowTipHover: false
    });
    $('a[nctype="batch"]').click(function(){
        if($('.checkitem:checked').length == 0){    //没有选择
        	showDialog('请选择需要操作的记录');
            return false;
        }
        var _items = '';
        $('.checkitem:checked').each(function(){
            _items += $(this).val() + ',';
        });
        _items = _items.substr(0, (_items.length - 1));

        var data_str = '';
        eval('data_str = ' + $(this).attr('data-param'));

        if (data_str.sign == 'jingle') {
            ajax_form('ajax_jingle', '设置广告词', data_str.url + '&commonid=' + _items + '&inajax=1', '480');
        } else if (data_str.sign == 'plate') {
            ajax_form('ajax_plate', '设置关联版式', data_str.url + '&commonid=' + _items + '&inajax=1', '480');
        }
    });
});
</script>

