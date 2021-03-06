<?php

class Api_UserController extends Zend_Controller_Action
{
    public function indexAction()
    {
        // Disable the renderer
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        // set the server
        $server = new Zend_Rest_Server;
        $server->setClass("Api_Service_User");
        $server->handle();
    }
}