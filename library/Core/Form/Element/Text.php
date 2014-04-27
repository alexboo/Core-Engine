<?php
class Core_Form_Element_Text extends Core_Form_Element
{
	public function view()
	{
            $inputView = new Core_View_Helper_Forms_Input();
            
            $this->_attribs['type'] = 'text';
            
            return $inputView->input($this->_name, $this->_value, $this->_attribs);
		//return '<input type="text" name="' . htmlspecialchars($this -> _name) . '" value="' . htmlspecialchars($this -> _value) . '" ' . $this -> _attribs() . '/>';
	}
}