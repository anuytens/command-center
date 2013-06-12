<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_Proxy_User_LDAP
 */

 /**
 * Class for Profil instance.
 *
 * @category   Application
 * @package    Application_Model_Proxy_User_LDAP
 */
class Application_Model_Proxy_User_LDAP extends Application_Model_Proxy_User implements Application_Model_Entity_User_LDAP_Interface
{
	/**
	* Type of object
	*
	* @var string
	*/
	public $type_objet = 'User_LDAP';
    
    /**
     * Get object id.
     *
     * @return binary
     */
    public function getObjectId()
    {
        $res = $this->getEntity()->getObjectId();
		if($res == null)
		{
			SDIS62_Model_DAO_Abstract::getInstance($this->type_objet)->create($this);
			return $this->getEntity()->getObjectId();
		}
		return $res;
    }

    /**
     * Get the DN object.
     *
     * @return Zend_Ldap_Dn
     */
    public function getDN()
    {
        $res = $this->getEntity()->getDN();
		if($res == null)
		{
			SDIS62_Model_DAO_Abstract::getInstance($this->type_objet)->create($this);
			return $this->getEntity()->getDN();
		}
		return $res;
    }
    
    /**
     * Set the objectid
     *
     * @param  binary $objectid
     * @return Application_Model_Proxy_User_LDAP Provides fluent interface
     */
    public function setObjectid($objectid)
    {
        $this->getEntity()->setObjectid($objectid);
        return $this;
    }
    
    /**
     * Set the DN object
     *
     * @param  Zend_Ldap_Dn $dn
     * @return Application_Model_Proxy_User_LDAP Provides fluent interface
     */
    public function setDN(Zend_Ldap_Dn $dn)
    {
        $this->getEntity()->setDN($dn);
        return $this;
    }
}
