<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    public function run()
    {
		$this->loadActionHelpers();
		$this->loadViewHelpers();
		parent::run();
	}

	public function loadActionHelpers()
    {
		Zend_Controller_Action_HelperBroker::addPath(
			APPLICATION_PATH . DIRECTORY_SEPARATOR ."controllers" . DIRECTORY_SEPARATOR . "helpers",
			"Application_Controller_Helper_"
		);
	}
	
	public function loadViewHelpers()
    {
		$layout = $this->getResource("layout");
		$view = $layout->getView();
		$view->setHelperPath(
            APPLICATION_PATH . DIRECTORY_SEPARATOR ."views" . DIRECTORY_SEPARATOR . "helpers",
            'Application_View_Helper_'
        );
	}
}