<?php
/**
 * SDIS 62
 *
 * @category   Api
 * @package    Api_Service_User
 */

 /**
 * Service layer for API User
 *
 * @category   Api
 * @package    Api_Service_User
 */
class Api_Service_User implements Api_Service_IUser
{
    public function getAccount($id_user)
    {
        $command_center = Application_Service_CommandCenter::getInstance();
        $user = $command_center->getUserById($id_user);
        return Zend_Json::Encode($user);
    }
    
    public function verifyCredentials($email, $password)
    {
        $command_center = Application_Service_CommandCenter::getInstance();
        $check = $command_center->verifyUserCredentials($email, $password);
        return Zend_Json::Encode($check);
    }
    
    public function isAuthorized($id_user, $id_application)
    {
        $command_center = Application_Service_CommandCenter::getInstance();
        $check = $command_center->isUserAuthorized($id_user, $id_application);
        return Zend_Json::Encode($check);
    }
}