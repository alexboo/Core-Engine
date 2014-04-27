<?php
class Core_Database_Mysqli extends Core_Database_Abstract implements Core_Database_Interface
{
	private $_connect = null;
	
	public function __construct($host, $user, $password, $database)
	{
		$this -> _connect = new mysqli($host, $user, $password, $database);
	}
	
	public function query($query, $bind = null)
	{
		$query = $this -> escapeQuery($query, $bind);
		
		if ( $results = $this -> _connect -> query($query) )
			return $results;
		else {
			throw new Core_Database_Exception($this -> _connect -> error);	
		}
	}
	
	public function quote($value)
	{
		return "'" . $this -> _connect -> escape_string($value) . "'";
	}
	
	public function fetchOne($query, $bind = null)
	{
		if ( $results = $this -> query($query, $bind) ) {
			
			$data = $results -> fetch_row();
			
			if ( null !== $data ) {
				$data = each($data);

				return $data['value'];
			}
		} 
		
		return null;
	}
	
	public function fetchRow($query, $bind = null)
	{
		if ( $results = $this -> query($query, $bind) ) {
			
			return $results -> fetch_assoc();
		} 
		
		return null;
	}
	
	public function fetchAll($query, $bind = null)
	{
		if ( $results = $this -> query($query, $bind) ) {
			
			while ( $row = $results -> fetch_assoc() ) {
				$data[] = $row;
			}
			
			return (isset($data) ? $data : null);
		} 
		
		return null;
	}
	
	public function lastInsertId()
	{
		return $this -> _connect -> insert_id;
	}
}