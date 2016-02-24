<?php defined('InShopNC') or exit('Access Invalid!');?>

<!-- 店铺信息 -->

<div id="apply_store_info" class="apply-store-info">
 
  <form id="form_decoration_info" action="index.php?act=decoration_join&op=step4" method="post" >
    <table border="0" cellpadding="0" cellspacing="0" class="all">
      <thead>
        <tr>
          <th colspan="20">店铺经营信息</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th class="w150"><i>*</i>商家账号：</th>
          <td><input id="seller_name" name="seller_name" type="text" class="w200"/>
            <span></span>
            <p class="emphasis">此账号为日后登录并管理商家中心时使用，注册后不可修改，请牢记。</p></td>
        </tr>
        <tr>
          <th class="w150"><i>*</i>店铺名称：</th>
          <td><input name="store_name" type="text" class="w200"/>
            <span></span>
            <p class="emphasis">店铺名称注册后不可修改，请认真填写。</p></td>
        </tr>

       
 

 
      </tbody>
      <tfoot>
        <tr>
          <td colspan="20">&nbsp;</td>
        </tr>
      </tfoot>
    </table>
  </form>
  <div class="bottom"><a id="btn_apply_store_next" href="javascript:;" class="btn">提交申请</a>
  </div>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/common_select.js" charset="utf-8"></script> 
<script type="text/javascript">
$(document).ready(function(){
	//gcategoryInit("gcategory");

    jQuery.validator.addMethod("seller_name_exist", function(value, element, params) { 
        var result = true;
        $.ajax({  
            type:"GET",  
            url:'<?php echo urlShop('decoration_join', 'check_seller_name_exist');?>',  
            async:false,  
            data:{seller_name: $('#seller_name').val()},  
            success: function(data){  
                if(data == 'true') {
                    $.validator.messages.seller_name_exist = "卖家账号已存在";
                    result = false;
                }
            }  
        });  
        return result;
    }, '');

    $('#form_decoration_info').validate({
        errorPlacement: function(error, element){
            element.nextAll('span').first().after(error);
        },
        rules : {
            seller_name: {
                required: true,
                maxlength: 50,
                seller_name_exist: true
            },
            store_name: {
                required: true,
                maxlength: 50,
                remote : '<?php echo urlShop('decoration_join', 'checkname');?>'
            }
        },
        messages : {
            seller_name: {
                required: '请填写卖家用户名',
                maxlength: jQuery.validator.format("最多{0}个字")
            },
            store_name: {
                required: '请填写店铺名称',
                maxlength: jQuery.validator.format("最多{0}个字"),
                remote : '店铺名称已存在'
            }
        }
    });
    $('#btn_apply_store_next').on('click', function() {
        $('#form_decoration_info').submit();
    });
});
</script> 
