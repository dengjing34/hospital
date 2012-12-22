<?php
//dengjing34@vip.qq.com
?>

<div class="book">
    <div class="left-page">
        <dl class="top-pt">
            <dt><?=$o->getAvatarImage()?></dt>
            <dd><span>医生名称：</span><?=$o->alias?></dd>
            <dd><span>职称：</span><?=$o->getJob()?></dd>
            <dd><span>科室：</span><?=$o->getDept()?></dd>
            <dd><span>已有案例：</span></dd>
        </dl>
        <div class="bottom-pt"><?=$o->description?></div>
    </div>
    <div class="right-page"></div>
    <div class="clear"></div>
</div>
