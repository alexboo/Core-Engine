<?php
class Core_Validator_Date extends Core_Validator
{
	protected $_messages = array(
		'no_date' => 'Value is not a date',
	);
	
	public function isValid($value)
	{
		if ( empty($value) )
		
			return true;
		
		if ( !strtotime($value) ) {
			
			$this -> setError('no_date');
			
			return false;
		}
		
		return true;
	}
}