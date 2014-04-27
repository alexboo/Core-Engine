<?php
class Core_View_Helper_Url
{
	public function url($url, $saveparams = false)
	{
		$response = Core_Response::getInstance();
		
		return $response -> url($url, $saveparams);
	}
}