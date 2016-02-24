<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="tabmenu">
  <?php include template('layout/submenu');?>
 <!--好商城V3-B11-->

<form method="get" action="index.php">
  <table class="search-form">
    <input type="hidden" name="act" value="decoration" />
    <input type="hidden" name="op" value="work_list" />
    <tr>
      <td>&nbsp;</td>
      <th><?php echo $lang['store_goods_index_store_goods_class'];?></th>
      <td class="w160">
          <select name="stc_id" class="w150">
          <option value="0"><?php echo $lang['nc_please_choose'];?></option>
          <?php foreach ($output['states'] as $key => $val){?>
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
          <option value="dw_name" <?php if ($_GET['search_type'] == 'dw_name') {?>selected="selected"<?php }?>>标题</option>
          <option value="dw_content" <?php if ($_GET['search_type'] == 'dw_content') {?>selected="selected"<?php }?>>内容</option>
          <option value="dw_address" <?php if ($_GET['search_type'] == 'dw_address') {?>selected="selected"<?php }?>>地址</option>
          <option value="dw_category" <?php if ($_GET['search_type'] == 'dw_category') {?>selected="selected"<?php }?>>装修类型</option>
          <option value="dw_style" <?php if ($_GET['search_type'] == 'dw_style') {?>selected="selected"<?php }?>>风格</option>
          <option value="dw_budget" <?php if ($_GET['search_type'] == 'dw_budget') {?>selected="selected"<?php }?>>预算</option>
          <option value="dw_addtime" <?php if ($_GET['search_type'] == 'dw_addtime') {?>selected="selected"<?php }?>>发布日期</option>
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
           if(tsv=='dw_addtime'){
               $('.datatable').show();
               $('.textdata').hide();
           }else if(tsv=='dw_budget'){
               $('.calculate_type').show();
           }
           
            $('.typeselect').change(function(e){
                //alert($(this).val());
                $('.datatable').hide();
                $('.calculate_type').hide();
                    $('.textdata').show();
                    
                if($(this).val()=='dw_addtime'){
                    $('.datatable').show();
                    $('.textdata').hide();
                }
                
                if($(this).val()=='dw_budget'){
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
      <th class="w50">&nbsp;</th>

       <th class="w100">&nbsp;</th>
      <th coltype="editable" column="goods_name" checker="check_required" inputwidth="230px">地址</th>
      <th class="w50">装修类型</th>
      <th class="w50">风格</th>
      <th class="w50">房屋类型</th>
      <th class="w50">预算(万)</th>
      <th class="w100">发布日期</th>
      <th class="w50">剩余可投</th>
      <th class="w50">状态</th>
      <th class="w120"><?php echo $lang['nc_handle'];?></th>
    </tr>
    <?php if (!empty($output['work_list'])) { ?>
  
    <?php } ?>
  </thead>
  <tbody>
    <?php if (!empty($output['work_list'])) { ?>
    <?php foreach ($output['work_list'] as $val) { ?>
    <tr>
      <th class="tc">

      </th>
      <th colspan="20">需求编号：<?php echo $val['dw_id'];?></th>
    </tr>
    <tr>
      <td class="trigger">
          <i class="tip icon-plus-sign" nctype="ajaxGoodsList" data-comminid="<?php echo $val['id'];?>" title="点击展开查看此需求全部规格；"></i></td>

      <td class="tl"><dl class="goods-name">
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
            <a href="<?php echo urlShop('goods', 'index', array('goods_id' => $output['storage_array'][$val['goods_commonid']]['goods_id']));?>" target="_blank"><?php echo $val['dw_name']; ?></a></dt>
          <dd><?php echo $val['dw_area'];?>平米</dd>
          <dd class="serve"> 
            
            <?php if ($val['is_fcode'] ==1) {?>
            <span><a class="ncsc-btn-mini ncsc-btn-red" href="<?php echo urlShop('store_goods_online', 'download_f_code_excel', array('commonid' => $val['goods_commonid']));?>">下载F码</a></span>
            <?php }?>
          </dd>
        </dl>
      </td>
     
      <td><span <?php if ($output['storage_array'][$val['goods_commonid']]['alarm']) { echo 'style="color:red;"';}?>><?php echo $val['dw_address']; ?></span></td>

      <td><span><?php echo $val['dw_category']; ?></span></td>
      <td><span><?php echo $val['dw_style']; ?></span></td>
      <td><span><?php echo $val['dw_house_type']; ?></span></td>
      
       <td><span><?php echo $lang['currency'].$val['dw_budget']; ?></span></td>
      
      <td class="goods-time"><?php echo @date('Y-m-d',$val['dw_addtime']);?></td>
      <td ><span> <?php echo getBidCharge(array('bid_work_id'=>$val['dw_id'])); ?></span></td>
      
      <td><span><?php echo $output['states'][$val['dw_state']]?></span></td>
      <?php $result=checkBtWin($val); ?>
      
      <td class="nscs-table-handle"><?php if (!checkbid(array('bid_dc_id'=>$_SESSION['store_id'],'bid_work_id'=>$val['dw_id']))) {?>
        <span class="tip" title="每个用户最多可以投 票"><a href="<?php if ($val['is_virtual'] ==1 ) {echo 'javascript:void(0);';} else {echo urlShop('store_goods_online', 'add_gift', array('commonid' => $val['goods_commonid']));}?>" class="btn-orange-current"><i class="icon-lock"></i>
        <p>锁定</p>
        </a></span>
        <?php } else if(checkCanBid($val)!=1){?>
       <span><a href="<?php echo urlShop('bid_document', 'editBd', array('commonid' => $val['dw_id']));?>" class="btn-blue"><i class="icon-edit"></i>
               <p>下标</p>
        </a>
        </span>
        <?php }else if(!empty($result)){?>
          
          <span><a href="javascript:void(0);" onclick="lookup_win(<?php echo $result[0]['bt_bid']; ?>)" class="btn-blue"><i class="icon-edit"></i>
               <p>中标公示</p>
        </a>
        </span>
        <?php }else{ ?>
          <span class="tip" title="请耐性等待竞标结果"><a href="javascript:void(0);"><p>已投</p></a></span>
             
        <?php } ?>
      </td>
    </tr>
    <tr style="display:none;">
        <td colspan="20">
            <div class="ncsc-goods-sku ps-container">
                <ul class="ncsc-goods-sku-list">
                    <?php $picarr=  explode(',', $val['dw_file_paths']) ?>
                    <?php foreach ($picarr as $key => $value) {  ?>
                        <li>
                            <div class="goods-thumb" title="商家货号：">
                                <a class="fancybox" href="<?php echo reqthumb($value,1280); ?>" target="_blank">
                                    <img src="<?php echo reqthumb($value,60); ?>">
                                </a>
                            </div>
                            
                        </li>
                    <?php } ?>
                </ul>
                
            </div>
        </td>
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

    </tr>
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
	<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fancy/jquery.mousewheel.pack.js?v=3.1.3"></script>
	<!-- Add fancyBox main JS and CSS files -->
	<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fancy/jquery.fancybox.pack.js?v=2.1.5"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/fancy/jquery.fancybox.css?v=2.1.5" media="screen" />
	<!-- Add Button helper (this is optional) -->
	<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/fancy/helpers/jquery.fancybox-buttons.css?v=1.0.5" />
	<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fancy/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
	<!-- Add Thumbnail helper (this is optional) -->
	<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/fancy/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />
	<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fancy/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
	<!-- Add Media helper (this is optional) -->
	<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/fancy/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
<style>
    .data{
            background: url(../images/input_date.gif) no-repeat 0 0;
            padding-left: 25px;
            width: 70px;
    }
</style>


<script>
$(function(){
    $('.fancybox').fancybox();

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


function lookup_win(id) {
    _uri = "<?php echo urlShop('decoration', 'lookup_win');?>&id=" + id;
    CUR_DIALOG = ajax_form('lookup_win', '中标详情', _uri, 500);
}

</script>