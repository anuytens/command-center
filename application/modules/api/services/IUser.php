<?php
/**
 * SDIS 62
 *
 * @category   Api
 * @package    Api_Service_IUser
 */

 /**
 * Interface's Service layer for API User
 *
 * @category   Api
 * @package    Api_Service_IUser
 */
interface Api_Service_IUser
{
    public function getAccount($id_user);
    public function verifyCredentials($email, $password);
    public function isAuthorized($id_user, $id_application);
}