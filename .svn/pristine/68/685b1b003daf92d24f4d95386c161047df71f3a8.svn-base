

<style>
    .ui-col{
        background: none;
        border:none;
    }
    .ui-col i{
        display:inline-block;
    }
    .demo-desc label{
        border:none;
        background-color:Red;
    }
</style>
<script>var RESOURCE_SITE_URL="<?php echo RESOURCE_SITE_URL;?>";</script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.charCount.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.charCount.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/member.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/sns.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/sns_store.js" charset="utf-8"></script>

<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.caretInsert.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.ajaxContent.pack.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.validation.min.js"></script>
<section id="slider">

    <div class="demo-item">
        <p class="demo-title"><?php echo $output['strace_info']['strace_title'];?></p>
        
        <p class="ui-txt-muted" style="padding-left: 10px"><?php echo date('Y-m-d H:i',$output['strace_info']['strace_time']);?></p>
        <div class="demo-block">
            <div class="ui-slider">
                <ul class="ui-slider-content" style="width: 300%">
                    <li><span style="background-image:url(http://placeholder.qiniudn.com/640x200)"></span></li>
                </ul>
            </div>
            
            <div class="demo-block">
                
            <ul class="ui-row">

                <li class="ui-col ui-col-10"></li>
                <li class="ui-col ui-col-10">
                    <i class="ui-icon-like"></i>
                    <?php echo $output['strace_info']['strace_cool'];?>

                </li>
                <li class="ui-col ui-col-10">
                    <i class="ui-icon-comment"></i>
                    <?php echo $output['strace_info']['strace_comment'];?>
                </li>
                <li class="ui-col ui-col-10">
                    <i class="ui-icon-search"></i>
                    <?php echo $output['strace_info']['strace_click'];?>
                </li>
                <li class="ui-col ui-col-10"></li>
                <li class="ui-col ui-col-50"><button class="pinglun ui-btn">评论</button></li>
            </ul>
        </div>
            
            
            <p class="demo-desc" style="margin-left:-25px;color: #ffffff"><label class="ui-label">全部评论</label></p>
        <div class="demo-block "> 
            
               

                
       
            
<div class="comment-widget">
    <div class="comment-edit" style="display:none;">
        
        <section class="ui-input-wrap ui-border-t">
                <div class="ui-input ui-border-radius">
                     <form id="commentform_<?php echo $output['stid'];?>" method="post" action="index.php?act=store_snshome&op=addcomment">
                         <input type="hidden" name="stid" value="<?php echo $output['stid'];?>" />
                            <input type="hidden" name="showtype" value="<?php echo $output['showtype'];?>" />
                         <input type="text" name="" value="" id="content_comment<?php echo $output['stid'];?>" name="commentcontent" placeholder="我也说一句...">
                     </form>
                </div>
                <button class="ui-btn"><a href="javascript:void(0);" nc_type="scommentbtn" data-param='{"txtid":"<?php echo $output['stid'];?>"}'><?php echo $lang['sns_comment'];?></a></button>
                <button class="ui-btn"><a class="face" nc_type="smiliesbtn" data-param='{"txtid":"comment<?php echo $output['stid'];?>"}' href="javascript:void(0);" ><?php echo $lang['sns_smiles'];?></a></button>
            </section>
        
        
        

      <div class="comment-add">
        <span class="error"></span> 
        <!-- 验证码 -->
        <div id="commentseccode<?php echo $output['stid'];?>" class="seccode">
          <label for="captcha"><?php echo $lang['nc_checkcode'].$lang['nc_colon'];?></label>
          <input name="captcha" class="text" type="text" size="4" maxlength="4"/>
          <img src="" title="<?php echo $lang['wrong_checkcode_change'];?>" name="codeimage" onclick="this.src='index.php?act=seccode&op=makecode&nchash=<?php echo $output['nchash'];?>&t=' + Math.random()"/> <span><?php echo $lang['wrong_seccode'];?></span>
          <input type="hidden" name="nchash" value="<?php echo $output['nchash'];?>"/>
        </div>
        <input type="text" style="display:none;" />
        <!-- 防止点击Enter键提交 -->
        <div class="act"> 
            <span class="skin-blue">
                <span class="btn">
                    <a href="javascript:void(0);" nc_type="scommentbtn" data-param='{"txtid":"<?php echo $output['stid'];?>"}'><?php echo $lang['sns_comment'];?></a>
                </span>
            </span> 
            <span id="commentcharcount<?php echo $output['stid'];?>" style="float:right;"></span> 
