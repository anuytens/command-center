<?php

class IndexController extends Zend_Controller_Action
{
    /**
     * Initialize the controller
     */
    public function init()
    {
        /* Initialize action controller here */
    }
    
    /**
     * index
     */
    public function indexAction()
    {
        // action body
    }
    
    /**
     * Log in the user
     */
    public function loginAction()
    {
        // get the auth instance
        $auth = Zend_Auth::getInstance();
    
        // if the user is authenticated, redirect to index action
        if(!$auth->hasIdentity())
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
        else
        {
            $this->_helper->redirector("index");
        }
    }

    /**
     * Log out the user
     */
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





