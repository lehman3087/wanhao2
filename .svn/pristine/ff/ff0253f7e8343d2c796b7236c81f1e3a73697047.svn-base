<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="page">
  <form method="post" name="form1" id="form1" action="<?php echo urlAdmin('decoration', 'dw_verify');?>">
    <input type="hidden" name="form_submit" value="ok" />
    <input type="hidden" value="<?php echo $output["commonids"];?>" name="commonids">
    <table class="table tb-type2 nobdb">
      <tbody>
          <tr>
              <td colspan="1" class="required"><label>标题:</label><?php echo $output['bid']['bid_title']; ?></td>
              
          </tr>
          <tr>
              <td colspan="1" class="required"><label>创建时间:</label><?php echo @date('Y-m-d',$output['bid']['bid_addtime']);?></td>
              <td colspan="1" class="required"><label>更新时间:</label><?php echo @date('Y-m-d',$output['bid']['bid_lastuptime']);?></td>
          </tr>
          <tr>
              <td colspan="2" class="required"><label>陈述:</label><?php echo $output['bid']['bid_highlight']; ?></td>
          </tr>
          <tr>
              <td colspan="2" class="required"><label>效果图:</label></td>
          </tr>
        <tr class="noborder">
          <td colspan="2" class="required">
              <?php 
              
             $bidcontents = $output['bid']['bid_content'];
             foreach ($bidcontents as $value) {
                 //var_dump($value);
                 if($value['type']=='image'){
                        //var_dump($value['value']);
                        echo "<img  src='".$value['value']."' /></br>";
                    }else if($value['type']=='text'){
                        echo $value['value']."</br><hr>";
                    }
             }
              
              ?>
              
          
          </td>
        </tr>

        <tr nctype="reason" style="display: none;">
          <td colspan="2" class="required"><label for="verify_reason">未通过理由:</label></td>
        </tr>
        <tr class="noborder" nctype="reason" style="display :none;">
          <td class="vatop rowform"><textarea rows="6" class="tarea" cols="60" name="verify_reason" id="verify_reason"></textarea></td>
        </tr>
      </tbody>
      <tfoot>

      </tfoot>
    </table>
  </form>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/admincp.js" charset="utf-8"></script>
<script>
$(function(){
    $('a[nctype="btn_submit"]').click(function(){
        ajaxpost('form1', '', '', 'onerror');
    });
    $('input[name="verify_state"]').click(function(){
        if ($(this).val() == 1) {
            $('tr[nctype="reason"]').hide();
        } else {
            $('tr[nctype="reason"]').show();
        }
    });
});


</script>