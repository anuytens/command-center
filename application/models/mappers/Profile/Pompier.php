<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_Mapper_Profile_Pompier
 */

 /**
 * Class to map Pompier profile instance.
 *
 * @category   Application
 * @package    Application_Model_Mapper_Profile_Pompier
 */
class Application_Model_Mapper_Profile_Pompier extends Application_Model_Mapper_Profile
{
    /**
     * Save the profile
     *
     * @param  int $id_userdb
     * @param  Application_Model_Profile_Pompiers $profile
     * @return int
     * @abstract
     * 
     */
     public function save($id_userdb, Application_Model_Profile_Pompier &$profile)
     {
        // On détermine si on ajoute ou on update un user
        $is_new_profile = $profile->getId() === null;

        // on savegarde le profile de base
        $id = parent::save($id_userdb, $profile);
        
        // On commence la transaction
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        
        try
        {
            $dbTable_profiles = new Application_Model_DbTable_Profiles;
            $dbTable_profiles_pompiers = new Application_Model_DbTable_Profiles_Pompiers;

            // Save the base row
            $row = $dbTable_profiles->find($id)->current();
            $rowPompier = $is_new_profile ? $dbTable_profiles_pompiers->createRow() : $row->findDependentRowset("Application_Model_DbTable_ProfilesPompiers")->current();
            $rowPompier->grade = $profile->getGrade();
            $rowPompier->id_profile = $id;
            
            $id = $rowPompier->save();
            
            $db->commit();
            
            return $id;
        }
        catch(Exception $e)
        {
            $db->rollBack();
            throw $e;
        }
     }
}