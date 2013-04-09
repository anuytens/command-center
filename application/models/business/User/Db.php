<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_Business_User_Db
 */

 /**
 * Class for Profil instance.
 *
 * @category   Application
 * @package    Application_Model_Business_User_Db
 */
class Application_Model_Business_User_Db extends Application_Model_Business_User
{
    /**
     * User's password
     *
     * @var string
     */
    private $password;
    
    /**
     * Get user's password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
    
    /**
     * Set the user's password
     *
     * @param  string $password
     * @return Application_Model_Business_User_Db Provides fluent interface
     */
    public function setPassword($password)
    {
        // Get the SALT for password's hash
        $config = new Zend_Config_Ini(APPLICATION_PATH . DIRECTORY_SEPARATOR . 'configs' . DIRECTORY_SEPARATOR . 'secret.ini', APPLICATION_ENV);
        $salt = $config->security->salt;
        
        // Get the user's login
        $login = $this->getLogin();
        
        // Set the password with salt
        $this->password = md5($login . $salt . $password);
        
        return $this;
    }
}