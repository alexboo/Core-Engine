<?php
interface Core_Model_Interface
{	
	public function insert(array $values = array());
	
	public function update(array $values = array(), array $where = array());
	
	public function delete(array $where = array());
	
	public function getDb();
}