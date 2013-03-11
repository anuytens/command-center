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
        
        /*
		$view->setHelperPath(
            APPLICATION_PATH . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR . "helpers",
            'Application_View_Helper_'
        );
        */
        
        // get the ZFBootstrap menu helper
        $view->registerHelper(new Menu(), 'menu');
	}
    
    public function loadNavigation()
    {
        $layout = $this->getResource("layout");
		$view = $layout->getView();
        $container = new Zend_Config_Xml(APPLICATION_PATH . '/configs/navigation.xml', 'nav');
        $navigation = new Zend_Navigation($container);
        $view->navigation( $navigation );
    }
    
    public function loadPlugins()
    {
        Zend_Controller_Front::getInstance()->registerPlugin(new Application_Plugin_Layout);
    }
    
    public function loadThirdParty()
    {
        $loader = require APPLICATION_PATH . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";
        $loader->add('Twitter_', __DIR__);
        $loader->add('ZFBootstrap_', __DIR__);
    }
}