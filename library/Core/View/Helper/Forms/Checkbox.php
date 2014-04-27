<?php
class Core_View_Helper_Forms_Checkbox extends Core_View_Helper_Forms_Abstract
{	
    public function checkbox($name, $value = null, $attribs = array())
    {
        if ( !empty($value) ) 
            $attribs['checked'] = 'checked';
	
	$attribs['type'] = 'checkbox';
	
	$input = new Core_View_Helper_Forms_Input();
	
	return $input->input($name, $value, $attribs);
    }
}