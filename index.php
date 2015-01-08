<?php 
session_start() ;
error_reporting(5) ;
header("Content-type: text/html; charset=utf-8") ;
//获取配置文件 
$config = require 'config/config.php' ;

$systemConfig = json_decode($config, true) ;
$HOST = $systemConfig['HOST'] ;

//设置时区
date_default_timezone_set ( $systemConfig['timezone'] ) ;


$ROOT_PATH = realpath(__DIR__) ;

//获取项目名称
$list = explode('/', $ROOT_PATH) ;//寻找位置
$listNum = count($list) ;
$PROJECT_NAME = $list[$listNum-1] ;//删除后面

define('ROOT_PATH', $ROOT_PATH) ;
define('APPLICATION_PATH', ROOT_PATH.'/application') ;
define('HOST_PATH', $HOST.'/'.$PROJECT_NAME) ; //项目访问根目录

$includePaths = array(
		ROOT_PATH . '/library',
		ROOT_PATH . '/application/models',
		ROOT_PATH . '/application/controllers'
);
set_include_path(implode(PATH_SEPARATOR, $includePaths) . PATH_SEPARATOR . get_include_path());



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



$GLOBALS['smarty'] = $smarty ;
$GLOBALS['systemConfig'] = $systemConfig ;


$dirParam = getParam('m') ;
$conParam = getParam('c') ;
$actionParam = getParam('a')?getParam('a'):'index' ;
// GET All Params Include GET and POST
// $params = getAllParams() ;

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
		header('Location:'.HOST_PATH.'/index.php?m=front&c=show&a=') ;
	}
	
	
}


function checkLogin($dirParam, $conParam)
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
}

function getParam($key)
{
	if(isset($_GET[$key])){
		$val = $_GET[$key] ;
	}elseif(isset($_POST[$key])){
		$val = $_POST[$key] ;
	}
	$val = trim($val) ;
	// remove all non-printable characters. CR(0a) and LF(0b)
	// and TAB(9) are allowed
	// this prevents some character re-spacing such as <java\0script>
	// note that you have to handle splits with \n, \r,
	// and \t later since they *are* allowed in some inputs
	$val = preg_replace ( '/([\x00-\x08|\x0b-\x0c|\x0e-\x19])/', '', $val );
	
	// straight replacements, the user should never need these
	// since they're normal characters
	// this prevents like ![](@avascript:alert()
	$search = 'abcdefghijklmnopqrstuvwxyz';
	$search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$search .= '1234567890!@#$%^&*()';
	$search .= '~`";:?+/={}[]-_|\'\\';
	for($i = 0; $i < strlen ( $search ); $i ++) {
		// ;? matches the ;, which is optional
		// 0{0,7} matches any padded zeros, which are optional and go up to 8 chars
		
		// @ @ search for the hex values
		$val = preg_replace ( '/(&#[xX]0{0,8}' . dechex ( ord ( $search [$i] ) ) . ';?)/i', $search [$i], $val ); // with a ;
		                                                                                           // @ @ 0{0,7} matches '0' zero to seven times
		$val = preg_replace ( '/(&#0{0,8}' . ord ( $search [$i] ) . ';?)/', $search [$i], $val ); // with a ;
	}
	
	// now the only remaining whitespace attacks are \t, \n, and \r
	$ra1 = Array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
	$ra2 = Array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
	$ra = array_merge ( $ra1, $ra2 );
	
	$found = true; // keep replacing as long as the previous round replaced something
	while ( $found == true ) {
		$val_before = $val;
		for($i = 0; $i < sizeof ( $ra ); $i ++) {
			$pattern = '/';
			for($j = 0; $j < strlen ( $ra [$i] ); $j ++) {
				if ($j > 0) {
					$pattern .= '(';
					$pattern .= '(&#[xX]0{0,8}([9ab]);)';
					$pattern .= '|';
					$pattern .= '|(&#0{0,8}([9|10|13]);)';
					$pattern .= ')*';
				}
				$pattern .= $ra [$i] [$j];
			}
			$pattern .= '/i';
			$replacement = substr ( $ra [$i], 0, 2 ) . '<x>' . substr ( $ra [$i], 2 );
			// add in <> to nerf the tag
			$val = preg_replace ( $pattern, $replacement, $val );
			// filter out the hex tags
			if ($val_before == $val) {
				// no replacements were made, so exit the loop
				$found = false;
			}
		}
	}
	return $val;
	        	
}
function getAllParams()
{
	$params = array() ;
	foreach ($_GET as $key => $val){
		$params[$key] = getParam($key) ;
	}
	foreach ($_POST as $key => $val){
		$params[$key] = getParam($key) ;
	}
	return $params ;
}
?>