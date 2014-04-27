<?php
class Core_Loader
{
	private static $_instance = null;
	
	private static $_autoload_paths = null;
	
	public static function getInstance()
	{
		if ( null === self::$_instance )
			self::$_instance = new self();
			
		return self::$_instance;
	}
	
	public static function autoload($class)
	{
		$self = self::getInstance();
		
		if ( stripos($class, 'model_') === 0)
			$class = str_replace('Model_', '', $class);
		
		$filePath = self::getClassPath($class);
		
		foreach ( self::getAutoloadPath() as $includePath )
		{			
			if ( is_readable(ROOT_PATH . $includePath . DIRECTORY_SEPARATOR . $filePath) )
			{
				require_once ROOT_PATH . $includePath . DIRECTORY_SEPARATOR . $filePath;
				break;
			}
		}
	}
	
	public function getClass($class)
	{
		if ( is_readable($this -> getClassPath($class)) )
			require $this -> getClassPath($class);
		
		if ( class_exists($class) )
			return new $class;
		else throw new Core_Loader_Exception('Not found the specified class');
	}
	
	public function getControllerPath($controller)
	{
		$config = Core_Config::getConfig();
		
		$_path = array();
		
		if ( isset($config['modules']) ){
			
			$request = Core_Request::getInstance();
			
			$_path[] = $config['modules']['directory'];
			
			$_path[] = $request->getModule();
		}
		
		array_push($_path, 'controller');
		
		return ROOT_PATH . implode(DIRECTORY_SEPARATOR , $_path);
	}
	
	private function __construct()
	{
		spl_autoload_register(array(__CLASS__, 'autoload'));
	}
	
	private function getAutoloadPath()
	{
		if ( null === self::$_autoload_paths ){
			
			$config = Core_Config::getConfig();
			
			if ( isset($config['includePaths']) ){
				
				if ( !key_exists('library', $config['includePaths']) )
					self::$_autoload_paths[] = '/library';
				if ( !key_exists('models', $config['includePaths']) )
					self::$_autoload_paths[] = '/models';
				
				foreach ($config['includePaths'] as $path)
				{
					self::$_autoload_paths[] = $path;
				}
			}
			else {
				
				self::$_autoload_paths[] = '/library';
				self::$_autoload_paths[] = '/models';
			}
			
			if ( isset($config['modules']) ){
				
				$_request = Core_Request::getInstance();
				
				$_path[] = $config['modules']['directory'];
				
				if ( null !== $_request -> getModule() )
					$_path[] = $_request -> getModule();
				
				$_path[] = 'controller';
				
				self::$_autoload_paths[] = implode(DIRECTORY_SEPARATOR, $_path);
			}
			else self::$_autoload_paths[] = '/controller';
		}
		
		return self::$_autoload_paths;
	}
	
	private function getClassPath($class)
	{
		return implode(DIRECTORY_SEPARATOR, explode('_', $class)) . '.php';
	}
}