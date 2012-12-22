<?php
//dengjing34@vip.qq.com
?>
<div class="listing-4">
    <?php
    $html = array();
    $i = 1;
    foreach ($users as $user) {
        $detailUrl = Url::siteUrl("doctor?id={$user->id}");
        $html[] = '<dl><dt>';
        $html[] = "<a title=\"{$user->alias}\" href=\"{$detailUrl}\">{$user->getAvatarImage()}</a></dt>";
        $html[] = "<dd><span>医生名称：</span>{$user->alias}</dd>";
        $html[] = "<dd><span>职称：</span>{$user->getJob()}</dd>";
        $html[] = "<dd><span>科室：</span>{$user->getDept()}</dd>";
        $html[] = '</dl>';
        if ($i % 4 == 0 && $i > 1) $html[] = '<div class="line"></div>';
        $i++;        
    }
    echo join("\n", $html);
    ?>    
</div>
<div class="pager"><?=$pager?></div>