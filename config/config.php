<?php 
//Config File
return 
	array(
		'error_reporting' => '0',
		'db' => array(
			'host' => '127.0.0.1',
			'user' => 'root',
			'passwd' => '',
			'port' => '3306',
			'database' => 'test',
			'charset' => 'utf8'
		),
		'smarty' => array(
			'template_dir' => 'application/views',
			'compile_dir' => 'tmp/compile_dir',
			'config_dir' => 'tmp/config_dir',
			'cache_dir' => 'tmp/cache_dir'
		),
		'url_route_mode' => 2, // 路由模式，
							   // 1：http://gavinjx.com/?d=front&c=show&a=index模式；2：http://gavinjx.com/front/show/index
	    'default_uri' => 'front/show', //默认首页
		'upload_pic' => array(
			'ext' => array('jpg','png', 'jpeg', 'JPG', 'PNG', 'JPEG'), //允许上传的文件类型
			'dir' => '/home/data/www/SimpleF/uploads/pictures', //上传图片存放路径
			'url' => 'http://127.0.0.1/SimpleF/uploads/pictures' //上传后的图片访问路劲
		),
		'picture' => array(
			'newPicPath' => '/home/data/www/SimpleF/uploads/new_pictures', //生成的新图片的存储地址
			'url' => 'http://127.0.0.1/SimpleF/uploads/new_pictures', //新图片的访问路径
			'font' => '/home/data/www/SimpleF/www/fonts/simhei.ttf', //字体文件
			'fontSize' => 13
		),
		'timezone' => 'Asia/Shanghai',
		'HOST' => 'http://gavinjx.com',
	) ;
