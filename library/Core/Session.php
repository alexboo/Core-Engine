<?php
class Core_Session
{
	protected $_namespace = null;
	
	public function __construct($_namespace = null)
	{	
		if ( null === $this->_time )
			session_start();
		
		$this -> _namespace = $_namespace;
		
		if ( null === $this->_lifetime ) {
			$this -> setLifetime();
		}
		
		if ( (time() - $this->_time) >= $this->_lifetime ) {
			session_regenerate_id(true);
		}
		
		$this->_time = time();
	}
	
	public function getId()
	{
		return session_id();
	}
	
	public function __set($name, $value)
	{
		if ( null !== $this -> _namespace ) {
			$_SESSION[$this -> _namespace][$name] = $value;
		}
		else $_SESSION[$name] = $value;
	} 
	
	public function __get($name)
	{
		if ( null !== $this -> _namespace ) {
			if ( isset($_SESSION[$this -> _namespace][$name]) )
				return $_SESSION[$this -> _namespace][$name];
		}
		elseif ( isset($_SESSION[$name]) )
			return  $_SESSION[$name];
		
		return null;
	}
	
	public function __isset($name)
	{
		if ( null !== $this -> _namespace ) {
			return isset($_SESSION[$this -> _namespace][$name]);
		}
		
		return isset($_SESSION[$name]);
	}
	
	public function __unset($name)
	{
		if ( null !== $this -> _namespace ) {
			unset($_SESSION[$this -> _namespace][$name]);
		}
		else unset($_SESSION[$name]);
	}
	
	public function setLifetime($seconds = 1800)
	{
		$this -> _lifetime = (int) $seconds;
	}
	
	public function destroy()
	{
		session_destroy();
	}
}