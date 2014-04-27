<?php
class IndexController extends Core_Controller
{
    public function indexAction()
    {						
        $this->view->title = "Hello!";
    }
}