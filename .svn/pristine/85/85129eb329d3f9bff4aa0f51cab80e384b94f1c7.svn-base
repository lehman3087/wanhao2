<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <div class="fixed-bar">
    <div class="item-title">
      <h3>其他设置</h3>
      <?php echo $output['top_link'];?>
<!--      <ul class="tab-base">
        <li><a href="JavaScript:void(0);" class="current"><span>级别管理</span></a></li>
      </ul>-->
    </div>
  </div>
  <div class="fixed-empty"></div>
  <table class="table tb-type2" id="prompt">
    <tbody>
      <tr class="space odd">
        <th colspan="12"><div class="title"><h5><?php echo $lang['nc_prompts'];?></h5><span class="arrow"></span></div></th>
      </tr>
      <tr>
        <td>
        <ul>
        	<li class="tips">设置建议：设置0代表不限制</li>
          
          </ul></td>
      </tr>
    </tbody>
  </table>
  <form method="post" id="mg_form" name="mg_form" enctype="multipart/form-data">
    <input type="hidden" name="form_submit" value="ok" />          
    <table class="table tb-type2">
        <tbody id="mg_tbody">

        	<tr id="row_1">
        		<td class="w150 align-center">单标最多允许参与公司数</td>
        		<td class="align-left"><input type="text" name="decoration_bid_count" value="<?php echo $output['list_setting']['decoration_bid_count'];?>" class="w60" nc_type="verify" data-param='{"name":"最多允许竞标公司","type":"int"}'/></td>
        	</tr>
                
                <tr id="row_2">
        		<td class="w150 align-center">装修公司最多允许竞标数</td>
        		<td class="align-left"><input type="text" name="decoration_dc_bid_issue" value="<?php echo $output['list_setting']['decoration_dc_bid_issue'];?>" class="w60" nc_type="verify" data-param='{"name":"最多允许竞标公司","type":"int"}'/></td>
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