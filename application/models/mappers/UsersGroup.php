<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_Mapper_UsersGroup
 */

 /**
 * Class to map users group class.
 *
 * @category   Application
 * @package    Application_Model_Mapper_UsersGroup
 */
class Application_Model_Mapper_UsersGroup
{
    /**
     * Save the group
     *
     * @param  Application_Model_UsersGroup $group
     * @return int
     * 
     */
     public function save(Application_Model_UsersGroup &$group)
     {
        // On commence la transaction
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        
        try
        {
            // On détermine si on ajoute ou on update un user
            $is_new_group = $group->getId() === null;
                
            // initialisation des dbtables
            $dbTable_groups = new Application_Model_DbTable_UsersGroups;
            $dbTable_users_groups = new Application_Model_DbTable_UsersGroupsUsers;

            // Save the group
            $row = $is_new_group ? $dbTable_groups->createRow() : $dbTable_groups->find($group->getId())->current();
            $row->name = $group->getName();
            $row->description = $group->getDesc();
            $row->role = $group->getRole();
            $id = $row->save();
            $group->setId($id);
            
            // suppression des enregistrements de la table porteuse
            $where = $db->quoteInto('id_usersgroup = ?', $group->getId());
            $dbTable_users_groups->delete($where);
            
            // Stock the users in the group
            foreach($group->getUsers() as $user)
            {
                if($user->getId() > 0)
                {
                    $row = $dbTable_users_groups->createRow();
                    $row->id_usersgroup = $group->getId();
                    $row->id_user = $user->getId();
                    $row->save();
                }
            }
            
            $db->commit();
            
            return $group->getId();
        }
        catch(Exception $e)
        {
            $db->rollBack();
            throw $e;
        }
     }
     
     /**
     * Delete group
     *
     * @param  Application_Model_UsersGroup $group
     * 
     */
     final public function delete(Application_Model_UsersGroup &$group)
     {
        if($group->getId() !== null)
        {
            // On commence la transaction
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            
            try
            {
                $dbTable_group = new Application_Model_DbTable_UsersGroups;
                $row = $dbTable_group->find($group->getId())->current();
                $row->delete();
                unset($group);

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
     * Find groups with criterias
     *
     * @param  array $criterias
     * @return array<Application_Model_UsersGroup>
     * @abstract
     */
     public function findByCriteria(array $criterias = array())
     {  
        $user_mapper = new Application_Model_Mapper_User;
     
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        
        $select = $db->select();
        $select->from("usersgroups")
            ->order("usersgroups.id_usersgroup");
            
        // critères
        foreach($criterias as $criteria => $value)
        {
            switch($criteria)
            {
                case "id":
                    $select->where("usersgroups.id_usersgroup = ?", $value);
                    break;
            }
        }
            
        $results = $db->fetchAll($select);

        if(count($results) > 0)
        {
            $array_returns = array();
            
            foreach($results as $result)
            {
                $group = null;
            
                $group = new Application_Model_UsersGroup;
                $group->setName($result->name);
                $group->setDesc($result->description);
                $group->setRole($result->role);
                $group->setId($result->id_usersgroup);
                
                $select = $db->select();
                $select->from("usersgroups", null)
                    ->join("usersgroups-users", "usersgroups.id_usersgroup = `usersgroups-users`.id_usersgroup", "id_user")
                    ->where("usersgroups.id_usersgroup = ?", $result->id_usersgroup);
                    
                foreach($db->fetchAll($select) as $user)
                {
                    $user = $user_mapper->getById($user->id_user);
                    
                    if(count($user) == 1)
                    {
                        $group->add($user[0]);
                    }
                    
                    $user = null;
                }
                
                $array_returns[] = $group;
            }
            
            return $array_returns;
        }
        else
        {
            return array();
        }
     }
     
      /**
     * Get group by id
     *
     * @param  int $id
     * @return array<Application_Model_UsersGroup>
     * @final
     */
     final public function getById($id)
     {
        return $this->findByCriteria(array(
            "id" => $id
        ));
     }
     
    /**
     * Fetch all
     *
     * @return array<Application_Model_UsersGroup>
     * @final
     */
     final public function fetchAll()
     {
        return $this->findByCriteria();
     }
}