<?php
class Core_Database_Pdo extends Core_Database_Abstract implements Core_Database_Interface
{
	private $_connect = null;
	
	public function __construct($host, $user, $password, $database)
	{
		$this -> _connect  = new PDO('mysql:dbname=' . $database, $user, $password);
	}
	
	public function query($query, $bind = null)
	{		
		$query = $this -> escapeQuery($query, $bind);
		
		if ( $results = $this -> _connect -> query($query, PDO::FETCH_ASSOC) ) {
			
			return $results;
		}
		else {
			$error = $this -> _connect -> errorInfo();
			throw new Core_Database_Exception($error[2]);			
		}
	}
	
	public function quote($value)
	{
		return $this -> _connect -> quote($value);
	}
	
	public function fetchOne($query, $bind = null)
	{
		$result = $this -> query($query, $bind);
		
		if ( $result->rowCount() > 0 ) {
			
			$data = each($result->fetch());
			
			return $data['value'];
			
		}
		
		return null;
	}
	
	public function fetchRow($query, $bind = null)
	{
		$result = $this -> query($query, $bind);
		
		if ( $result->rowCount() > 0 ) {
			
			return $result->fetch();
			
		}
		
		return null;
	}
	
	public function fetchAll($query, $bind = null)
	{
		
		$result = $this -> query($query, $bind);
		
		if ( $result->rowCount() > 0 ) {
			
			return $result->fetchAll();
			
		}
		
		return null;
	}
	
	public function lastInsertId()
	{
		return $this -> _connect -> lastInsertId();
	}
}