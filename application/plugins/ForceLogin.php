<?php

class Application_Plugin_ForceLogin extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        // get the view
        $view = Zend_Controller_Front::getInstance()->getParam('bootstrap')->getResource('view');
        
        // set the redirection if not connected
        $url_login = $view->url(array("action" => "login", "controller" => "authentication"));

        if (!Zend_Auth::getInstance()->hasIdentity() && $url_login != $view->url())
        {
            $request->setControllerName("authentication");
            $request->setActionName("login");
        }
    }
}