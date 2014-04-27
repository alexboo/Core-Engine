<?php
interface Core_Request_Interface
{
	public function getModule();
	
	public function getController();
	
	public function getAction();
	
	public function getParam($name = null, $default = null);
}