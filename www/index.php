<?php 
session_start() ;
header("Content-type: text/html; charset=utf-8") ;

//获取配置文件 
$systemConfig = require '../config/config.php' ;

//设置error_reporting
error_reporting($systemConfig['error_reporting']) ;

//设置时区
date_default_timezone_set ( $systemConfig['timezone'] ) ;



$HOST = $systemConfig['HOST'] ;

//项目目录设定
$ROOT_PATH = realpath(__DIR__).'/../' ;

//获取项目名称
$list = explode('/', $ROOT_PATH) ;//寻找位置
$listNum = count($list) ;
$PROJECT_NAME = $list[$listNum-1] ;//删除后面

define('ROOT_PATH', $ROOT_PATH) ;
define('APPLICATION_PATH', ROOT_PATH.'/application') ;
define('HOST_PATH', $HOST.'/'.$PROJECT_NAME) ; //项目访问根目录


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
$GLOBALS['systemConfig'] = $systemConfig ;


//获取 dir,controller,action参数
$dirParam = getParam('d') ;
$conParam = getParam('c') ;
$actionParam = getParam('a')?getParam('a'):'index' ;
// GET All Params Include GET and POST, $GLOBALS
//demo
// setParam('aaaa', "aaa") ;
// $params = getAllParams() ;
// var_dump($params['aaaa']);exit;

//将dir和Controller的首字母转换为大写，方便读取文件
$ucConParam = ucfirst($conParam) ;
$ucDirParam = ucfirst($dirParam) ;

$filePath = APPLICATION_PATH.'/controller/'.$dirParam.'/'.$ucConParam.'.php' ;
if($ucDirParam && !is_file($filePath)){
	echo 'Not Found This Url!' ;
	exit ;
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
					
				if(checkLogin($dirParam, $conParam)){
					$class->$actionName() ;
					exit ;
				}else{
					header('Location:'.HOST_PATH.'/index.php?m=admin&c=login&a=') ;
				}
					
			}else{
				echo 'Not Found This Action!' ;
				exit ;
			}
		}catch (Exception $e){
			echo "Catch Exception:".$e->getMessage() ;
			exit ;
		}
	}else{
		//跳转到前端首页
		header('Location:'.HOST_PATH.'/index.php?d=front&c=show&a=') ;
	}
	
	
}


/*function checkLogin($dirParam, $conParam)
{
	//check 是否登陆
	if($dirParam=='admin'){
		if($conParam=='login'){
			//login目录直接跳过
			return 1 ;
		}else{
			if($_SESSION['login']==1){
				return 1 ;
			}else{
				return 0 ;
			}
		}
		
	}else{
		return 1 ;
	}
}*/


?>