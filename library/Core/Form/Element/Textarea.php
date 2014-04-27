<?php
class Core_Form_Element_Textarea extends Core_Form_Element
{
	public function view()
	{
		return '<textarea name="' . htmlspecialchars($this -> _name) . '" ' . $this -> _attribs() . '>' . htmlspecialchars($this -> _value) . '</textarea>';
	}
}