<?php
class Core_View_Helper_Weekday
{
	private $_weekdays = array(
		'monday' => 'Понедельник',
		'tuesday' => 'Вторник',
		'wednesday' => 'Среда',
		'thursday' => 'Четверг',
		'friday' => 'Пятница',
		'saturday' => 'Суббота',
		'sunday' => 'Воскресенье',
	);
	
	public function weekday($weekday = 'monday')
	{
		if ( isset($this->_weekdays[$weekday]) )
			return $this->_weekdays[$weekday];
		
		return null;
	}
}