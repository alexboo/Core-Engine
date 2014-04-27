<?php
abstract class Core_Form_Element
{	
	protected $_attribs = array();
	
	protected $_validators = array();
	
	protected $_errors = array();
	
	protected $_label = null;
	
	protected $_name = null;
	
	protected $_value = null;
	
	public function addValidator($validator)
	{
		if ( !is_object($validator) ) {
			$validator = 'Core_Validator_' . $validator;
			
			if ( class_exists($validator) )
				$validator = new $validator;
		}
		
		if ( in_array('Core_Validator', class_parents($validator)) ) {
			$this -> _validators[$validator -> getName()] = $validator;
		}
		else throw new Core_Validator_Exception('Unsupported object');
		
		return $this;
	}
	
	public function getAttrib($attrib)
	{
		if ( isset($this -> _attribs[$attrib]) )
			return $this -> _attribs[$attrib];
			
		return null;
	}
	
	public function getErrors()
	{
		return $this -> _errors;
	}
	
	public function getLabel()
	{
		return $this -> _label;
	}
	
	public function getName()
	{
		return $this -> _name;
	}
	
	public function getValue()
	{
		return $this -> _value;
	}
	
	public function isValid()
	{		
		if ( count($this -> _validators) > 0 ) {
			
			foreach ( $this -> _validators as $validator ) {
				
				if ( !$validator -> isValid($this -> getValue()) )
					$this -> _errors[] = $validator -> getError();
			}
			
			if ( count($this ->_errors) > 0 )
				return false;
			
		}
		
		return true;
	}
	
	public function removeAttrib($attrib)
	{
		unset($this -> _attribs[$attrib]);
		
		return $this;
	}
	
	public function removeValidator($validator)
	{
		unset($this -> _validators[$validator]);
		
		return $this;
	}
	
	public function setAttrib($attrib, $value)
	{
		if ( !empty($attrib) and !in_array($attrib, array('name', 'value')) )
			$this -> _attribs[$attrib] = $value;
		
		return $this;
	}
	
	public function setLabel($label)
	{
		if ( !empty($label) )
			$this -> _label = $label;
		
		return $this;
	}
	
	public function setValue($value)
	{
		$this -> _value = $value;
		
		return $this;
	}
	
	public function __construct($name)
	{
		if ( !empty($name) ) {
			
			$this -> _name = $name;			
		}
	}
	
	public function __toString()
	{
		$output = $this -> view();
		
		if ( count($this -> _errors) > 0 ) {
			$output .= '<ul class="error">'; 
			foreach ($this -> _errors as $error) {
				$output .= '<li>' . $error . '</li>';
			}
			$output .= '</ul>'; 
		}
		
		return $output;
	}
	
	public function view()
	{
		return '<input type="text" name="' . $this -> _name . '" value="' . $this -> _value . '" ' . $this -> _attribs() . '/>';
	}
	
	protected function _attribs()
	{
		$attribs = '';
		
		foreach ( $this -> _attribs as $attrib => $val )
		{
			$attribs .= $attrib . '="' . $val . '" ';
		}
		
		return rtrim($attribs);
	}
}