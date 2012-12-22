<?php
//dengjing34@vip.qq.com
class DataConnection {

	private static $connection = null;
    
	public static function getConnection() {
		if (self::$connection == null) {                            
            $mysqlConfig = Config::item('mysql.master');
			self::$connection = mysql_connect($mysqlConfig['host'], $mysqlConfig['user'], $mysqlConfig['password']) or die(mysql_error());
			mysql_select_db($mysqlConfig['db']) or die(mysql_error());
			mysql_query('set names utf8') or die(mysql_error());
		}
		return self::$connection;
	}

}
?>
