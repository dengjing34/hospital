<?php
//dengjing34@vip.qq.com 545 410
/*@var $currVideo Video*/
/*@var $o Operations*/
$width = Video::PLAYER_WIDTH;
$height = Video::PLAYER_HEIGHT;
?>

<h2><?php echo $o->optName . ' &gt; ' . $currVideo->videoTitle?>
</h2>
<div style="float:left;">
    <div id="player-wrapper" style="width:<?php echo $width;?>px;height:<?php echo $height;?>px;">没有视频</div>
    <div style="position:relative;">
        <div>
        <?php
        if ($fav) {
            echo <<<EOT
<a href="#" class="btn-big borrow" onclick="return _global_.favCancel({$user['id']}, {$o->optGUID}, $(this));">已借阅</a> 
EOT;
    } else {
        echo <<<EOT
<a href="#" class="btn-big favor" onclick="return _global_.favAdd({$user['id']}, {$o->optGUID}, $(this));">收藏</a> 
EOT;
        }
        $currentDownloadUrl = Url::siteUrl("download?id={$currVideo->videoGUID}");
        $currentDeleteUrl = Url::siteUrl("delete_video?id={$currVideo->videoGUID}");
        echo <<<EOT
<a class="btn-big download" href="{$currentDownloadUrl}">下载</a> 
<a class="btn-big delete" href="{$currentDeleteUrl}" onclick="return confirm('确定要删除该视频？')">删除</a> 
<a class="btn-big update" href="">更新</a> 
EOT;
        ?>
        </div>        
        <?php
        echo <<<EOT
<p style="width:{$width}px;">
    医生：{$o->optDocName} 麻醉师：{$o->optMazuiName} 助手医生：{$o->optAssDocName} 护士：{$o->optNurseName}<br />
    手术日期：{$o->getDate()} 麻醉方式：{$o->optMazuiName}<br />
    大小：{$currVideo->getFileSize()} 时长：{$currVideo->getPlayLen()} 开始：{$currVideo->getBeginTM()} 结束：{$currVideo->getEndTM()}
</p>
EOT;
        ?>
    </div>
</div>

<div class="video-list">
<?php
/*@var $eachVideo Video*/
foreach ($videos as $eachVideo) {
    if ($eachVideo->videoGUID == $currVideo->videoGUID) continue;
    $videoLink = Url::siteUrl("view?id={$o->optGUID}&vid={$eachVideo->videoGUID}");
    $deleteUrl = Url::siteUrl("delete_video?id={$eachVideo->videoGUID}");
    $picError = Url::siteUrl('images/new/ny_main_sp_1.jpg');
    $downloadUrl = Url::siteUrl("download?id={$eachVideo->videoGUID}");
    echo <<<EOT
<dl>
    <dt><a href="{$videoLink}"><img src="{$eachVideo->getPreview()->getPicUrl()}"} onerror="this.src='{$picError}'" /></a></dt>
    <dd>标题：{$eachVideo->videoTitle}</dd>
    <dd>大小：{$eachVideo->getFileSize()}</dd>
    <dd>时长：{$eachVideo->getPlayLen()}</dd>
    <dd>开始：{$eachVideo->getBeginTM()}</dd>
    <dd>结束：{$eachVideo->getEndTM()}</dd>
</dl>
<p>
    <a class="btn-big preview" href="{$videoLink}">预览</a>
    <a class="btn-big download" href="{$downloadUrl}">下载</a>
    <a class="btn-big delete" href="{$deleteUrl}" onclick="return confirm('确定要删除该视频？')">删除</a>
    <a class="btn-big update" href="">更新</a>
</p>
EOT;
}
?>
</div>
<?php
if ($currVideo->videoGUID) {
    echo $currVideo->playerScript();
}
?>