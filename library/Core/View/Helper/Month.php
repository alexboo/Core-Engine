<?php
class Core_View_Helper_Month
{
	private $_month = array(
		'01' => 'Января',
		'02' => 'Февраля',
		'03' => 'Марта',
		'04' => 'Апреля',
		'05' => 'Мая',
		'06' => 'Июня',
		'07' => 'Июля',
		'08' => 'Августа',
		'09' => 'Сентября',
		'10' => 'Октября',
		'11' => 'Ноября',
		'12' => 'Декабря',
	);
	
	public function month($number = '01')
	{
		if ( isset($this->_month[$number]) )
			return $this->_month[$number];
		
		return null;
	}
}