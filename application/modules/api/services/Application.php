<?php
/**
 * SDIS 62
 *
 * @category   Api
 * @package    Api_Service_Application
 */

 /**
 * Service layer for API Application
 *
 * @category   Api
 * @package    Api_Service_Application
 */
class Api_Service_Application implements Api_Service_IApplication
{
    public function getApplication($id_application)
    {
        $command_center = Application_Service_CommandCenter::getInstance();
        $application = $command_center->getApplicationById($id_application);
        return Zend_Json::Encode($application);
    }
    
    public function getApplicationByConsumerKey($consumer_key)
    {
        $command_center = Application_Service_CommandCenter::getInstance();
        $application = $command_center->getApplicationByConsumerKey($consumer_key);
        return Zend_Json::Encode($application);
    }
}