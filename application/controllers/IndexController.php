<?php

class IndexController extends Zend_Controller_Action
{
    /**
     * Initialize the controller
     */
    public function init()
    {
        /* Initialize action controller here */
    }
    
    /**
     * index
     */
    public function indexAction()
    {
        $command_center = Application_Service_CommandCenter::getInstance();
        // $command_center->getUser();
    }

}