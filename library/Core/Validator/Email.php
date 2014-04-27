<?php
class Core_Validator_Email extends Core_Validator
{
	protected $_messages = array(
		'no_email' => 'Value is not an email',
	);
	
	public function isValid($value)
	{
		
		if ( empty($value) )
		 
			return true;
		
		if ( function_exists('filter_var') ) {
			if ( !filter_var($value, FILTER_VALIDATE_EMAIL) ) {
				
				$this -> setError('no_email');
				
				return false;
				
			}
		}
		elseif ( !preg_match('/^[\w\d\-\._]+@[\w\d\-\.]+\.[\w\d\-\.]{2,4}$/i', $value) ) {
			
			$this -> setError('no_email');
			
			return false;
		}
		
		return true;
	}
}