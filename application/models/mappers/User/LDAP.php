<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_Mapper_User_LDAP
 */

 /**
 * Class to map user LDAP instance.
 *
 * @category   Application
 * @package    Application_Model_Mapper_User_LDAP
 */
class Application_Model_Mapper_User_LDAP extends Application_Model_Mapper_User
{
    /**
     * Save the user
     *
     * @param  Application_Model_Business_User_LDAP $user
     * @return int
     * 
     */
     public function save(Application_Model_Business_User_LDAP &$user)
     {    
        // On détermine si on ajoute ou on update un user
        $is_new_user = $user->getId() === null;
        
        $id = parent::save($user);

        // On commence la transaction
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        
        try
        {
            $dbTable_Users = new Application_Model_DbTable_Users;
            $dbTable_UsersLDAP = new Application_Model_DbTable_UsersLDAP;
            
            // Save the usersdb row
            $row = $dbTable_Users->find($id)->current();
            $rowUserLDAP = $is_new_user ? $dbTable_UsersLDAP->createRow() : $row->findDependentRowset("Application_Model_DbTable_UsersLDAP")->current();
            $rowUserLDAP->objectid = $user->getObjectId();
            $rowUserLDAP->dn = $user->getDN();
            $rowUserLDAP->id_user = $id;
            $id_usersldap = $rowUserLDAP->save();

            $db->commit();
            
            return $id;
        }
        catch(Exception $e)
        {
            $db->rollBack();
            throw $e;
        }
     }
     
      /**
     * Find users with criterias
     *
     * @param  array $criterias
     * @return array<Application_Model_Business_User>
     */
     public function findByCriteria(array $criterias)
     {
        // VOIR AVEC AURELIE
     }
}