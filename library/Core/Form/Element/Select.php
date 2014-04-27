<?php
class Core_Form_Element_Select extends Core_Form_Element
{
	private $_options = array();
	
	public function setOptions($values)
	{
		if ( is_array($values) )
			$this -> _options = $values;
		
		return $this;
	}
	
	public function view()
	{
            $selectView = new Core_View_Helper_Forms_Select();
            
            return $selectView->select($this->_name, $this->_options, $this->_value, $this->_attribs);
	}
	
	public function getValueTitle()
	{
		return $this -> _options[$this -> getValue()];
	}
}