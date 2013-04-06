<?php
//dengjing34@vip.qq.com 545 410
/*@var $currVideo Video*/
/*@var $o Operations*/
?>

<h2><?php echo $o->optName . ' &gt; ' . $currVideo->videoTitle?></h2>
<div style="float:left;">
    <div id="player-wrapper" style="width:545px;height:410px;">没有视频</div>
    <div>
        <?php
        echo <<<EOT
<p style="width:545px;">
    医生：{$o->optDocName} 麻醉师：{$o->optMazuiName} 助手医生：{$o->optAssDocName} 护士：{$o->optNurseName}<br />
    手术日期：{$o->getDate()} 麻醉方式：{$o->optMazuiName}
</p>
EOT;
        ?>
    </div>
</div>

<div style="background:#cce8de;width:260px;height:410px;float:right;">

</div>
<?php
if ($currVideo->videoGUID) {
    echo $currVideo->playerScript();
}
?>