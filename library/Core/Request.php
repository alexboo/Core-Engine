<?php
class Core_Request implements Core_Request_Interface
{
	private static $_instance = null;
	
	private static $_params = array();
	
	private static $_paramsPost = array();
	
	public static function getInstance()
	{
		if ( null === self::$_instance )
			self::$_instance = new self;
		
		return self::$_instance;
	}
	
	public function getModule()
	{
		if ( isset(self::$_params['module']) )
			return self::$_params['module'];
		
		return Core_Config::getValue('default', 'modules');
	}
	
	public function getController()
	{
		if ( isset(self::$_params['controller']) )
			return ucfirst(self::$_params['controller']);
		
		return 'Index';
	}
	
	public function getAction()
	{
		if ( isset(self::$_params['action']) )
			return self::$_params['action'];
		
		return 'index';
	}
	
	public function getParam($name = null, $default = null)
	{
		if ( isset(self::$_params[$name]) )
			return self::$_params[$name];
		
		if ( isset(self::$_paramsPost[$name]) )
			return self::$_paramsPost[$name];
		
		return $default;
	}
	
	public function getPostParam($name = null, $default = null)
	{		
		if ( isset(self::$_paramsPost[$name]) )
			return self::$_paramsPost[$name];
		
		return $default;
	}
	
	public function getParams()
	{
		return self::$_params;
	}
	
	public function getPostParams()
	{
		return self::$_paramsPost;
	}
	
	public function getAllParams()
	{
		return array_merge(self::$_params, self::$_paramsPost);
	}
	
	public function addParams($params)
	{
		self::$_params = array_merge(self::$_params, $params);
	}
	
	private function __construct()
	{		
		$this -> parseUrl($_SERVER['REQUEST_URI']);
	}
	
	private function parseUrl($url)
	{		
		$modules_directory = Core_Config::getValue('directory', 'modules');
		
		$_components = array('controller', 'action');
		
		$url = explode('?', $url);
		
		self::$_params = array();
		
		$_params = explode('/', trim($url[0], "/"));
		
		if ( !empty($_params[0]) ){
			
			if ( null !== $modules_directory && is_dir(ROOT_PATH . $modules_directory . DIRECTORY_SEPARATOR . $_params[0]) ){
				$_components = array_merge(array('module'), $_components);
			}
			
			if ( count($_components) > count($_params) )
				array_splice($_components, count($_params));
				
			self::$_params += array_combine($_components, array_slice($_params, 0, count($_components)));
			
			if ( !isset(self::$_params['controller']) )
				self::$_params['controller'] = 'index';
			
			if ( !isset(self::$_params['action']) )
				self::$_params['action'] = 'index';
			
			$params = array_slice($_params, count($_components), count($_params));
			
			for ($i = 0; $i <= count($params); $i = $i + 2 )
			{
				if ( isset($params[$i + 1]) )
					self::$_params += array($params[$i] => $params[$i + 1]);
			}
		}
		
		if ( !empty($url[1]) ){
		    $_url = explode('&', $url[1]);
		    $_get_url = array();
		    
		    foreach ( $_url as $param ) {
			$param = explode('=', $param);
			if ( empty($param[1]) )
			    $param[1] = null;
			
			$param[0] = urldecode($param[0]);
			
			if ( strpos($param[0], '[]') !== false ) {
			    $_get_url[str_replace('[]', '', $param[0])][] = urldecode($param[1]);
			}
			else {
			    $_get_url[$param[0]] = urldecode($param[1]);
			}
		    }
		    
		    self::$_params += $_get_url;
		}
		
		return self::$_paramsPost = $_POST;
	}
}