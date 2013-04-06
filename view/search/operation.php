<?php
//dengjing34@vip.qq.com
?>
<form>
    <label>手术名字：<input type="search" name="optName" value="<?php echo $optName;?>"/></label> <button type="submit">搜索</button>
</form>
<table class="grid">
    <tr class="trTitle">
        <td>ID</td>
        <td>手术名称</td>
        <td>主刀医生</td>
        <td>麻醉师</td>
        <td>助手医生</td>
        <td>护士</td>
        <td>麻醉方式</td>
        <td>诊断</td>
        <td>日期</td>
    </tr>
    <?php
    /*@var $o Operations*/
    foreach ($operations as $o) {
        $link = Url::siteUrl("view?id={$o->optGUID}");
        echo <<<EOT
<tr>
    <td>{$o->optGUID}</td>
    <td><a href="{$link}">{$o->optName}</a></td>
    <td>{$o->optDocName}</td>
    <td>{$o->optMazuishi}</td>
    <td>{$o->optAssDocName}</td>
    <td>{$o->optNurseName}</td>
    <td>{$o->optMazuiName}</td>
    <td>{$o->optZDName}</td>
    <td>{$o->getDate()}</td>
</tr>
EOT;
    }
    ?>
</table>
<div class="pager"><?=$pager?></div>