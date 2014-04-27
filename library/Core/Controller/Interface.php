<?php
interface Core_Controller_Interface
{	
	public function __construct(Core_Request_Interface $request, Core_Response_Interface $response);
	
	public function getRequest();
	
	public function getResponse();
	
	public function getControllerPath();
	
	public function render();
	
	public function init();
	
	public function initView();
}