<?php
class Core_View_Helper_Request
{
	public function request()
	{
		return Core_Request::getInstance();
	}
}