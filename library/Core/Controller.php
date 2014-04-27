<?php
class Core_Controller implements Core_Controller_Interface
{
	private $_request = null;
	
	private $_response = null;
	
	private $_controllerPath = null;
	
	protected $view = null;
	
	public function __construct(Core_Request_Interface $request, Core_Response_Interface $response)
	{
		$this -> _request = $request;
		
		$this -> _response = $response;
		
		$loader = Core_Loader::getInstance();
		
		$this -> _controllerPath = $loader -> getControllerPath(get_class($this));
		
		$this -> view = new Core_View();
	}
	
	public function getRequest()
	{
		return $this -> _request;
	}
	
	public function getResponse()
	{
		return $this -> _response;
	}
	
	public function getControllerPath()
	{
		return $this -> _controllerPath;
	}
	
	public function render($template = null)
	{
		$_path_to_view[] = $this -> getControllerPath();
		
		$_path_to_view[] = '..';
		
		$_path_to_view[] = 'views';
		
		$_path_to_view[] = strtolower($this -> _request -> getController());
		
		if ( $template === null )
			$_path_to_view[] = $this -> _request -> getAction() . '.php';
			
		else 
			$_path_to_view[] = $template;
		
		return $this -> view -> fetch(implode(DIRECTORY_SEPARATOR, $_path_to_view));
	}
	
	public function init()
	{
		
	}
	
	public function initView()
	{
		return $this -> render();
	}
	
	protected function _forward($action = null, $controller = null, $module = null, $params = null)
	{		
		if ( null !== $module ) {
			$params['module'] = $module;
		}
		if ( null !== $controller ) {
			$params['controller'] = $controller;
		}
		if ( null !== $action ) {
			$params['action'] = $action;
		}
		
		$controller = ucfirst($controller) . 'Controller';

		$action = $action . 'Action';
		
		if ( in_array('Core_Controller_Interface', class_implements($controller)) ) {
		
			if ( in_array($action, get_class_methods($controller)) ) {
				
				if ( null !== $params )
					$this->_request -> addParams($params);
				
				$controller = new $controller($this->_request, $this->_response); 
				
				// $controller -> init();
				
				$_controller = $controller -> $action();
				
				if ( is_object($_controller) && in_array('Core_Controller_Interface', class_implements(get_class($_controller))) )
				{
					return $_controller;
				}
				else return $controller;
			}
			else throw new Core_Controller_Exception("No method in the controller");
		}
		else throw new Core_Controller_Exception("Class not use \"Core_Controller_Interface\"");
	}
}