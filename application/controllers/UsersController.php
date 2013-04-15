<?php

class UsersController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $this->_helper->redirector('list');
    }
    
    public function listAction()
    {
        $user_service = new Application_Service_User;
        
        $this->view->users = $user_service->getAllUsers();
    }

    public function addAction()
    {
        $user_service = new Application_Service_User;
        
        if($this->_request->isPost())
        {
            if($user_service->create($this->_request->getPost()))
            {
                $this->_helper->redirector('list');
            }
            else
            {
            }
        }
        
        $this->view->form = $user_service->getUserForm();
    }

}