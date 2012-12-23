<?php
//dengjing34@vip.qq.com
?>

<div class="book-two">
    <?php
    $html = array();
    foreach ($oo as $o) {        
        $html[] = '<dl>';
        $html[] = "<dt><a href=\"" . Url::siteUrl("view?id={$o->id}") . "\"><img src=\"" . Url::siteUrl('images/new/ny_main_sp_1.jpg') . "\" /></a></dt>";
        $html[] = "<dd><span>医生名称：</span>{$o->mainDoctor}</dd>";
        $html[] = "<dd><span>患者名称：</span>{$o->mainDoctor}</dd>";
        $html[] = "<dd><span>日期：</span>{$o->getDate()}</dd>";
        $html[] = "<dd><span>病例名称：</span>{$o->name}</dd>";
        $html[] = "</dl>";
    }
    echo implode("\n", $html);
    ?>
    <div class="pager"><?=$pager?></div>
</div>
