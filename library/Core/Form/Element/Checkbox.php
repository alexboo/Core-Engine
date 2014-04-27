<?php
class Core_Form_Element_Checkbox extends Core_Form_Element
{
	public function view()
	{
            $checkboxView = new Core_View_Helper_Forms_Checkbox();
            
            return $checkboxView->checkbox($this->_name, $this->_value, $this->_attribs);
	}
}