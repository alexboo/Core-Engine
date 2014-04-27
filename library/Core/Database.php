<?php
class Core_Database
{
	private static $_db = null;
	
	public static function getDb()
	{
		if ( null !== self::$_db ) {
			return self::$_db;
		}
	}
	
	public function __construct(array $config = array())
	{
		if ( isset($config['type']) )
			$db_class = 'Core_Database_' . ucfirst($config['type']);
		else 
			$db_class = 'Core_Database_Mysqli';
		
			if ( in_array('Core_Database_Interface', class_implements($db_class)) )
				self::$_db = new $db_class($config['host'], $config['user'], $config['password'], $config['database']);
				
			else throw new Core_Database_Exception('Do not support the type of database driver');
			
		if ( $config['options'] ) {
			foreach ( $config['options'] as $option )
			{
				self::$_db -> query($option);
			}
		}
		
		return self::$_db;
	}
}