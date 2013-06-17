<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_Entit_User_Db
 */

 /**
 * Class for Profil instance.
 *
 * @category   Application
 * @package    Application_Model_Entit_User_Db
 */
class Application_Model_Entity_User_Db extends Application_Model_Entity_User implements Application_Model_Entity_User_Db_Interface
{
    /**
     * User's password
     *
     * @var string
     */
    public $password;
    
    /**
     * ID of user
     *
     * @var string
     */
    public $id_user;
    
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
     * @param  bool $hashed
     * @return Application_Model_Entit_User_Db Provides fluent interface
     */
    public function setPassword($password, $hashed = true)
    {
        if($hashed)
        {
            // Get the SALT for password's hash
            $config = new Zend_Config_Ini(APPLICATION_PATH . DIRECTORY_SEPARATOR . 'configs' . DIRECTORY_SEPARATOR . 'secret.ini', APPLICATION_ENV);
            $salt = $config->security->salt;
            
            // Get the user's login
            $login = $this->getLogin();
        
            // Set the password with salt
            $this->password = md5($login . $salt . $password);
        }
        else
        {
            $this->password = $password;
        }
        
        return $this;
    }
}
