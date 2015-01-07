<?php
/**
 * 数据库操作类接口；可向下实现mysqli，pdo_mysql等一系列数据库操作
 */
interface SimpleF_Db_IConnectInfo
{
	const HOST = 'localhost' ;
	const NAME = 'root' ;
	const PASSWD = '' ;
	const DATABASE = 'test' ;
	const PORT = '3306' ;
	const CHARSET = 'utf8' ;

	/**
	 * 数据库链接函数
	 * @return [type] [description]
	 */
	public function doConnect() ;

}