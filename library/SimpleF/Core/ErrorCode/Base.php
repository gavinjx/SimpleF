<?php 
/**
 * 错误码配置类
 */
class SimpleF_Core_ErrorCode_Base
{
	public static function getErrorMsgByCode($code)
	{
		$errCodeConfig = SimpleF_Core_Variable_Register::get('errCodeConfig') ;
		return $errCodeConfig[$code] ;
	}
}