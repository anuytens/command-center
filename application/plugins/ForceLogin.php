<?php

class Application_Plugin_ForceLogin extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        // get the view
        $view = Zend_Controller_Front::getInstance()->getParam('bootstrap')->getResource('view');
        
        // set the redirection if not connected
        $controller_login = "identity";

        if (
            !Zend_Auth::getInstance()->hasIdentity() &&
            $controller_login !== $request->getControllerName() &&
            $request->getModuleName() !== "connect"
        )
        {
            $request->setControllerName($controller_login);
            $request->setActionName("index");
        }
    }
}