<?php 
session_start() ;
header("Content-type: text/html; charset=utf-8") ;

//项目目录设定
$ROOT_PATH = realpath(__DIR__).'/../' ;
define('ROOT_PATH', $ROOT_PATH) ;
//设定include_path
$includePaths = array(
		ROOT_PATH . '/library',
		ROOT_PATH . '/library/SimpleF/Core',
		ROOT_PATH . '/application/models',
		ROOT_PATH . '/application/controllers'
);
set_include_path(implode(PATH_SEPARATOR, $includePaths) . PATH_SEPARATOR . get_include_path());

//引入系统core文件
require 'Param.php' ; //Param系列方法
require 'Variable/Register.php' ; //注册变量方法
require 'Exception/Uri.php' ; //Uri异常处理类
require 'ErrorCode/Base.php' ; //ErrorCode

//获取配置文件 
$systemConfig = require '../config/config.php' ;
//获取ErrorCode配置文件
$errCodeConfig = require '../config/error_code.php' ;

SimpleF_Core_Variable_Register::set('systemConfig', $systemConfig) ;
SimpleF_Core_Variable_Register::set('errCodeConfig', $errCodeConfig) ;


//设置error_reporting
error_reporting($systemConfig['error_reporting']) ;
//设置时区
date_default_timezone_set ( $systemConfig['timezone'] ) ;
//注册常用变量
SimpleF_Core_Variable_Register::setServerVariable() ; //设定Server变量
//设置HOST
$HOST = $systemConfig['HOST'] ;

//获取项目名称
$list = explode('/', $ROOT_PATH) ;//寻找位置
$listNum = count($list) ;
$PROJECT_NAME = $list[$listNum-1] ;//删除后面
define('APPLICATION_PATH', ROOT_PATH.'/application') ;
define('HOST_PATH', $HOST.'/'.$PROJECT_NAME) ; //项目访问根目录

//Smarty
require_once 'Smarty/libs/Smarty.class.php';
$smarty = new Smarty ( );
$smarty->template_dir = ROOT_PATH . '/' . $systemConfig['smarty']['template_dir'] ;
$smarty->compile_dir = ROOT_PATH . '/' . $systemConfig['smarty']['compile_dir'] ;
$smarty->config_dir = ROOT_PATH . '/' . $systemConfig['smarty']['config_dir'] ;
$smarty->cache_dir = ROOT_PATH . '/' . $systemConfig['smarty']['cache_dir'] ;
// $smarty->force_compile = true;
//$smarty->caching = true;
$smarty->cache_lifetime = 1800 ;
//Smarty全局变量
$smarty->assign('HOST_PATH', HOST_PATH) ;


//设定全局变量
$GLOBALS['smarty'] = $smarty ;

try{
	//获取 dir,controller,action参数
	if($GLOBALS['systemConfig']['url_route_mode']==1){
		$dirParam = getParam('d') ;
		$conParam = getParam('c') ;
		$actionParam = getParam('a')?getParam('a'):'index' ;
	}elseif($GLOBALS['systemConfig']['url_route_mode']==2){
		$uriParams = explode('/', substr(SimpleF_Core_Variable_Register::get('request_uri'), 1) ) ;
		$dirParam = $uriParams[0] ;
		$conParam = $uriParams[1] ;
		$actionParam = $uriParams[2]?$uriParams[2]:'index' ;
	}
}catch (SimpleF_Core_Exception_Uri $e){
	echo "Catch Uri Exception:".$e->getErrData() ;
	exit ;
}
//将dir和Controller的首字母转换为大写，方便读取文件
$ucConParam = ucfirst($conParam) ;
$ucDirParam = ucfirst($dirParam) ;

// GET All Params Include GET and POST, $GLOBALS
$params = getAllParams() ;


$filePath = APPLICATION_PATH.'/controller/'.$dirParam.'/'.$ucConParam.'.php' ;
try{
	if($ucDirParam && !is_file($filePath)){
		throw new SimpleF_Core_Exception_Uri(SimpleF_Core_ErrorCode_Base::getErrorMsgByCode(100001), 100001) ;
	}else{
		if($ucDirParam){
			try{
				//Require Controller File
				require $filePath ;
				//Exec Actions
				$className = $ucDirParam.'_'.$ucConParam ;
				$actionName = $actionParam.'Action' ;
			
				$class = new $className ;
				if(method_exists($className, $actionName)){
					//dispatch
					$class->$actionName() ;
				}else{
					throw new SimpleF_Core_Exception_Uri(SimpleF_Core_ErrorCode_Base::getErrorMsgByCode(100002), 100002) ;
				}
			}catch (Exception $e){
				echo "Catch Exception:".$e->getMessage() ;
				exit ;
			}
		}else{
			//跳转到默认首页
			$defaultUri = SimpleF_Core_Variable_Register::get('systemConfig')['default_uri'] ;
			if(isset($defaultUri)){
				header('Location:'.HOST_PATH.$defaultUri) ;
			}else{
				throw new SimpleF_Core_Exception_Uri(SimpleF_Core_ErrorCode_Base::getErrorMsgByCode(100003), 100003) ;
			}
			
		}
		
		
	}
}catch(SimpleF_Core_Exception_Uri $e){
	echo 'Catch Uri Exception: '.$e->getErrData() ;
	exit ;
}

?>