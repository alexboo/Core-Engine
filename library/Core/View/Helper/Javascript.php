<?php
class Core_View_Helper_Javascript
{
	public static $_files = array();
	
	public static $_captures = array();
	
	public function javascript()
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
			
			self::$_files = array_reverse(self::$_files);
			
			foreach ( self::$_files as $file ) {
				$output .= "<script type=\"text/javascript\" src=\"" . $file . "\"></script>\n";
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
			$output = '<script type="text/javascript">
';
			
			foreach ( self::$_captures as $capture ) {
				$output .= $capture . "\n";
			}
			
			return $output .= '</script>';
		}
		
		return null;
	}
}