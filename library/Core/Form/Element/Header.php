<?php
class Core_Form_Element_Header extends Core_Form_Element
{
	public function isValid()
	{
		return true;
	}
	
	public function view()
	{
		return '<h3 ' . $this -> _attribs() . '>' . htmlspecialchars($this -> _value) . '</h3>';
	}
}