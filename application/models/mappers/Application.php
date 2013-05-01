<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_Mapper_Application
 */

 /**
 * Class to map application instance.
 *
 * @category   Application
 * @package    Application_Model_Mapper_Application
 */
class Application_Model_Mapper_Application
{
    /**
     * Save the application
     *
     * @param  Application_Model_Application $application
     * @return int
     * 
     */
     public function save(Application_Model_Application &$application)
     {
        // On commence la transaction
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        
        try
        {
            // On détermine si on ajoute ou on update un user
            $is_new_application = $application->getId() === null;
                
            $dbTable_applications = new Application_Model_DbTable_Applications;

            // Save the base row
            $row = $is_new_application ? $dbTable_applications->createRow() : $dbTable_applications->find($application->getId())->current();
            $row->name = $application->getName();
            $row->url = $application->getUrl();
            $row->is_active = $application->isActive();
            
            if($is_new_application)
            {
                $row->consumer_secret = $application->getConsumerSecret();
                $row->consumer_key = $application->getConsumerKey();
            }

            $id = $row->save();
            $application->setId($id);
            
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
     * @param  Application_Model_Application $application
     * 
     */
     final public function delete(Application_Model_Application &$application)
     {
        if($application->getId() !== null)
        {
            // On commence la transaction
            $db = Zend_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            
            try
            {
                $dbTable_applications = new Application_Model_DbTable_Applications;
                $row = $dbTable_applications->find($application->getId())->current();
                $row->delete();
                unset($application);

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
     * Find applications with criterias
     *
     * @param  array $criterias
     * @return array<Application_Model_Application>
     */
     public function findByCriteria(array $criterias = array())
     {
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        
        $select = $db->select();
        $select->from("applications")
            ->order("applications.id_application");
            
        // critères
        foreach($criterias as $criteria => $value)
        {
            switch($criteria)
            {
                case "id":
                    $select->where("applications.id_application = ?", $value);
                    break;
                    
                case "consumer_key":
                    $select->where("applications.consumer_key = ?", $value);
                    break;
            }
        }
            
        $results = $db->fetchAll($select);

        if(count($results) > 0)
        {
            $array_returns = array();
            
            foreach($results as $result)
            {
                $application = null;
                
                $application = new Application_Model_Application;
                $application->setName($result->name);
                $application->setUrl($result->url);
                $application->setId($result->id_application);
                $application->setConsumerSecret($result->consumer_secret);
                $application->setConsumerKey($result->consumer_key);
                $application->setActiveStatus($result->is_active);
                
                // populate the array
                $array_returns[] = $application;
            }
            
            return $array_returns;
        }
        else
        {
            return array();
        }
     }
     
     /**
     * Get applications by id
     *
     * @param  int $id
     * @return array<Application_Model_Application>
     * @final
     */
     final public function getById($id)
     {
        return $this->findByCriteria(array(
            "id" => $id
        ));
     }
     
      /**
     * Get applications by consumer key
     *
     * @param  string consumer_key
     * @return array<Application_Model_Application>
     * @final
     */
     final public function getByConsumerKey($consumer_key)
     {
        return $this->findByCriteria(array(
            "consumer_key" => $consumer_key
        ));
     }
     
      /**
     * Fetch all applications
     *
     * @return array<Application_Model_Application>
     * @final
     */
     final public function fetchAll()
     {
        return $this->findByCriteria();
     }
}