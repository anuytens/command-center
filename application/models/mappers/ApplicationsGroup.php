<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_Mapper_ApplicationsGroup
 */

 /**
 * Class to map application group instance.
 *
 * @category   Application
 * @package    Application_Model_Mapper_ApplicationsGroup
 */
class Application_Model_Mapper_ApplicationsGroup
{
    /**
     * Save the group
     *
     * @param  Application_Model_ApplicationsGroup $group
     * @return int
     * 
     */
     public function save(Application_Model_ApplicationsGroup &$group)
     {
        // On commence la transaction
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        
        try
        {
            // On détermine si on ajoute ou on update un user
            $is_new_group = $group->getId() === null;
                
            // initialisation des dbtables
            $dbTable_groups = new Application_Model_DbTable_ApplicationsGroups;
            $dbTable_applications_groups = new Application_Model_DbTable_ApplicationsGroupsApplications;

            // Save the group
            $row = $is_new_group ? $dbTable_groups->createRow() : $dbTable_groups->find($group->getId())->current();
            $row->name = $group->getName();
            $row->color = $group->getColor();
            $id = $row->save();
            $group->setId($id);
            
            // suppression des enregistrements de la table porteuse
            $where = $db->quoteInto('id_applicationsgroup = ?', $group->getId());
            $dbTable_applications_groups->delete($where);
            
            // Stock the users in the group
            foreach($group->getApplications() as $application)
            {
                if($application->getId() > 0)
                {
                    $row = $dbTable_applications_groups->createRow();
                    $row->id_applicationsgroup = $group->getId();
                    $row->id_application = $application->getId();
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
     * @param  Application_Model_ApplicationsGroup $group
     * 
     */
     public function delete(Application_Model_ApplicationsGroup &$group)
     {
        if($group->getId() !== null)
        {
            // On commence la transaction
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            
            try
            {
                $dbTable_group = new Application_Model_DbTable_ApplicationsGroups;
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
     * @return array<Application_Model_ApplicationsGroup>
     * @abstract
     */
     public function findByCriteria(array $criterias = array())
     {  
        $application_mapper = new Application_Model_Mapper_Application;
     
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        
        $select = $db->select();
        $select->from("applicationsgroups")
            ->order("applicationsgroups.name");
            
        // critères
        foreach($criterias as $criteria => $value)
        {
            switch($criteria)
            {
                case "id":
                    $select->where("applicationsgroups.id_applicationsgroup = ?", $value);
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
            
                $group = new Application_Model_ApplicationsGroup;
                $group->setName($result->name);
                $group->setColor($result->color);
                $group->setId($result->id_applicationsgroup);
                
                $select = $db->select();
                $select->from("applicationsgroups", null)
                    ->join("applicationsgroups-applications", "applicationsgroups.id_applicationsgroup = `applicationsgroups-applications`.id_applicationsgroup", "id_application")
                    ->where("applicationsgroups.id_applicationsgroup = ?", $result->id_applicationsgroup);
                    
                foreach($db->fetchAll($select) as $application)
                {
                    $application = $application_mapper->getById($application->id_application);
                    
                    if(count($application) == 1)
                    {
                        $group->add($application[0]);
                    }
                    
                    $application = null;
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
     * @return array<Application_Model_ApplicationsGroup>
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
     * @return array<Application_Model_ApplicationsGroup>
     * @final
     */
     final public function fetchAll()
     {
        return $this->findByCriteria();
     }
}