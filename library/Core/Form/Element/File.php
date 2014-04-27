<?php
class Core_Form_Element_File extends Core_Form_Element
{
	public function view()
	{
		return '<input type="file" name="' . htmlspecialchars($this -> _name) . '" value="' . htmlspecialchars($this -> _value) . '" ' . $this -> _attribs() . '/>';
	}
}