<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_Entity_User_LDAP_Interface
 */

 /**
 * Interface for Profil instance.
 *
 * @category   Application
 * @package    Application_Model_Entity_User_LDAP_Interface
 */
interface Application_Model_Entity_User_LDAP_Interface
{
    /**
     * Get object id.
     *
     * @return binary
     */
    public function getObjectId();

    /**
     * Get the DN object.
     *
     * @return Zend_Ldap_Dn
     */
    public function getDN();
    
    /**
     * Set the objectid
     *
     * @param  binary $objectid
     * @return Application_Model_Entity_User_LDAP Provides fluent interface
     */
    public function setObjectid($objectid);
    
    /**
     * Set the DN object
     *
     * @param  Zend_Ldap_Dn $dn
     * @return Application_Model_Entity_User_LDAP Provides fluent interface
     */
    public function setDN(Zend_Ldap_Dn $dn);
    
    /**
     * Retrieve the user's informations in an array
     *
     * @return array
     */     
    public function toArray();
}
