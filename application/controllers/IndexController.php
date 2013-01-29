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
    }

    public function authenticateAction()
    {
        // action body
    }

    public function logoutAction()
    {
        // get the instance of auth
        $auth = Zend_Auth::getInstance();
        
        // clear the identity
        $auth->clearIdentity();
    }


}





