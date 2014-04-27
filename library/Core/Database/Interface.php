<?php
interface Core_Database_Interface
{
	public function __construct($host, $user, $password, $database);
	
	public function query($query, $bind = null);
	
	public function quote($value);
	
	public function fetchOne($query, $bind = null);
	
	public function fetchRow($query, $bind = null);
	
	public function fetchAll($query, $bind = null);
	
	public function lastInsertId();
}