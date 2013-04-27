<?php

class Application_Plugin_AccessCheck extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        // set the redirection if not connected
        $controller_login = "identity";
        
        // get the view
        $view = Zend_Controller_Front::getInstance()->getParam('bootstrap')->getResource('view');

        if (
            !Zend_Auth::getInstance()->hasIdentity() &&
            $controller_login !== $request->getControllerName() &&
            "error" !== $request->getControllerName() &&
            $request->getModuleName() != "connect"
        )
        {
            $request->setControllerName($controller_login);
            $request->setActionName("index");
        }
        else
        {
            // get the ACL
            $acl = $view->navigation($view->nav)->getAcl();
            
            // Get the current role
            $role = $view->navigation($view->nav)->getRole();
            
            // Get the current page
            $page = $view->navigation($view->nav)->findOneBy('active', true);

            $resource = $this->getPageResource($page);

            // check permissions
            if (!$acl->isAllowed($role, $resource) && $resource !== null)
            {
                $request->setControllerName('error');
                $request->setActionName('error');
            }
        }
    }
    
    private function getPageResource($page)
    {
        if($page !== null)
        {
            return $page->getResource() === null ?
                $page->getParent() instanceof Zend_Navigation_Page ? $this->getPageResource($page->getParent()) : null :
                $page->getResource();
        }
        else
        {
            return null;
        }
    }
}