<?php
class Model_Test extends Core_Model
{
	protected $_name = 'tests';
	
	public function edit(array $values = array(), $test = null)
	{
		$info = $this -> getInfo();
		
		foreach ( $values as $name => $value ) {
			
			if ( !in_array($name, $info['Field']) )
				unset($values[$name]);
		}
		
		if ( null !== $test ) {
			$this -> update($values, array('id = ?' => $test));
			
			return $test;
		}
		else {			
			
			if ( !empty($values['specialty']) && empty($values['position']) )
				$values['position'] = $this->_db->fetchOne("SELECT MAX(`position`) FROM `tests` WHERE `specialty` = :spec", array('spec' => $values['specialty']));
			
			return $this -> insert($values);
		}
	}
	
	public function get($test = null)
	{
		return $this -> _db -> fetchRow("SELECT * FROM `tests` WHERE `id` = :tid", array('tid' => $test));
	}
	
	public function getList(array $params = array())
	{
		$where = '';
		
		if ( count($params) > 0 )
		{
			$where = 'WHERE ' . $this -> getWhere($params);
		}
		
		return $this -> _db -> fetchAll("SELECT `t`.*, `s`.`name` `specialty` FROM `tests` `t`
		INNER JOIN `specialty` `s` ON `t`.`specialty` = `s`.`id` $where
		ORDER BY `position`");
	}
	
	public function getTestName($test = null)
	{
		$test = $this -> _db -> fetchRow("SELECT `t`.*, `s`.`name` `specialty` FROM `tests` `t`
		INNER JOIN `specialty` `s` ON `t`.`specialty` = `s`.`id`
		WHERE `t`.`id` = :tid", array('tid' => $test));
		
		return $test['subject'] . ', ' . $test['specialty'];
	}
	
	public function getTestScores($test = null)
	{
		return $this -> _db -> fetchAll("SELECT * FROM `tests_scores` WHERE `test` = :tid", array('tid' => $test));
	}
	
	public function setTestScore($values = array(), $id = null)
	{
		$model = new Core_Model('tests_scores');
		
		$info = $model -> getInfo();
		
		foreach ( $values as $name => $value ) {
			
			if ( !in_array($name, $info['Field']) )
				unset($values[$name]);
		}
		
		if ( null !== $id )
			$model -> update($values, array('id = ?' => $id));
		else 
			$model -> insert($values);
		
	}
	
	public function deleteTestScore($id = null)
	{
		$model = new Core_Model('tests_scores');
		
		$model -> delete(array('id = ?', $id));
	}
	
	public function getScore($test = null, $answer = null)
	{
		return $this -> _db -> fetchOne("SELECT `score` FROM `tests_scores` WHERE `test` = :tid AND `answer` <= :answer ORDER BY `answer` DESC", array('tid' => $test, 'answer' => $answer));
	}
}