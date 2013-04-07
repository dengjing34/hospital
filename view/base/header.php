<?php
//dengjing34@vip.qq.com
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?=$conf['title']?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="<?=$conf['keywords']?>" />
<meta name="description" content="<?=$conf['description']?>"/>
<link rel="stylesheet" media="screen" href="<?=Url::siteUrl('css/base.css')?>" />
<link rel="shortcut icon" href="<?=Url::siteUrl('images/favicon.ico');?>" />
<!--[if IE 6]>
<style type="text/css">
* html,* html body   /* IE6 Fixed Position Jitter Fix */{background-image:url(about:blank);background-attachment:fixed;}
* html .fixed-top    /* IE6 position fixed Top        */{position:absolute;bottom:auto;top:expression(eval(document.documentElement.scrollTop));}
* html .fixed-right  /* IE6 position fixed right      */{position:absolute;right:auto;left:expression(eval(document.documentElement.scrollLeft+document.documentElement.clientWidth-this.offsetWidth)-(parseInt(this.currentStyle.marginLeft,10)||0)-(parseInt(this.currentStyle.marginRight,10)||0));}
* html .fixed-bottom /* IE6 position fixed Bottom     */{position:absolute;bottom:auto;top:expression(eval(document.documentElement.scrollTop+document.documentElement.clientHeight-this.offsetHeight-(parseInt(this.currentStyle.marginTop,10)||0)-(parseInt(this.currentStyle.marginBottom,10)||0)));}
* html .fixed-left   /* IE6 position fixed Left       */{position:absolute;right:auto;left:expression(eval(document.documentElement.scrollLeft));}
</style>
<![endif]-->
<script type="text/javascript" src="<?=Url::siteUrl('js/jquery-1.5.2.min.js')?>"></script>
<script type="text/javascript" src="<?=Url::siteUrl('js/jquery.marquee.min.js')?>"></script>
<script type="text/javascript" src="<?=Url::siteUrl('js/main.js')?>"></script>
<script type="text/javascript">
var baseUrl = '<?=BASEURL?>';
$(function(){
    $(".marquee").marquee();
});
</script>
</head>
<body>

<div id="header" class="fixed-top fixed-left">
    <?=$navHtml?>
</div>
<div id="wrapper">
    <div id="container">
        <div id="banner">
            <div id="logo"></div>
            <div id="message">
                <ul class="marquee">
                    <li>信息文字:最新的手术视频已经上传到脑科手术中，欢迎观看。</li>
                    <li>Class aptent taciti sociosqu ad litora torquent per conubia nostra</li>
                    <li>Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Fusce tincidunt adipiscing,massa.</li>
                    <li>Mauris ullamcorper euismod leo. Nulla congue tellus vitae ante at pede eu ligula lacinia. Integer sed sapien, rutrum nec.</li>
                    <li>Aliquam erat volutpat. Fusce dolor. Vestibulum ornare congue turpis sollicitudin nunc elit. Nullam erat neque, facilisis quis.</li>
                    <li>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam non eros sed facilisis, bibendum eu.</li>
                </ul>
            </div>
        </div>
        <div id="filter">
            <ul>
                <?php
                $filers = array();
                foreach($filter as $filterName => $filterText) {
                    $className = $currentFilter == $filterName ? "{$filterName}-curr" : $filterName;
                    $filters[] = "<li><a title=\"{$filterText}\" class=\"{$className}\" href=\"" . Url::siteUrl("search/{$filterName}") . "\">{$filterText}</a></li>";
                }
                echo join("\n", $filters);
                ?>
            </ul>
        </div>
        <div id="main">