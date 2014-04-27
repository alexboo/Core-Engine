<?php
abstract class Core_Validator
{	
	protected $_messages = array();
	
	protected $_error = null;
	
	public function getError()
	{
		return $this -> _error;
	}
	
	public function getName()
	{
		return get_class($this);
	}
	
	public function isValid($value)
	{
		return false;
	}
	
	public function setError($key)
	{
		return $this -> _error = $this -> _messages[$key];
	}
}