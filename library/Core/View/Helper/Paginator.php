<?php
class Core_View_Helper_Paginator
{
	private $_count = 10;
	
	private $_max_pages = 7;
	
	private $_page = 1;
	
	private $_objects = 0;
	
	private $_url = null;
	
	public function __construct()
	{}
	
	public function paginator($objects = null, $count = 10)
	{
		$request = Core_Request::getInstance();
		
		$this -> _count = (int) $count;
		
		$this -> _objects = (int) $objects;
		
		$this -> _page = $request -> getParam('page', 1);
		
		$url = array();
		$get = array();
		
		foreach ($request -> getParams() as $name => $val) {
			
			if ( $name != 'page' ) {
				
				if ( is_array($val) ) {
				    $result = array();
				    foreach ( $val as $i => $v ) {
					$result[$name][] = $v;
				    }
				    $val = http_build_query($result);
				    $val = preg_replace('/%5B\d{1,}%5D/si', '[]', $val);
				    $get[] = $val;
				}
				else {
				    if ( !in_array($name, array('module', 'controller', 'action')) ) {
					    $url[] = $name;
				    }
				    $url[] = $val;
				}
			}
			
		}
		
		$this -> _url = '/' . implode('/', $url) . '/{page}';
		
		if ( !empty($get) ) {
		    $this -> _url .= '?' . implode('&', $get);
		}
		
		return $this;
	}
	
	public function __toString()
	{		
		$count_pages = ceil($this -> _objects / $this -> _count);
		
		if ( ($start = $this -> _page - $this -> _max_pages) < 1 ) $start = 1;
		else $first = true;
			
		if ( ($end = $this -> _page + $this -> _max_pages) > $count_pages ) $end = $count_pages;
		else $last = true;
		
		if ( $count_pages > 1 )
		{
			if ( isset($first) ) {
				$html[] = '<a href="' . $this->_url(1) . '">&laquo;</a>';
			}
			
			for ( $i = $start; $i <= $end; $i ++ ) {
				
				if ( $i == $this -> _page ) {
					$html[] = '<span>' . $i . '</span>';
				}
				else {
					$html[] = '<a href="' . $this->_url($i) . '">' . $i . '</a>';
				}
				
			}
			
			if ( isset($last) ) {
				$html[] = '<a href="' . $this->_url($count_pages) . '">&raquo;</a>';
			}
			
			return '<p class="pages no-print">' . implode($html, ' ') . '</p>';
		}
		
		return '';
	}
	
	private function _url($page){
	    return str_replace('{page}', 'page/' . $page, $this->_url);
	}
}