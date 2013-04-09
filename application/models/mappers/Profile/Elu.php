<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_Mapper_Profile_Elu
 */

 /**
 * Abstract class to map elu instance.
 *
 * @category   Application
 * @package    Application_Model_Mapper_Profile_Elu
 */
abstract class Application_Model_Mapper_Profile_Elu extends Application_Model_Mapper_Profile
{
    /**
     * Save the profile
     *
     * @param  int $id_userdb
     * @param  Application_Model_Business_Profile_Elu $profile
     * @return int
     * @abstract
     * 
     */
     public function save($id_userdb, Application_Model_Business_Profile_Elu &$profile)
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
            $dbTable_profiles_elus = new Application_Model_DbTable_ProfilesElus;

            // Get the parent row
            $row = $dbTable_profiles->find($id)->current();
            $rowElu = $is_new_profile ? $dbTable_profiles_elus->createRow() : $row->findDependentRowset("Application_Model_DbTable_ProfilesElus")->current();
            $rowElu->id_profile = $id;
            
            $id = $rowElu->save();
            
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