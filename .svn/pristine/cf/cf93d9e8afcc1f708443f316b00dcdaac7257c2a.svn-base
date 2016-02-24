<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="explain"><i></i><?php echo $output['joinin_message'];?></div>
<?php if (is_array($output['joinin_detail']) && !empty($output['joinin_detail'])) { ?>
<table border="0" cellpadding="0" cellspacing="0" class="all">
  <tbody>
    <tr>
      <th>付款清单列表</th>
      <td></td>
    </tr>
    <tr>
      <td colspan="2"><table  border="0" cellpadding="0" cellspacing="0" class="type">
          <tbody>
           
            <tr>
              <td class="w80">店铺分类：</td>
              <td class="tl">装修公司</td>
              <td class="w80">开店保证金：</td>
              <td class="tl"><?php echo $output['joinin_detail']['sc_bail'];?> 元</td>
            </tr>
            <tr>
              <td>应付金额：</td>
              <td class="tl" colspan="3"><?php echo $output['joinin_detail']['paying_amount'];?> 元</td>
            </tr>
          </tbody>
        </table></td>
    </tr>
   
  </tbody>
  <tfoot>
    <tr>
      <td colspan="20">&nbsp;</td>
    </tr>
  </tfoot>
</table>
<?php } ?>
<div class="bottom">
  <?php if($output['btn_next']) { ?>
  <a id="" href="<?php echo $output['btn_next'];?>" class="btn">下一步</a>
  <?php } ?>
</div>
