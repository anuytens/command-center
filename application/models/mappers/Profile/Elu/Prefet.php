<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_Mapper_Profile_Elu_Prefet
 */

 /**
 * Abstract class to map prefet profile instance.
 *
 * @category   Application
 * @package    Application_Model_Mapper_Profile_Elu_Prefet
 */
class Application_Model_Mapper_Profile_Elu_Prefet extends Application_Model_Mapper_Profile_Elu
{
    /**
     * Save the profile
     *
     * @param  Application_Model_Business_Profile_Elu_Prefet $profile
     * @return int
     * 
     */
     public function save(Application_Model_Business_Profile_Elu_Prefet &$profile)
     {
         // On détermine si on ajoute ou on update un user
        $is_new_profile = $profile->getId() === null;

        // on savegarde le profil de base
        $id = parent::save($profile);
        
        // On commence la transaction
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        
        try
        {
            $dbTable_profiles_elus = new Application_Model_DbTable_ProfilesElus;
            $dbTable_profiles_elus_prefets = new Application_Model_DbTable_ProfilesElusPrefets;

            // Get the parent row
            $row = $dbTable_profiles_elus->find($id)->current();
            $rowEluMaire = $is_new_profile ? $dbTable_profiles_elus_prefets->createRow() : $row->findDependentRowset("Application_Model_DbTable_ProfilesElusPrefets")->current();
            $rowEluMaire->department = $profile->getDepartment();
            $rowEluMaire->id_profileelu = $id;
            
            $id = $rowEluMaire->save();
            
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