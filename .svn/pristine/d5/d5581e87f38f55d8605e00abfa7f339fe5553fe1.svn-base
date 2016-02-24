<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>装修设置</h3>
      <?php echo $output['top_link'];?>
<!--      <ul class="tab-base">
          
        <li><a href="JavaScript:void(0);" class="current"><span>类别管理</span></a></li>
        <li><a href="JavaScript:void(0);" ><span>风格管理</span></a></li>
      </ul>-->
    </div>
  </div>
  <div class="fixed-empty"></div>
  <!-- <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12"><div class="title"><h5><?php echo $lang['nc_prompts'];?></h5><span class="arrow"></span></div></th>
      </tr>
      <tr>
       <td>
        <ul>
        	<li class="tips">“会员级别设置”提交后，当会员符合某个级别后将自动升至该级别，请谨慎设置会员级别</li>
            <li class="tips">建议：一、级别应该是逐层递增，例如“级别2”所需经验值高于“级别1”；二、设置的第一个级别所需经验值应为0；三、信息应填写完整</li>
          </ul></td>
      </tr>
    </tbody>
  </table>-->
  <form method="post" id="mg_form" name="mg_form" enctype="multipart/form-data">
    <input type="hidden" name="form_submit" value="ok" />          
    <table class="table tb-type2">
        <thead>
<!--          <tr class="thead">
            <th colspan="5">装修类别：</th>
          </tr>-->
<!--          <tr class="thead">
            <th colspan="5"></th>
          </tr>-->
          <tr class="thead">
<!--            <th class="align-center">级别</th>-->
            <th class="align-left">风格</th>
          </tr>
        </thead>
        <tbody id="mg_tbody">
             <?php $category= $output['style'];  ?>
           <?php foreach ($category as $key => $value) { ?>
        	<tr id="row_<?php echo $key ?>">
        		
        		<td class="align-left">
                            <input type="checkbox" name="check_gc_id[]" value="<?php echo $value; ?>" class="checkitem">
                            －
                            <input type="text" name="style[]" value="<?php echo $value; ?>" class="w60" nc_type="verify" /></td>
        	</tr>
           <?php } ?>
        	<tr id="row">
        		
        		<td class="align-left">+<input type="text" name="style[]"  value="" class="w60" /></td>
        	</tr>
        </tbody>
        <tfoot>
        	<tr>
        		<td colspan="4"><a href="JavaScript:void(0);" class="btn" id="submitBtn"><span><?php echo $lang['nc_submit'];?></span></a></td>
        	</tr>
        </tfoot>
 	</table>
</form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script>
<script type="text/javascript">
$(function(){
	$('#submitBtn').click(function(){
		var result = true;
		var error = new Array();
		$("#mg_tbody").find("[nc_type='verify']").each(function(){
			if(result){
				data = $(this).val();
				if(!data){
					result = false;
					//error.push('请将信息填写完整');
					error = '请将信息填写完整';
				}
				//验证类型
				if(result){
					var data_str = $(this).attr('data-param');
				    if(data_str){
				    	eval( "data_str = "+data_str);
				    	switch(data_str.type){
				    	   case 'int':
				    		   result = (data = parseInt(data)) > 0?true:false;
				    		   error = (result == false)?(data_str.name + '应为整数'):'';
				    	}
				    }
				}				
			}
		});
		if(result){
			$('#mg_form').submit();
		} else {
			showDialog(error);
		}
    });
})
</script>

