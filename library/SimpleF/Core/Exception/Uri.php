<?php 
class SimpleF_Core_Exception_Uri extends Exception
{
	public function __construct($message, $code = 0) {
	    parent::__construct($message, $code);
	}
	/**
	 * 获取异常Code和异常信息
	 * @return string
	 */
	public function getErrData()
	{
	    $errCode = $this->getCode() ;
	    $errMsg = $this->getMessage() ;
	    return 'ErrCode:'.$errCode.', ErrMsg:'.$errMsg ;
	}
}