<?php
class Core_View_Helper_Action
{
	public function action($action, $controller = null, $module = null, $params = null)
	{
		$request = Core_Request::getInstance();
		
		$_params = $request->getParams();
		
		$response = Core_Response::getInstance();
		
		if ( null === $params ) {
			$params = $request -> getParams();
		}
		
		if ( null !== $module ) {
			$params['module'] = $module;
		}
		if ( null !== $controller ) {
			$params['controller'] = $controller;
		}
		if ( null !== $action ) {
			$params['action'] = $action;
		}
		
		$controller = ucfirst($params['controller']) . 'Controller';

		$action = $params['action'] . 'Action';
		
		if ( in_array('Core_Controller_Interface', class_implements($controller)) ) {
		
			if ( in_array($action, get_class_methods($controller)) ) {
				
				if ( null !== $params )
					$request -> addParams($params);
				
				$controller = new $controller($request, $response); 
				
				$controller -> init();
				
				$_controller = $controller -> $action();
				
				if ( is_object($_controller) && in_array('Core_Controller_Interface', class_implements(get_class($_controller))) )
				{
					$return = $_controller -> initView();
				}
				else $return = $controller -> initView();
				
				$request -> addParams($_params);
				
				return $return;
			}
			else throw new Core_Controller_Exception("No method in the controller");
		}
		else throw new Core_Controller_Exception("Class not use \"Core_Controller_Interface\"");
	}
}