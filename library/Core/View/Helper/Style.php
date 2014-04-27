<?php
class Core_View_Helper_Style
{
	public static $_files = array();
	
	public static $_captures = array();
	
	public function style()
	{
		return $this;
	} 
	
	public function addFile($file)
	{
		if ( !in_array($file, self::$_files) ) {
			self::$_files[] = $file;
		}
	}
	
	public function echoFiles()
	{
		if ( !empty(self::$_files) ) {
			
			$output = '';
			
			foreach ( self::$_files as $file ) {
				$output .= "<link href=\"" . $file . "\" type=\"text/css\" rel=\"stylesheet\" />\n";
			}

			
			return $output;
		}
		
		return null;
	}
	
	public function captureStart()
	{
		ob_start();
	}
	
	public function captureEnd()
	{
		$content = ob_get_clean();
		
		if ( !empty($content) ) {
			self::$_captures[] = $content;
		}
	}
	
	public function echoCaptures()
	{
		if ( !empty(self::$_captures) )
		{
			$output = '<style type="text/css">';
			
			foreach ( self::$_captures as $capture ) {
				$output .= $capture . "\n";
			}
			
			return $output .= '</style>';
		}
		
		return null;
	}
}