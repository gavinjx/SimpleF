<?php 
/**
 * 处理变量的注册类，替代原始的GLOABLES变量
 * 
 */
class SimpleF_Core_Variable_Register
{
	/**
	 * 设定Server变量
	 */
	public static function setServerVariable()
	{
		self::set('request_uri', $_SERVER['REQUEST_URI']) ;
	}

	public static function get($key)
	{
		return $GLOBALS[$key] ;
	}

	public static function set($key, $value)
	{
		$GLOBALS[$key] = $value ;
	}
}