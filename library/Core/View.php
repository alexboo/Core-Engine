<?php
class Core_View
{
	private static $_params = array();
	
	private static $_base_template = null;
	
	protected static $_helper_prefix = null;
	
	private $_helpers = array();
	
	private $_flags = 9;
	
	const FLAG_HTML_QUOTES 		= 0x00000001;
	const FLAG_HTML_COMPAT 		= 0x00000002;
	const FLAG_HTML_NOQUOTES 	= 0x00000004;
	const FLAG_URL_DECODE 		= 0x00000008;
	
	public function fetch($template)
	{		
		if ( is_readable($template) ){
			
			$level = error_reporting();
		
			error_reporting(E_WARNING|E_ERROR);
		
			ob_start();
		
			include($template);
		
			$out = ob_get_contents();
		
			ob_end_clean();
		
			error_reporting($level);
			
			return $out;
		}
		else throw new Core_View_Exception('Not found template file "' . $template . '"');
		
	}
	
	public function display($template = null)
	{
		if ( null === $template ) 
			$template = self::$_base_template;
			
		echo $this -> fetch($template);
	}
	
	public function __set($name, $value)
	{
		self::$_params[$name] = $value;
	}
	
	public function & __get($name)
	{
		if (array_key_exists($name, self::$_params))
		{
			$value = & self::$_params[$name];
		}
		return $value;
	 }
	
	public function __isset($name)
	{
		if ( isset(self::$_params[$name]) )
			return true;
		
		return false;
	}
	
	public function __unset($name)
	{
		unset(self::$_params[$name]);
	}
	
	public function __call($name, $arguments) 
	{				
            $_name = array_map(create_function('$name', 'return ucfirst($name);'), explode('_', $name));
            if ( null !== self::$_helper_prefix && class_exists(self::$_helper_prefix . ucfirst($name)) ) 
                    $helper = self::$_helper_prefix . implode($_name, '_');
            else
                    $helper = 'Core_View_Helper_' . implode($_name, '_');

            if ( class_exists($helper) ) {

                    $helper = new $helper();

                    return call_user_func_array(array(&$helper, array_pop($_name)), $arguments);
            }
            else throw new Core_View_Helper_Exception('Helper ' . $helper . ' not found');
    }
    
    public function clearHelperPath()
    {
    	self::$_helper_prefix = null;
    }
    
    public function setHelperPath($path = null)
    {    	
		if ( null !== $path ) {
			
			$path = explode(DIRECTORY_SEPARATOR, $path);
			
			$path = array_map('ucfirst', $path);
			
			self::$_helper_prefix = implode($path, '_');
			
			if ( substr(self::$_helper_prefix, strlen(self::$_helper_prefix) - 1) != '_' )
				self::$_helper_prefix .= '_';
		}    	
    }
	
    public function getBaseTemplate()
    {
    	return self::$_base_template;
    }
    
	public function setBaseTemplate($template)
	{
		if ( !is_readable($template) ) {
			$_request = Core_Request::getInstance();
		
			if ( null !== $_request -> getModule() )
				$_path_to_base = implode(DIRECTORY_SEPARATOR, array('modules', $_request -> getModule(), 'views'));
			else $_path_to_base = 'views';
		
			$template = ROOT_PATH . DIRECTORY_SEPARATOR . $_path_to_base . DIRECTORY_SEPARATOR . $template;
		}
		
		if ( is_readable($template) ) {
			
			self::$_base_template = $template;
			
		}
	}
	
	public function getFlags()
	{
		return $this -> _flags;
	}
	
	public function setFlags($flags) {
		$this -> _flags = (int) $flags;
	}
	
	public function encoded(& $value, $flags = 9)
	{
		if ( is_int($flags) )
			$this->setFlags($flags);
		
		if ( is_string($value) ) {
			return $this->encodedString($value);
		}
		elseif( is_array($value) ) {
			return $this->encodedArray($value);
		}
		
		return $value;
	}
	
	private function encodedArray(& $array)
	{
		array_walk_recursive($array, array($this, 'encoded'));
		
		return $array;
	}
	
	private function encodedString(& $value)
	{
		if ( is_string($value) ) {
			
			if ( self::FLAG_URL_DECODE & $this->_flags ) {
				$value = urldecode($value);
			}
			
			if (self::FLAG_HTML_QUOTES & $this -> _flags) {
				$value = htmlspecialchars($value, ENT_QUOTES);
			}
			elseif (self::FLAG_HTML_NOQUOTES & $this -> _flags) {
				$value = htmlspecialchars($value, ENT_NOQUOTES);
			}
			elseif (self::FLAG_HTML_COMPAT & $this -> _flags) {
				$value = htmlspecialchars($value, ENT_COMPAT);
			}
		}
		
		return $value;
	}
}