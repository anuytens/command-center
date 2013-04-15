<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_Mapper_Profile_Elu_Maire
 */

 /**
 * Abstract class to map maire profile instance.
 *
 * @category   Application
 * @package    Application_Model_Mapper_Profile_Elu_Maire
 */
class Application_Model_Mapper_Profile_Elu_Maire extends Application_Model_Mapper_Profile_Elu
{
    /**
     * Save the profile
     *
     * @param  int $id_userdb
     * @param  Application_Model_Profile_Elu $profile
     * @return int
     * @abstract
     * 
     */
     public function save($id_userdb, Application_Model_Profile_Elu &$profile)
     {
         // On détermine si on ajoute ou on update un user
        $is_new_profile = $profile->getId() === null;

        // on savegarde le profil de base
        $id = parent::save($id_userdb, $profile);
        
        // On commence la transaction
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        
        try
        {
            $dbTable_profiles_elus = new Application_Model_DbTable_ProfilesElus;
            $dbTable_profiles_elus_maires = new Application_Model_DbTable_ProfilesElusMaires;

            // Get the parent row
            $row = $dbTable_profiles_elus->find($id)->current();
            $rowEluMaire = $is_new_profile ? $dbTable_profiles_elus_maires->createRow() : $row->findDependentRowset("Application_Model_DbTable_ProfilesElusMaires")->current();
            $rowEluMaire->city = $profile->getCity();
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