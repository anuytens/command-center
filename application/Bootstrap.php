<?php

use ZFBootstrap\View\Helper\Navigation\Menu;

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    public function run()
    {
        $this->loadThirdParty();
		$this->loadActionHelpers();
		$this->loadViewHelpers();
        $this->loadNavigation();
        $this->loadPlugins();
		parent::run();
	}

	public function loadActionHelpers()
    {
		Zend_Controller_Action_HelperBroker::addPath(
			APPLICATION_PATH . DIRECTORY_SEPARATOR . "controllers" . DIRECTORY_SEPARATOR . "helpers",
			"Application_Controller_Helper_"
		);
	}
	
	public function loadViewHelpers()
    {
		$layout = $this->getResource("layout");
		$view = $layout->getView();
        
        $view->addHelperPath(APPLICATION_PATH . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "vendor" . 
            DIRECTORY_SEPARATOR . "sdis62" . DIRECTORY_SEPARATOR . "toolbox" . DIRECTORY_SEPARATOR . "library" . 
            DIRECTORY_SEPARATOR . "SDIS62" . DIRECTORY_SEPARATOR . "View" . DIRECTORY_SEPARATOR . "Helper", "SDIS62_View_Helper_");

        // get the ZFBootstrap menu helper
        $view->registerHelper(new Menu(), 'menu');
	}
    
    public function loadNavigation()
    {
        // get the view
        $layout = $this->getResource("layout");
		$view = $layout->getView();

        // create the navigation menus
        $view->nav = new Zend_Navigation(new Zend_Config_Xml(APPLICATION_PATH . '/configs/navigation.xml', 'nav'));

        // setup the acl
        $acl = new Zend_Acl();
        
        $acl->addRole(new Zend_Acl_Role('guest')); // not authenicated
        $acl->addRole(new Zend_Acl_Role('admin'));
        
        $acl->add(new Zend_Acl_Resource('admin'));
        //$acl->add(new Zend_Acl_Resource('full'));
        
        $acl->allow('admin', 'admin');
        $acl->deny('guest', 'admin');
        
        $view->navigation($view->nav)->setAcl($acl)->setRole("guest");
        
        // Build the user nav
        $user_service = new Application_Service_User;
        $view->user_nav = new Zend_Navigation($user_service->getNavigationXML());
        
        // If we are connected, replace the label by the username
        if(Zend_Auth::getInstance()->hasIdentity())
        {
            $identity = Zend_Auth::getInstance()->getIdentity();
            $view->user_nav->findOneByLabel("[USER_NAME]")->setLabel($identity["display_name"]);
        }
    }
    
    public function loadPlugins()
    {
        Zend_Controller_Front::getInstance()->registerPlugin(new Application_Plugin_Layout);
        Zend_Controller_Front::getInstance()->registerPlugin(new Application_Plugin_ForceLogin);
    }
    
    public function loadThirdParty()
    {
        $loader = require APPLICATION_PATH . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";
        $loader->add('Twitter_', __DIR__);
        $loader->add('ZFBootstrap_', __DIR__);
    }
}