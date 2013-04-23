<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_Mapper_User
 */

 /**
 * class to map user instance.
 *
 * @category   Application
 * @package    Application_Model_Mapper_User
 */
class Application_Model_Mapper_User
{
    /**
     * Create the user
     *
     * @param  Application_Model_User $user
     * @return int
     * 
     */
     public function create(Application_Model_User &$user)
     {
     }
     
    /**
     * Save the user
     *
     * @param  Application_Model_User $user
     * @return int
     * 
     */
     public function save(Application_Model_User &$user)
     {
        // On commence la transaction
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        
        try
        {
            // On détermine si on ajoute ou on update un user
            $is_new_user = $user->getId() === null;
                
            $dbTable_Users = new Application_Model_DbTable_Users;
            $dbTable_applications_user = new Application_Model_DbTable_UsersApplications;

            // Save the base row
            $row = $is_new_user ? $dbTable_Users->createRow() : $dbTable_Users->find($user->getId())->current();
            $row->is_active = $user->isActive();
            $row->role = $user->getRole();
            $id = $row->save();
            $user->setId($id);
            
            // suppression des enregistrements de la table porteuse comportant les applications de l'utilisateur
            $where = $db->quoteInto('id_user = ?', $user->getId());
            $dbTable_applications_user->delete($where);

            // Stock the user's applications
            foreach($user->getApplications() as $application)
            {
                if($application->getId() > 0)
                {
                    $row = $dbTable_applications_user->createRow();
                    $row->id_user = $user->getId();
                    $row->id_application = $application->getId();
                    $row->save();
                }
            }

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
     * Delete user
     *
     * @param  Application_Model_User $user
     * 
     */
     final public function delete(Application_Model_User &$user)
     {
        if($user->getId() !== null)
        {
            // On commence la transaction
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            
            try
            {
                $dbTable_Users = new Application_Model_DbTable_Users;
                $row = $dbTable_Users->find($user->getId())->current();
                $row->delete();
                unset($user);

                $db->commit();
            }
            catch(Exception $e)
            {
                $db->rollBack();
                throw $e;
            }
        }
     }
     
     /**
     * Find users with criterias
     *
     * @param  array $criterias
     * @return array<Application_Model_User>
     */
     public function findByCriteria(array $criterias = array())
     {
        $mapper_db = new Application_Model_Mapper_User_Db;
        $mapper_ldap = new Application_Model_Mapper_User_LDAP;
     
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        
        $select = $db->select();
        $select->from("users", "id_user");
            
        // critères
        foreach($criterias as $criteria => $value)
        {
            switch($criteria)
            {
                case "id":
                    $select->where("users.id_user = ?", $value);
                    break;
            }
        }
            
        $results = $db->fetchAll($select);

        if(count($results) > 0)
        {
             $array_returns = array();
             
            foreach($results as $result)
            {
                $id_user = $result->id_user;
                $is_ldap = $db->fetchOne($db->select()->from("usersdb", "count(usersdb.id_userdb)")->where("id_user = ?", $id_user)) > 0 ? false : true;
                
                $criterias["id"] = $id_user;
            
                // si l'utilisateur est un user en DB, on le cherche via le mapper
                // sinon on le fait avec le mapper ldap
                if($is_ldap)
                {
                    $results_of_mapper = $mapper_ldap->findByCriteria($criterias);
                }
                else
                {
                    $results_of_mapper = $mapper_db->findByCriteria($criterias);
                }
                
                if(count($results_of_mapper) == 1)
                {
                    $results_of_mapper[0]->setApplications($this->getApplications($id_user));
                    $array_returns[] = $results_of_mapper[0];
                }
            }
            
            return $array_returns;
        }
        else
        {
            return array();
        }
     }
     
     /**
     * Get user's applications
     *
     * @param  int $id_user
     * @return array<Application_Model_Application>
     * @final
     */
     final public function getApplications($id_user)
     {
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        
        $application_mapper = new Application_Model_Mapper_Application;
        
        $select = $db->select();
        $select->from("users", null)
            ->join("users-applications", "users.id_user = `users-applications`.id_user", "id_application")
            ->where("users.id_user = ?", $id_user);
            
        $array_results = array();
            
        foreach($db->fetchAll($select) as $application)
        {
            $application = $application_mapper->getById($application->id_application);
            
            if(count($application) == 1)
            {
                $array_results[] = $application[0];
            }
            
            $application = null;
        }
        
        return $array_results;
     }
     
    /**
     * Get users by last name
     *
     * @param  string $last_name
     * @return array<Application_Model_User>
     * @final
     */
     final public function getByLastName($last_name)
     {
        return $this->findByCriteria(array(
            "last_name" => $last_name
        ));
     }
     
     /**
     * Get users by id
     *
     * @param  int $id
     * @return array<Application_Model_User>
     * @final
     */
     final public function getById($id)
     {
        return $this->findByCriteria(array(
            "id" => $id
        ));
     }
     
      /**
     * Fetch all users
     *
     * @return array<Application_Model_User>
     * @final
     */
     final public function fetchAll()
     {
        return $this->findByCriteria();
     }
}