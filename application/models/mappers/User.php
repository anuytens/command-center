<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_Mapper_User
 */

 /**
 * Abstract class to map user instance.
 *
 * @category   Application
 * @package    Application_Model_Mapper_User
 * @abstract
 */
abstract class Application_Model_Mapper_User
{
    /**
     * Create the user
     *
     * @param  Application_Model_Business_User $user
     * @return int
     * 
     */
     public function create(Application_Model_Business_User &$user)
     {
     }
     
    /**
     * Save the user
     *
     * @param  Application_Model_Business_User $user
     * @return int
     * 
     */
     public function save(Application_Model_Business_User &$user)
     {
        // On commence la transaction
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        
        try
        {
            // On détermine si on ajoute ou on update un user
            $is_new_user = $user->getId() === null;
                
            $dbTable_Users = new Application_Model_DbTable_Users;

            // Save the base row
            $row = $is_new_user ? $dbTable_Users->createRow() : $dbTable_Users->find($user->getId())->current();
            $row->is_active = $user->isActive();
            $row->role = $user->getRole();

            $id = $row->save();
            $user->setId($id);
            
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
     * @param  Application_Model_Business_User $user
     * 
     */
     final public function delete(Application_Model_Business_User &$user)
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
     * @return array<Application_Model_Business_User>
     * @abstract
     */
     abstract public function findByCriteria(array $criterias);
     
    /**
     * Get users by last name
     *
     * @param  string $last_name
     * @return array<Application_Model_Business_User>
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
     * @return array<Application_Model_Business_User>
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
     * @return array<Application_Model_Business_User>
     * @final
     */
     final public function fetchAll()
     {
        return $this->findByCriteria();
     }
}