<?php
class Core_View_Helper_Forms_Input extends Core_View_Helper_Forms_Abstract
{	
    public function input($name, $value = null, $attribs = array())
    {
        return '<input name="' . htmlspecialchars($name) . '" value="' . htmlspecialchars($value) . '" ' . $this -> getAttribs($attribs) . '/>';
    }
}