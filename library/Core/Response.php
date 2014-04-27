<?php
class Core_Response implements Core_Response_Interface
{
	private static $_instance = null;
	
	private static $_request = null;
	
	private $_headers = array();
	
	private function __construct()
	{}
	
	public static function getInstance()
	{
		if ( null === self::$_instance )
			self::$_instance = new self;
		
		self::$_request = Core_Request::getInstance();
			
		return self::$_instance;
	}
	
	public function url($url, $saveparams = false)
	{
		if ( is_array($url) )
		{
			if ( $saveparams ) {
				$params = self::$_request->getParams();
				
				foreach ( $params as $key => $value )
				{
					if ( !isset($url[$key]) )
						$url[$key] = $value;
				}
			}
			
			if ( isset($url['module']) ) {
				$_url[] = $url['module'];
			}
			elseif ( null !== self::$_request->getModule() && self::$_request->getModule() != Core_Config::getValue('default', 'modules') )
				$_url[] = self::$_request->getModule();
				
			unset($url['module']);
			
			if ( isset($url['controller']) ) {
				if ( strtolower($url['controller']) != 'index' || count($url) > 1 )
					$_url[] = $url['controller'];
					
				unset($url['controller']);
			}
			elseif ( count($url) > 0 )
				$_url[] = 'index';
				
			if ( isset($url['action']) ){
				if ( strtolower($url['action']) != 'index' || count($url) > 1 )
					$_url[] = $url['action'];
				
				unset($url['action']);
			}
			else if ( count($url) > 0 )
				$_url[] = 'index';
				
			foreach ( $url as $name => $value )
			{
				if ( is_array($value) ) {
				    continue;
				}
				
				$_url[] = $name;
				$_url[] = $value;
			}
			
			$_url = '/' . implode('/', $_url);
		}
		else
			$_url = $url;
		
		return $_url;
	}
	
	public function setHeader($name = null, $value = null) 
	{
		if ( !is_null($name) )
			$this -> _headers[$name] = $value;
	}
	
	public function sendHeaders()
	{
		if ( count($this -> _headers) > 0 ) {
			foreach ( $this -> _headers as $name => $value ) {
				header($name . ': ' . $value);
			}
		}
	}
	
	public function redirect($url)
	{
		$this -> setHeader('location', $this -> url($url));
		$this -> sendHeaders();
		exit;
	}
}