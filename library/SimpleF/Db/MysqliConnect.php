<?php
require 'IConnectInfo.php' ;

class SimpleF_Db_MysqliConnect implements SimpleF_Db_IConnectInfo
{
	
	private static $_host = SimpleF_Db_IConnectInfo::HOST ;
	private static $_name = SimpleF_Db_IConnectInfo::NAME ;
	private static $_passwd = SimpleF_Db_IConnectInfo::PASSWD ;
	private static $_database = SimpleF_Db_IConnectInfo::DATABASE ;
	private static $_port = SimpleF_Db_IConnectInfo::PORT ;
	private static $_charset = SimpleF_Db_IConnectInfo::CHARSET ;
	private static $_hookup ;

	public funtion doConnect()
	{
		self::$_hookup = mysqli_connect(self::$_host, self::$_name, self::$_passwd, self::$_database, self::$_port) ;
		if(self::$_hookup){
			// echo 'Connect Sucess  ' ;
		}elseif(mysqli_connect_error(self::$_hookup)){
			echo 'Connect Error:'.mysqli_connect_error() ;
		}
		return self::$_hookup ;
	}
}