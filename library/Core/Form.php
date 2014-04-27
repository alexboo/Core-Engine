<?php
class Core_Form
{
	private $_elements = array(); 
	
	public function addElement($element = null)
	{		
		if ( in_array('Core_Form_Element', class_parents($element)) ) {
			
			$this -> _elements[$element -> getName()] = $element;
			
		}
		else throw new Core_Form_Exception('Unsupported object');
	}
	
	public function createElement($element, $name)
	{
		$element = 'Core_Form_Element_' . ucfirst($element);
		
		if ( class_exists($element) ) {
			
			$element = new $element($name);
			
			return $element;
		}
		
		return null;
		
	}
	
	public function getAllElements()
	{
		return $this -> _elements;
	}
	
	public function getElement($name)
	{
		if ( isset($this -> _elements[$name]) )
			return $this -> _elements[$name];
		
		return null;
	}
	
	public function getValues()
	{
		$values = array();
		
		foreach ( $this -> _elements as $name => $element ) {
			
			$values[$name] = $element -> getValue();
			
		}
		
		return $values;
	}
	
	public function isValid($values)
	{
		$errors = 0;
		
		foreach ( $values as $name => $value ) {
			
			if ( isset($this -> _elements[$name]) ) {
				
				$this -> _elements[$name] -> setValue($value);
				
				if ( !$this -> _elements[$name] -> isValid() ) 
					$errors ++; 
				
			}
			
		}
		
		if ( $errors > 0 )
			return false;
		
		return true;
	}
	
	public function removeElement($name)
	{
		unset($this -> _elements[$name]);
		
		return ;
	}
	
	public function setDefaults($values)
	{
		if ( is_array($values) ) {
			foreach ( $values as $name => $value ) {
			    
				if ( isset($this -> _elements[$name]) ) {
					
					$this -> _elements[$name] -> setValue($value);
					
				}
				
			}
		}
	}
	
	public function __construct()
	{
		$this -> init();
	}
	
	public function init()
	{}
	
	public function __toString()
	{
		$output = '<dl>';
		
		foreach ( $this -> _elements as $name => $element ) {
			
			if ( null !== $element -> getLabel() )
				$output .= '<dt id="' . $name . '-label"><label for="' . $name . '">' . $element -> getLabel() . '</label></dt>';
				
			$output .= '<dd id="' . $name . '-element">' . $element . '</dd>'; 
			
		}
		$output .= '</dl>';
		
		return '<form action="" method="post" enctype="multipart/form-data">' . $output . '</form>';
	}
}