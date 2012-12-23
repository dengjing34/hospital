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
            <dd><span>已有案例：</span>视频<?=$o->operationCount()?>个<br /><br />文档0个</dd>
        </dl>
        <div class="bottom-pt"><?=$o->description?></div>
    </div>
    <div class="right-page">
        <?php
        $html = array();
        foreach ($operations as $operation) {        
            $html[] = '<dl>';
            $html[] = "<dt><a href=\"" . Url::siteUrl("view?id={$o->id}") . "\"><img src=\"" . Url::siteUrl('images/new/ny_main_sp_1.jpg') . "\" /></a></dt>";
            $html[] = "<dd><span>医生名称：</span>{$operation->mainDoctor}</dd>";
            $html[] = "<dd><span>患者名称：</span>{$operation->mainDoctor}</dd>";
            $html[] = "<dd><span>日期：</span>{$operation->getDate()}</dd>";
            $html[] = "<dd><span>病例名称：</span>{$operation->name}</dd>";
            $html[] = "</dl>";
        }
        echo implode("\n", $html);
        ?>        
    </div>
    <div class="clear"></div>
</div>
