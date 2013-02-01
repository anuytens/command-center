<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
        $auth = Zend_Auth::getInstance();
        
        Zend_Debug::Dump($auth->getIdentity());
    }

    public function loginAction()
    {
        // get the login form
        $form_login = new Application_Form_Login;
        
        // Check if there is a request
        if($this->_request->isPost() && $form_login->isValid($this->_request->getPost()))
        {
            // perform login
            $this->_helper->performLdapLogin(
                $this->_request->getPost("username"),
                $this->_request->getPost("password")
            );
            
            $this->_helper->redirector("index");
        }
        
        $this->view->form = $form_login;
    }

    public function logoutAction()
    {
        // get the instance of auth
        $auth = Zend_Auth::getInstance();
        
        // clear the identity
        $auth->clearIdentity();
        
        // redirect to index
        $this->_helper->redirector("index");
    }


}





