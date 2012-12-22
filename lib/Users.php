<?php
//dengjing34@vip.com
class Users extends User{
    public $status = self::STATUS_ACTIVE;//只要正常状态的用户
    public static $defaultWhereAnd = array('role', "<> 'sa'");
    
    public function find($options = array()) {
        if (isset($options['whereAnd'])) $options['whereAnd'][] = self::$defaultWhereAnd;
        else $options['whereAnd'][] = self::$defaultWhereAnd;
        return parent::find($options);
    }
    
    public function count($options = array()) {
        if (isset($options['whereAnd'])) $options['whereAnd'][] = self::$defaultWhereAnd;
        else $options['whereAnd'][] = self::$defaultWhereAnd;        
        return parent::count($options);
    }
}

?>
