<?php
class Core_Exception extends Exception
{
	public function __construct($message = null, $code = 0)
	{		
		parent::__construct($message, $code);
		/*
		$message = "<h2>Exception: {$this -> getMessage()}</h2>
<p>File: {$this -> getFile()} (Line: {$this -> getLine()})</p>\n";

		$message .= '<h3>Trace: </h3><div><pre>' . $this -> formatTrace($this -> getTrace()) . '</pre></div>';
		
		$view = new Core_View();
		
		$view -> setFlags(0);
		
		$view -> content = $message;
			
		$view -> display();*/
		
		//echo($message);
	}
	
	private function formatTrace($trace)
	{
		return print_r($trace, true);
	}
}