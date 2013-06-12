<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_Proxy_User_Db
 */

 /**
 * Class for Profil instance.
 *
 * @category   Application
 * @package    Application_Model_Proxy_User_Db
 */
class Application_Model_Proxy_User_Db extends Application_Model_Proxy_User implements Application_Model_Entity_User_Db_Interface
{
	/**
	* Type of object
	*
	* @var string
	*/
	public $type_objet = 'User_Db';
    
    /**
     * Get user's password
     *
     * @return string
     */
    public function getPassword()
    {
        $res = $this->getEntity()->getPassword();
		if($res == null)
		{
			SDIS62_Model_DAO_Abstract::getInstance($this->type_objet)->create($this);
			return $this->getEntity()->getPassword();
		}
		return $res;
    }
    
    /**
     * Set the user's password
     *
     * @param  string $password
     * @param  bool $hashed
     * @return Application_Model_Proxy_User_Db Provides fluent interface
     */
    public function setPassword($password, $hashed = true)
    {
        $this->getEntity()->setPassword($password, $hashed);
        return $this;
    }
}
