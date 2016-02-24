<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>停车位管理</h3>
      <ul class="tab-base">
        <li><a href="index.php?act=party_barcode&op=index"><span><?php echo $lang['nc_manage'];?></span></a></li>
        <li><a class="current" href="JavaScript:void(0);"><span><?php echo $lang['nc_new'];?></span></a></li>
      </ul>
    </div>
  </div>
  <div class="fixed-empty"></div>
  <form id="party_barcode_form" method="post" enctype="multipart/form-data">
    <input type="hidden" value="ok" name="form_submit" />
    <table class="table tb-type2">
      <tbody>
        <tr class="noborder">
          <td class="required" colspan="2"><label class="validation" for="code">编码</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" class="txt" name="code" id="code" /></td>
          <td class="vatop tips">可以按一定编码规则进行添加设置；如A-C-1代表A楼B区1号停车位</td>
        </tr>
        
        
        <tr>
          <td class="required" colspan="2"><label class="validation" for="address">地址</label></td>
        </tr>
        <tr class="noborder">
          <td class="vatop rowform"><input type="text" class="txt" name="address" id="address"  /></td>
          <td class="vatop tips">文字化描述位置信息</td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="tfoot">
          <td colspan="15"><a id="submitBtn" class="btn" href="JavaScript:void(0);"> <span><?php echo $lang['nc_submit'];?></span> </a></td>
        </tr>
      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/common_select.js" charset="utf-8"></script> 
<script type="text/javascript">
$(function(){
	//表单验证
    $('#party_barcode_form').validate({
        errorPlacement: function(error, element){
			error.appendTo(element.parent().parent().prev().find('td:first'));
        },

        rules : {
        	code: {
        	required : true,
                maxlength: 20,
                minlength: 1
            },
            address: {
		required : true,
		maxlength: 50,
                minlength: 1
            }
        },
        messages : {
        	code : {
            	required : '请输入编码',
                maxlength: '编号长度最大20位',
                minlength: '编号长度最低1位'
            },
                address: {
		required : '请输入地址',
                maxlength: '编号长度最大50位',
                minlength: '编号长度最低1位'
            }
        }
    });

    //按钮先执行验证再提交表单
    $("#party_barcode_form").click(function(){
        if($("#party_barcode_form").valid()){
        	$("#party_barcode_form").submit();
    	}
    });
});

gcategoryInit('gcategory');
</script> 
