<?php
class Core_View_Helper_BookNavigation
{
	public function bookNavigation($section = null, $content = null)
	{		
		$session = new Core_Session();
		
		if ( isset($session->book) ) {
			
			$modelBook = new Model_Books_Book();
		
			$sections = $modelBook->getMenu($session->book);
			
			$view = new Core_View();
			
			$navigations = array();
			
			foreach ( $sections as $i =>  $_section ) {
				
				if ( ($_section['type'] == 'section' && $_section['id'] == $section) || ($_section['type'] == 'content' && $_section['id'] == $content) ) {
					
					if ( isset($sections[$i-1]) ) {
						if ( $sections[$i-1]['type'] == 'section' )
							$navigations[1] = array('title' => 'Предыдущий раздел', 'url' => $view->url(array('controller' => 'index', 'action' => 'section', 'book' => $session->book, 'section' => $sections[$i-1]['id'])));
							
						else 
							$navigations[1] = array('title' => 'Предыдущий раздел', 'url' => $view->url(array('controller' => 'index', 'action' => 'content', 'book' => $session->book, 'id' => $sections[$i-1]['id'])));
					}
					else 
						$navigations[1] = array('title' => 'Предыдущий раздел');
					
					if ( $_section['type'] == 'section' && ( !empty($section) && !empty($content) ) )
						$navigations[3] = array('title' => 'К оглавлению', 'url' => $view->url(array('controller' => 'index', 'action' => 'section', 'book' => $session->book, 'section' => $_section['id'])));

					if ( isset($sections[$i+1]) ) {
						if ( $sections[$i+1]['type'] == 'section' )
							$navigations[5] = array('title' => 'Следующий раздел', 'url' => $view->url(array('controller' => 'index', 'action' => 'section', 'book' => $session->book, 'section' => $sections[$i+1]['id'])));
							
						else 
							$navigations[5] = array('title' => 'Следующий раздел', 'url' => $view->url(array('controller' => 'index', 'action' => 'content', 'book' => $session->book, 'id' => $sections[$i+1]['id'])));
					}
					else
						$navigations[5] = array('title' => 'Предыдущий раздел');
						
					break;
				}
			}
			
			if ( null !== $content && null !== $section ) {
				
				$modelBooksContent = new Model_Books_Content();
				
				$prev = $modelBooksContent->getPrevious($content);
				
				if ( isset($prev['id']) )
					$navigations[2] = array('title' => 'Предыдущая страница', 'url' => $view->url(array('controller' => 'index', 'action' => 'content', 'book' => $session->book, 'section' => $prev['section'], 'id' => $prev['id'])));
				else 
					$navigations[2] = array('title' => 'Предыдущая страница');
					
				$next = $modelBooksContent->getNext($content);
				
				if ( isset($next['id']) )
					$navigations[4] = array('title' => 'Следующая страница', 'url' => $view->url(array('controller' => 'index', 'action' => 'content', 'book' => $session->book, 'section' => $next['section'], 'id' => $next['id'])));
				else
					$navigations[4] = array('title' => 'Следующая страница');
			}
			
			$urls = array();
			
			for ( $i = 1; $i<=5; $i++ ) {
				
				if ( isset($navigations[$i]) ) {
					if ( isset($navigations[$i]['url']) )
						$urls[] = "<a href=\"" . $navigations[$i]['url'] . "\">" . $navigations[$i]['title'] . "</a>";
					else 
						$urls[] = $navigations[$i]['title'];
				}

			}
			
			return '<div class="navigation">' . implode($urls, ' | ') . '</div>';
			
		}
	}
}