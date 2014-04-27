<?php
class Core_Form_Element_Radio extends Core_Form_Element
{
	public function view()
	{
		return '<input type="radio" name="' . htmlspecialchars($this -> _name) . '" value="' . htmlspecialchars($this -> _value) . '" ' . $this -> _attribs() . '/>';
	}
}