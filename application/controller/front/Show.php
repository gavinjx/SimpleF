<?php 


class Front_Show{
	
	public $view = null ;
	
	public function __construct()
	{
		$this->view = $GLOBALS['smarty'] ;
	}
	public function indexAction()
	{
		
		$this->view->assign('test', $test);
		$this->view->display('front/index.html') ;
	}
	
}