<?php
//dengjing34@vip.qq.com
class Analytics {
    public static $host = "www.ridunshe.com";
    public static function code() {        
        $code = array();
        if (isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] == self::$host) {
            $code[] = self::baidu();
        }
        return implode("\n", $code);
    }
    
    private static function baidu() {
        $code = array();
        $code[] = '<script type="text/javascript">';
        $code[] = 'var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");';
        $code[] = "document.write(unescape(\"%3Cscript src='\" + _bdhmProtocol + \"hm.baidu.com/h.js%3F1aecc92a10428af744c35564428154f7' type='text/javascript'%3E%3C/script%3E\"));";
        $code[] = '</script>';
        return implode("\n", $code);
    }
}

?>
