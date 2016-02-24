<?php defined('InShopNC') or exit('Access Invalid!');?>
<link href="<?php echo ADMIN_TEMPLATES_URL;?>/css/font/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
<!--[if IE 7]>
  <link rel="stylesheet" href="<?php echo ADMIN_TEMPLATES_URL;?>/css/font/font-awesome/css/font-awesome-ie7.min.css">
<![endif]-->
<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3><?php echo $lang['goods_index_goods'];?></h3>
      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span><?php echo $lang['all_work'];?></span></a></li>
       
        <li><a href="<?php echo urlAdmin('decoration', 'works', array('type' => 'waitverify'));?>"><span>等待审核</span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form method="get" name="formSearch" id="formSearch">
    <input type="hidden" name="act" value="decoration">
    <input type="hidden" name="op" value="works">
    <table class="tb-type1 noborder search">
      <tbody>
        <tr>
          <th><label for="search_goods_name"> 标题</label></th>
          <td><input type="text" value="<?php echo $output['search']['search_goods_name'];?>" name="search_goods_name" id="search_goods_name" class="txt"></td>
          <th><label for="search_commonid">编号</label></th>
          <td><input type="text" value="<?php echo $output['search']['search_commonid']?>" name="search_commonid" id="search_commonid" class="txt" /></td>
        
        </tr>
        <tr>
          <th><label>竞标状态</label></th>
          <td><select name="search_state">
              <option value=""><?php echo $lang['nc_please_choose'];?>...</option>
              <?php foreach ($output['state'] as $key => $val){?>
              <option value="<?php echo $key;?>" <?php if($output['search']['search_state'] != '' && $output['search']['search_state'] == $key){?>selected<?php }?>><?php echo $val;?></option>
              <?php }?>
            </select></td>
         <th><label>等待审核</label></th>
          <td><select name="search_verify">
              <option value=""  ><?php echo $lang['nc_please_choose'];?>...</option>
              <?php foreach ($output['verify'] as $key => $val){?>
              <option value="<?php echo $key;?>" <?php if($output['search']['search_verify'] != '' && $output['search']['search_verify'] == $key){?>selected<?php }?>><?php echo $val;?></option>
              <?php }?>
            </select></td> <td ><a href="javascript:void(0);" id="ncsubmit" class="btn-search " title="<?php echo $lang['nc_query'];?>">&nbsp;</a></td>
          <td class="w120">&nbsp;</td>
        </tr>
      </tbody>
    </table>
  </form>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12"><div class="title">
            <h5><?php echo $lang['nc_prompts'];?></h5>
            <span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td><ul>
            <li><?php echo $lang['goods_index_help1'];?></li>
            <li><?php echo $lang['goods_index_help2'];?></li>
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form method='post' id="form_goods" action="<?php echo urlAdmin('decoration', 'works');?>">
    <input type="hidden" name="form_submit" value="ok" />
    <table class="table tb-type2">
      <thead>
        <tr class="thead">
          <th class="w24"></th>
          
          <th class="w60 align-center">需求编号</th>
          <th colspan="2">标题</th>
          <th>类型</th>
          <th class="w72 align-center">面积(平方米)</th>
          <th class="w72 align-center">风格</th>
          <th class="w72 align-center">竞标状态</th>
          <th class="w72 align-center">审核状态</th>
         
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($output['work_list']) && is_array($output['work_list'])) { ?>
        <?php foreach ($output['work_list'] as $k => $v) {?>
        <tr class="hover edit">
          
          <td><i class="icon-plus-sign" style="cursor: pointer;" nctype="ajaxWorkList" data-comminid="<?php echo $v['id'];?>" title="点击展开查看此需求详情；值过多时请横向拖动区域内的滚动条进行浏览。"></i></td>
          <td class="align-center"><?php echo $v['dw_id'];?></td>
          <td class="w60 picture"><div class="size-56x56"><span class="thumb size-56x56"><i></i><img src="<?php echo getMemberAvatarForID($v['dw_user_id']);?>" onload="javascript:DrawImage(this,56,56);"/></span></div></td>
          <td>
          <dl class="goods-info"><dt class="goods-name"><?php echo $v['dw_name'];?></dt>

            <dd class="goods-store">会员名：<?php echo $v['user_name'];?></dd></dl>
            </td>
          <td>
            <p><?php echo $output['category'][$v['dw_category']];?></p>
            </td>
          <td class="align-center"><?php echo $v['dw_area']?></td>
          <td class="align-center"><?php echo $output['style'][$v['dw_style']];?></td>
          <td class="align-center"><?php if($v['dw_state']==1&&$v['dw_verify']==10){ echo '';}else{ echo $output['state'][$v['dw_state']];};?></td>
          <td class="align-center"><?php echo $output['verify'][$v['dw_verify']];?></td>
        </tr>
        <tr style="display:none;">
                    <td colspan="20"><div class="ncsc-goods-sku ps-container">
                            <ul class="ncsc-goods-sku-list">
                                <?php $parray=  explode(',', $v['dw_file_paths']); ?>
                              
                                <?php foreach ($parray as $key => $value) { ?>
                                <li><div class="goods-thumb" title="商家货号：">
                                        <img width="60px" height="60px" src="<?php echo reqthumb($value,60,$v['dw_user_id']); ?>">
                                    </div>
                                </li>
                                <?php } ?>
                            </ul>
                            <ul class="ncsc-goods-sku-list"style="display: block;border-top: dashed 1px #E6E6E6;margin-top: 3px;padding-top: 5px;">
                                <?php $ext=$v['ext'];?>
                              
                                <?php foreach ($ext as $bs) { ?>
                                <li>
                                    <div class="goods-thumb" title="装修公司：<?php echo $bs['store_name']; ?>">
                                        <img width="60" style="width:100%" src="<?php echo getStoreLogo($bs['store_label'],'store_avatar'); ?>">
                                    </div>
                                    <div class="goods-price">预算：<em title="￥<?php echo $bs['bid_budget']; ?>">￥<?php echo $bs['bid_budget']; ?>万</em></div>
                                    <a class="ncsc-btn-mini" href="javascript:void(0);" onclick="lookup_bid(<?php echo $bs['bid_id']; ?>)">查看详情</a>
                                </li>
                                <?php } ?>
                            </ul>
                            
                </div></td>
                
        </tr>
        
        <?php } ?>
        <?php } else { ?>
        <tr class="no_data">
          <td colspan="15"><?php echo $lang['nc_no_record'];?></td>
        </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          
          <td colspan="16">
            <div class="pagination"> <?php echo $output['page'];?> </div></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>

<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/common_select.js" charset="utf-8"></script>

<script type="text/javascript">
var SITEURL = "<?php echo SHOP_SITE_URL; ?>";
$(function(){
	//商品分类
	//init_gcselect(<?php echo $output['gc_choose_json'];?>,<?php echo $output['gc_json']?>);
	/* AJAX选择品牌 */
    $("#ajax_brand").brandinit();

    $('#ncsubmit').click(function(){
        $('input[name="op"]').val('works');$('#formSearch').submit();
    });

    // 违规下架批量处理
    $('a[nctype="lockup_batch"]').click(function(){
        str = getId();
        if (str) {
            goods_lockup(str);
        }
    });

    // ajax获取商品列表
    $('i[nctype="ajaxWorkList"]').toggle(
        function(){
            $(this).removeClass('icon-plus-sign').addClass('icon-minus-sign');
            var _parenttr = $(this).parents('tr');
            var _commonid = $(this).attr('data-comminid');
            var _div = _parenttr.next().find('.ncsc-goods-sku');
            if (_div.html() == '') {
                $.getJSON('index.php?act=decoration&op=get_work_list_ajax' , {commonid : _commonid}, function(date){
                    if (date != 'false') {
                        var _ul = $('<ul class="ncsc-goods-sku-list"></ul>');
                        $.each(date, function(i, o){
                           // $('<li><div class="goods-thumb" title="商家货号：' + o.goods_serial + '"><a href="' + o.url + '" target="_blank"><image src="' + o.goods_image + '" ></a></div>' + o.goods_spec + '<div class="goods-price">价格：<em title="￥' + o.goods_price + '">￥' + o.goods_price + '</em></div><div class="goods-storage">库存：<em title="' + o.goods_storage + '">' + o.goods_storage + '</em></div><a href="' + o.url + '" target="_blank" class="ncsc-btn-mini">查看商品详情</a></li>').appendTo(_ul);
                            $('<li><div class="goods-thumb" title=""><image src="' + o.s_image + '" ></div></li>').appendTo(_ul);
                          
                            });
                        _ul.appendTo(_div);
                        _parenttr.next().show();
                        // 计算div的宽度
                        _div.css('width', document.body.clientWidth-54);
                        _div.perfectScrollbar();
                    }
                });
            } else {
            	_parenttr.next().show()
            }
        },
        function(){
            $(this).removeClass('icon-minus-sign').addClass('icon-plus-sign');
            $(this).parents('tr').next().hide();
        }
    );
});

// 获得选中ID
function getId() {
    var str = '';
    $('#form_goods').find('input[name="id[]"]:checked').each(function(){
        id = parseInt($(this).val());
        if (!isNaN(id)) {
            str += id + ',';
        }
    });
    if (str == '') {
        return false;
    }
    str = str.substr(0, (str.length - 1));
    return str;
}

// 商品下架
function goods_lockup(ids) {
    _uri = "<?php echo ADMIN_SITE_URL;?>/index.php?act=decoration&op=work_lockup&id=" + ids;
    CUR_DIALOG = ajax_form('work_lockup', '违规下架理由', _uri, 350);
}

function lookup_bid(id) {
    _uri = "<?php echo ADMIN_SITE_URL;?>/index.php?act=decoration&op=lookup_bid&id=" + id;
    CUR_DIALOG = ajax_form('lookup_bid', '标书详情', _uri, 500);
}

</script>

