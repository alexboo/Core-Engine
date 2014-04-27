<?php
Class Core_Config
{
	private static $_config = null;
	
	public function __construct($config_file)
	{
		if ( is_readable($config_file) )		
			require_once $config_file;
		else throw new Core_Config_Exception('Configuration file not found');
		
		self::$_config = $config; 
	}
	
	public static function getConfig()
	{
		return self::$_config;
	}
	
	public static function getValue($name, $resource = null)
	{
		if ( isset(self::$_config[$resource][$name]) )
			return self::$_config[$resource][$name];
		
		if ( isset(	self::$_config[$name]) )
				return self::$_config[$name];
				
		return null;
	}
}