<?php
abstract class Core_Database_Abstract
{
	public function quote($value)
	{
		return "'" . addslashes($value) . "'";
	}
	
	public function escapeQuery($query = null, array $bind = null)
	{
		if ( null != $bind ) {
			
			foreach ($bind as $key => $value)
			{
				$query = str_replace(":$key", $this->quote($value), $query);
			}
		}
		
		return $query;
	}
}