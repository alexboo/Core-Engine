<?php
class Core_Application
{	
	private static $_loader = null;
	
	private static $_request = null;
	
	private static $_response = null;
	
	public function __construct($config_file)
	{	
		require_once 'Core/Exception.php';
		
		if ( set_error_handler("Core_Application::errorHandler", E_ERROR) === false ){
    		exit("The error handler is not registered");
		};
		
		$config = $this -> _loadConfig($config_file);
		
		require_once 'Core/Request/Interface.php';
		
		require_once 'Core/Request.php';
		
		self::$_request = Core_Request::getInstance();
		
		require_once 'Core/Response/Interface.php';
		
		require_once 'Core/Response.php';
		
		self::$_response = Core_Response::getInstance();
		
		require_once 'Core/Loader.php';
		
		self::$_loader = Core_Loader::getInstance();
		
		if ( isset($config['database']) )
			$db = new Core_Database($config['database']);
	}
	
	public function run()
	{			
		self::$_response -> setHeader('Content-type', 'text/html; charset=utf-8');
				
		$_name = self::$_request -> getController() . 'Controller';

		$action = self::$_request -> getAction() . 'Action';
		
		$view = new Core_View();
				
		$view -> setFlags(0);
		
		$view -> setBaseTemplate('base.php');

		if ( in_array('Core_Controller_Interface', class_implements($_name)) ) {
		
			if ( in_array($action, get_class_methods($_name)) ) {
				$controller = new $_name(self::$_request, self::$_response); 
				
				$controller -> init();
				
				$_controller = $controller -> $action();
				
				if ( is_object($_controller) && in_array('Core_Controller_Interface', class_implements(get_class($_controller))) )
					$controller = $_controller; 
				
				if ( is_string($_controller) )
					$view -> content = $_controller;
				else 
					$view -> content = $controller -> initView();
			}
			else throw new Core_Controller_Exception("No method in the controller");
		}
		else throw new Core_Controller_Exception("Class not use \"Core_Controller_Interface\"");
		
		self::$_response -> sendHeaders();
		
		$view -> display();
	}
	
	public static function errorHandler($errno, $errmsg) 
	{
	    throw new Core_Exception($errmsg, 0);
	}
	
	private function _loadConfig($config_file)
	{
		require_once 'Core/Config.php';
		
		$config = new Core_Config($config_file);
		
		return $config -> getConfig();
	}
}