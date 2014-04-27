<?php
class Core_Model implements Core_Model_Interface
{
	protected $_name = null;
	
	protected $_db = null;
	
	protected $_info = null;
	
	public function __construct($name = null)
	{
		$this -> _db = Core_Database::getDb();
		
		if ( null !== $name )
			$this -> _name = $name;
	}
	
	public function insert(array $values = array())
	{
		if ( null !== $this -> _name ) {
			
			foreach ( $values as $column => $value ) {
				
				$values[$column] = $this -> getValue($value);
			}
			
			$columns = implode('`,`', array_keys($values));
			
			$values = implode(',', array_values($values));
			
			$query = "INSERT INTO `" . $this -> _name . "` (`$columns`) VALUES ($values)";
			
			$this -> _db -> query($query);	

			return $this -> _db -> lastInsertId();
		}
		else throw new Core_Model_Exception("Not specified table in the database");
	}
	
	public function update(array $values = array(), array $where = array())
	{
		if ( null !== $this -> _name ) {
			
			$_set = array();
			
			while (list($key, $value) = each($values)) {
				$_set[] = "`" . $key . "` = " . $this -> getValue($value);
			}
			
			$query = "UPDATE `" . $this -> _name . "` SET " . implode(',', $_set) . "  WHERE " . $this -> getWhere($where);
			
			return $this -> _db -> query($query);	
		}
		else throw new Core_Model_Exception("Not specified table in the database");
	}
	
	public function delete(array $where = array())
	{
		if ( null !== $this -> _name ) {
						
			$query = "DELETE FROM `" . $this -> _name . "` WHERE " . $this -> getWhere($where); 
			
			return $this -> _db -> query($query);	
		}
		else throw new Core_Model_Exception("Not specified table in the database");
	}
	
	public function getDb()
	{
		return $this -> _db;
	}
	
	protected function getInfo()
	{
		if ( null === $this -> _info ) {
			
			$info = $this -> _db -> fetchAll("DESCRIBE `" . $this -> _name . "`");
			
			foreach ( $info as $field ) {
				foreach ( $field as $name => $val )
				{
					$this -> _info[$name][$field['Field']] = $val;
				}
			}
			
		}
		
		return $this -> _info; 
	}
	
	protected function getValue($value)
	{
		if ( is_object($value) ) {
			if ( get_class($value) == 'Core_Database_Expr' ) {
				return $value;
			}
			else throw new Core_Database_Exception('Not support object');
		}
		else if ( is_array($value) ) {
			return implode(',', array_map(array($this -> _db, 'quote'), $value));
		}
		
		return $this -> _db -> quote($value);
	}
	
	protected function getWhere(array $where = array())
	{
		$_where = array();
		
		foreach ( $where as $key => $value )
		{
			$value = $this -> getValue($value);
			
			$_where[] = str_replace('?', $value, $key);
		}
		
		return implode(' AND ', $_where);
	}
}