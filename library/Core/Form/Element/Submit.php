<?php
class Core_Form_Element_Submit extends Core_Form_Element
{
	public function view()
	{
		return '<input type="submit" name="' . htmlspecialchars($this -> _name) . '" value="' . htmlspecialchars($this -> _value) . '" ' . $this -> _attribs() . '/>';
	}
}