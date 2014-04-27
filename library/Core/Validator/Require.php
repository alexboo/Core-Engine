<?php
class Core_Validator_Require extends Core_Validator
{
	protected $_messages = array(
		'no_require' => 'Field is required',
	);
	
	public function isValid($value)
	{
		if ( empty($value) ) {
			
			$this -> setError('no_require');
			
			return false;
		}
		
		return true;
	}
}