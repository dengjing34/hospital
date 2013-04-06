<?php
//dengjing34@vip.qq.com
?>
<form>
    <label>病人名字：<input type="search" name="patName" value="<?php echo $patName;?>"/></label> <button type="submit">搜索</button>
</form>
<table class="grid">
    <tr class="trTitle">
        <td>ID</td>
        <td>姓名</td>
        <td>手术</td>
        <td>医生</td>
        <td>年龄</td>
        <td>性别</td>
        <td>住院卡号</td>
        <td>病区</td>
        <td>床号</td>
        <td>时间</td>
    </tr>
    <?php
    /*@var $patient Patient*/
    foreach ($patients as $patient) {
        /*@var $operation Operations*/
        $operation = isset($operations[$patient->optGUID]) ? $operations[$patient->optGUID] : new Operations();
        $link = Url::siteUrl("view?id={$patient->optGUID}");
        echo <<<EOT
<tr>
    <td>{$patient->patGUID}</td>
    <td>{$patient->patName}</td>
    <td><a href="{$link}">{$operation->optName}</a></td>
    <td>{$operation->optDocName}</td>
    <td>{$patient->patAge}</td>
    <td>{$patient->getSex()}</td>
    <td>{$patient->patCardNum}</td>
    <td>{$patient->patWard}</td>
    <td>{$patient->patBedNum}</td>
    <td>{$operation->getDate()}</td>
</tr>
EOT;
    }
    ?>
</table>
<div class="pager"><?=$pager?></div>