<!--            <a class="face" nc_type="smiliesbtn" data-param='{"txtid":"comment<?php echo $output['stid'];?>"}' href="javascript:void(0);" ><?php echo $lang['sns_smiles'];?></a>-->
        </div>
      </div>
  </div>
    
    
  <div class="clear"></div>
  
  <?php if (count($output['commentlist'])>0){ ?>
   <ul class="ui-list ui-border-tb ui-whitespace">
<!--    <ul class="comment-list">-->
    <?php if(is_array($output['commentlist'])){?>
    <?php foreach ($output['commentlist'] as $k=>$v){?>
<li class="ui-border-t" nc_type="commentrow_<?php echo $v['scomm_id']; ?>"> 
    <div class="ui-avatar">
        <span style="background-image:url(<?php if ($v['scomm_memberavatar']!='') { echo UPLOAD_SITE_URL.'/'.ATTACH_AVATAR.DS.$v['scomm_memberavatar']; } else {  echo UPLOAD_SITE_URL.'/'.ATTACH_COMMON.DS.C('default_user_portrait'); } ?>)"></span>
    </div>
    <div class="detail ui-list-info">
        <h4 class="ui-nowrap"><?php echo $v['scomm_membername'];?></h4>
                        <p class="ui-nowrap"><?php echo @date('Y-m-d H:i',$v['scomm_time']);?> - <?php echo $output['countnum']-$k;?>&nbsp;<?php echo $lang['sns_comment_floor'];?></p>
                        <p class="ui-nowrap"><?php echo $lang['nc_colon']; ?><?php echo parsesmiles($v['scomm_content']);?></p>
    </div>
    </li>
    <?php }?>
    <?php }?>
  </ul>
  <?php if ($output['showtype']==1 && $output['showmore'] == '1'){//展示更多连接?>
  <div class="more"><a target="_blank" href="index.php?act=store_snshome&op=straceinfo&st_id=<?php echo $output['stid'];?>">更多</a></div>
  <?php } elseif (!$output['showtype']){//展示分页?>
  <div class="pagination"><?php echo $output['show_page']; ?></div>
  <?php } ?>
  <?php } ?>
  <div style="clear:both;"></div>
</div>
            
            
            
        
        </div>

            
        </div>
        <script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/smilies/smilies_data.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/smilies/smilies.js" charset="utf-8"></script>


        
        
        
        <script class="demo-script">
        (function (){
            var slider = new fz.Scroll('.ui-slider', {
                role: 'slider',
                indicator: true,
                autoplay: true,
                interval: 3000
            });

            slider.on('beforeScrollStart', function(fromIndex, toIndex) {
                console.log(fromIndex,toIndex)
            });

            slider.on('scrollEnd', function(cruPage) {
                console.log(cruPage)
            });
        })();
        </script>
    </div>
</section>








<script type="text/javascript">
var MAX_RECORDNUM = <?php echo $output['max_recordnum'];?>;
$(function(){
    
            $('.pinglun').click(function(){
            $('.comment-edit').toggle();
            })
        
	$('#commentform_<?php echo $output['stid'];?>').validate({
		errorPlacement: function(error, element){
			element.next('.error').append(error);
	    },      
	    rules : {
	    	commentcontent : {
	            required : true,
	            maxlength : 140
	        }
	    },
	    messages : {
	    	commentcontent : {
	            required : '<?php echo $lang['sns_comment_null'];?>',
	            maxlength: '<?php echo $lang['sns_content_beyond'];?>'
	        }
	    }
	});
	<?php if (!$output['showtype']==1){?>
	//分页绑定异步加载事件
	$('#tracereply_<?php echo $output['stid'];?>').find('.demo').ajaxContent({
		event:'click',
		loaderType:"img",
		loadingMsg:"<?php echo SHOP_TEMPLATES_URL;?>/images/transparent.gif",
		target:'#tracereply_<?php echo $output['stid'];?>'
	});
	<?php }?>
	//评论字符个数动态计算
	$("#content_comment<?php echo $output['stid'];?>").charCount({
		allowed: 140,
		warning: 10,
		counterContainerID:'commentcharcount<?php echo $output['stid'];?>',
		firstCounterText:'<?php echo $lang['sns_charcount_tip1'];?>',
		endCounterText:'<?php echo $lang['sns_charcount_tip2'];?>',
		errorCounterText:'<?php echo $lang['sns_charcount_tip3'];?>'
	});
});
</script>




