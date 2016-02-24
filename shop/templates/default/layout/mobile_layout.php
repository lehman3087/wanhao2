<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta name="format-detection" content="telephone=no">
        <title>FrozenUI Demo</title>
        <script type="text/javascript" src="http://tajs.qq.com/stats?sId=37342703" charset="UTF-8"></script>
        <link rel="stylesheet" href="<?php echo RESOURCE_SITE_URL;?>/lib/frozen/css/frozen.css">
        <link rel="stylesheet" href="<?php echo RESOURCE_SITE_URL;?>/lib/frozen/css/demo.css">
        <script src="<?php echo RESOURCE_SITE_URL;?>/lib/zepto.min.js"></script>
        <script src="<?php echo RESOURCE_SITE_URL;?>/js/frozen/frozen.js"></script>
    </head>
    
    <body ontouchstart>
        <header class="ui-header ui-header-positive ui-border-b" style="display: none">
            <i class="ui-icon-return" onclick="history.back()"></i><h1>文本 type</h1><button class="ui-btn">回首页</button>
        </header>
        <footer class="ui-footer ui-footer-btn"  style="display: none">
            <ul class="ui-tiled ui-border-t">
                <li data-href="index.html" class="ui-border-r"><div>基础样式</div></li>
                <li data-href="ui.html" class="ui-border-r"><div>UI组件</div></li>
                <li data-href="js.html"><div>JS插件</div></li>
            </ul>
        </footer>
        <section class="ui-container">


             <?php require_once($tpl_file); ?>




        </section><!-- /.ui-container-->
        <script>
        $('.ui-list li,.ui-tiled li').click(function(){
            if($(this).data('href')){
                location.href= $(this).data('href');
            }
        });
        $('.ui-header .ui-btn').click(function(){
            location.href= 'index.html';
        });
        </script>
    </body>
</html>