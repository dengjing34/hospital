<?php
//dengjing34@vip.qq.com
?>
<link rel="stylesheet" media="screen" href="<?=Url::siteUrl('css/plugin.stip.css')?>" />
<script type="text/javascript" src="<?=Url::siteUrl('js/plugin.sValidate.js')?>"></script>
<script type="text/javascript">
$(function(){
    Stip.config.p = 'bottom';
    $('#loginForm').submit(function(){
        return sValidation({
            <?=$validScripts?> 
        });
    });
});
</script>
    <div id="nav">
        <div id="nav-inner">
            <form id="loginForm" method="post" action="<?=Url::siteUrl()?>">
            <ul>
                <li><label for="userName">用户名：<label><input type="text" name="userName" size="14" id="userName" /></li>
                <li><label for="password">密码：</label><input type="password" name="password" size="14" id="password" /></li>
                <li><button type="submit">登录</button><li>
            </ul>
            </form>    
            <div class="clear"></div>
        </div>
    </div>
