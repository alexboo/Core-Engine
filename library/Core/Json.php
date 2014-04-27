<?php
class Core_Json
{
	private $_json = null;
	
	public function encode($value)
	{
		if ( function_exists('json_encode') ) 
		{
			return json_encode($value);
		}
		else 
		{
			$json = $this -> getJsonObject();
			
			return $json -> encode($value); 
		}
	}
	
	public function decode($value)
	{
		if ( function_exists('json_decode') ) 
		{
			return json_decode($value);
		}
		else 
		{
			$json = $this -> getJsonObject();
			
			return $json -> encode($value); 
		}
	}
	
	public function response($value)
	{
		$response = Core_Response::getInstance();
		
		$response -> setHeader('Content-Type', 'text/plain');
		
		$response -> sendHeaders();
		
		exit($this -> encode($value));
	}
	
	private function getJsonObject()
	{
		if ( is_null($this -> _json) ) {
			require_once 'Core/Json/JSON.php';
			
			$this -> _json = new Services_JSON();
		}
		
		return $this -> _json;
	}
}