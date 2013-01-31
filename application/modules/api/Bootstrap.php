<?php

class Api_Bootstrap extends Zend_Application_Module_Bootstrap
{ 
    public function _initLoadActionHelpers()
    {
        Zend_Controller_Action_HelperBroker::addPath(
			APPLICATION_PATH . DIRECTORY_SEPARATOR . "modules" . 
                DIRECTORY_SEPARATOR . "api" . DIRECTORY_SEPARATOR . 
                "controllers" . DIRECTORY_SEPARATOR . "helpers",
            "Api_Controller_Helper_"
		);
	}
}