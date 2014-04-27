<?php
class Core_Form_Element_Password extends Core_Form_Element
{
	public function view()
	{
		return '<input type="password" name="' . htmlspecialchars($this -> _name) . '" value="' . htmlspecialchars($this -> _value) . '" ' . $this -> _attribs() . '/>';
	}
}