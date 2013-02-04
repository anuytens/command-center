<?php

class AuthenticationController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

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
                if($this->_helper->performLdapLogin($this->_request->getPost("username"), $this->_request->getPost("password")))
                {
                    $this->_helper->flashMessenger(array(
                        'context' => 'success',
                        'title' => 'Bonjour ' . $auth->getIdentity()->displayname . ' !',
                        'message' => 'Vous êtes à présent connecté sur votre SDIS 62 ID !'
					));
                    
                    $this->_helper->redirector("index");
                }
                else
                {
                    $this->_helper->flashMessenger(array(
                        'context' => 'warning',
                        'title' => 'Oups !',
                        'message' => 'Les identifiants ne sont pas valides. Rééssayez.'
					));
                }
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

        // build the message
        $this->_helper->flashMessenger(array(
            'context' => 'success',
            'title' => 'Au revoir !',
            'message' => 'Vous avez été correctement déconnecté. A bientôt ;-)'
        ));
        
        // redirect to index
        $this->_helper->redirector("index");
    }


}