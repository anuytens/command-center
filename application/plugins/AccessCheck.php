<?php
/**
 * SDIS 62
 *
 * @category   SDIS62
 * @package    SDIS62_Plugin_AccessCheck
 */

 /**
 * Access Check
 *
 * @category   Application
 * @package    SDIS62_Plugin_AccessCheck
 */
class Application_Plugin_AccessCheck extends Zend_Controller_Plugin_Abstract
{
    /**
     * List of excludes controllers
     *
     * @var array
     */
    private $excludes_controllers_list;
    
    /**
     * List of excludes modules
     *
     * @var array
     */
    private $excludes_modules_list;
    
    /**
     * Redirection controller
     *
     * @var string
     */
    private $redirection_controller;

    /**
     * Construct
     *
     * @param  string $redirection_controller
     * @param array $excludes_controllers_list
     * @return Application_Plugin_AccessCheck
     * 
     */  
    public function __construct($redirection_controller, array $excludes_controllers_list = array(), array $excludes_modules_list = array())
    {
        $this->excludes_controllers_list = $excludes_controllers_list;
        $this->excludes_modules_list = $excludes_modules_list;
        $this->redirection_controller = $redirection_controller;
        
        $this->excludes_controllers_list[] = "error";
        $this->excludes_controllers_list[] = $redirection_controller;
    }

    /**
     * preDispatch
     *
     * @param  Zend_Controller_Request_Abstract $request
     * 
     */  
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        // get the view
        $view = Zend_Controller_Front::getInstance()->getParam('bootstrap')->getResource('view');
        
        if(in_array($request->getControllerName(), $this->excludes_controllers_list) || in_array($request->getModuleName(), $this->excludes_modules_list))
        {
            return;
        }

        // If no connected, AccessCheck based on the excludes_controllers_list
        // Else based on navigation and resources
        if (!Zend_Auth::getInstance()->hasIdentity())
        {
            $request->setControllerName($this->redirection_controller);
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
            
            if($page !== null)
            {
                // Get page resource required
                $resource = $this->getPageResource($page);
                
                // Get page privilege required
                $privilege = $this->getPagePrivilege($page);

                // check permissions
                if (!$acl->isAllowed($role, $resource, $privilege) && $resource !== null)
                {
                    $request->setControllerName('error');
                    $request->setActionName('error');
                }
            }
        }
    }
    
    /**
     * getPageResource
     *
     * @param  $page
     * @return null|Zend_Acl_Resource_Interface
     * 
     */  
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
    
    /**
     * getPagePrivilege
     *
     * @param  $page
     * @return null|string
     * 
     */  
    private function getPagePrivilege($page)
    {
        return $page->getPrivilege();
    }
}