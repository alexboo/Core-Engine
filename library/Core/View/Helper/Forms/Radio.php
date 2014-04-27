<?php
class Core_View_Helper_Forms_Radio extends Core_View_Helper_Forms_Abstract
{	
    public function radio($name, $value = null, $attribs = array())
    {	
        if ( !empty($value) ) 
            $attribs['checked'] = 'checked';
	
	$attribs['type'] = 'radio';
	
	$input = new Core_View_Helper_Forms_Input();
	
	return $input->input($name, $value, $attribs);
    }
}