<?php
class Core_View_Helper_Forms_Select extends Core_View_Helper_Forms_Abstract
{	
    public function select($name, $values, $select = null, $attribs = array())
    {
        $options = '';

        foreach ($values as $value => $title) {
                $options .= '<option value="' . $value . '"' . ( $value == $select ? ' selected="selected"' : '' ) . '>' . $title .  '</option>';			
        }

        return '<select name="' . htmlspecialchars($name) . '" ' . $this -> getAttribs($attribs) . '>' . $options . '</select>';
    }
}