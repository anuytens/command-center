<?php

class Application_Model_DbTable_Users extends Zend_Db_Table_Abstract
{
    protected $_name = "users";
	protected $_dependentTables = array("Api_Model_TokensUser");
    
    public function findByLDAPId($ldap_id)
    {
        $select = $this->select()
            ->where("id_ldap = ?", $ldap_id);

        return $this->fetchRow($select);
    }
}