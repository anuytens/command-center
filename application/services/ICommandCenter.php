<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Service_ICommandCenter
 */

 /**
 * Interface's Service layer for Command Center
 *
 * @category   Application
 * @package    Application_Service_ICommandCenter
 */
interface Application_Service_ICommandCenter
{
    /* default functions */
    public function getCache();
    public function setCache(Zend_Cache_Core $cache);
    public static function getInstance();
    
    /* app's logic */
    public function getAllUsers();
    public function saveUser(array $data);
    public function deleteUser(Application_Model_User &$user);
    public function isUserAuthenticated();
    public function getUserById($id_user);
    public function getUserByLastName($last_name);
    public function getUserByEmail($email);
    public function getUsersByGroupId($id_group);
    public function getUsersApplications($id_user);
    public function isUserAuthorized($id_user, $id_application);
    public function getUserForm($id_user = null);
    public function saveUsersGroup(array $data);
    public function deleteUsersGroup(Application_Model_UsersGroup &$group);
    public function getAllUsersGroups();
    public function getUsersGroupById($id_group = null);
    public function getUsersGroupForm($id_group = null);
    public function saveACL(array $data);
    public function getACLForm($populate = false);
    public function verifyUserCredentials($email, $password);
    public function getAllApplications();
    public function saveApplication(array $data);
    public function deleteApplication(Application_Model_Application &$application);
    public function getApplicationById($id_application);
    public function getApplicationsByGroupId($id_group = null);
    public function getApplicationForm($id_application = null);
    public function getAllApplicationsGroups();
    public function getApplicationsGroupById($id_group);
    public function saveApplicationsGroup(array $data);
    public function deleteApplicationsGroup(Application_Model_ApplicationsGroup &$group);
    public function getApplicationsGroupForm($id_group = null);
}