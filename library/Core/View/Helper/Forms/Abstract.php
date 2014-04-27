<?php
abstract class Core_View_Helper_Forms_Abstract
{	
    public function getAttribs($attribs)
    {
        $_attribs = '';
		
        foreach ( $attribs as $attrib => $val )
        {
            $_attribs .= $attrib . '="' . $val . '" ';
        }

        return rtrim($_attribs);
    }
}
?>
