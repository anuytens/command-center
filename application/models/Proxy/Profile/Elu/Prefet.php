<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_Proxy_Profile_Elu_Prefet
 */

 /**
 * Abstract class for Profil instance.
 *
 * @category   Application
 * @package    Application_Model_Proxy_Profile_Elu_Prefet
 */
class Application_Model_Proxy_Profile_Elu_Prefet extends Application_Model_Proxy_Profile_Elu implements Application_Model_Entity_Profile_Elu_Prefet_Interface
{
	/**
	* Type of object
	*
	* @var string
	*/
	public static $type_objet = 'Profile_Elu_Prefet';
		
    /**
     * Department.
     *
     * @var string
     */
    private $department;

    /**
     * Get the prefet's department
     *
     * @return string
     */    
    public function getDepartment()
    {
        $res = $this->getEntity()->getDepartment();
		if($res == null)
		{
			SDIS62_Model_DAO_Abstract::getInstance($this::$type_objet)->create($this);
			return $this->getEntity()->getDepartment();
		}
		return $res;
    }

    /**
     * Set the department
     *
     * @param  string $department
     * @return Application_Model_Proxy_Profile_Elu_Prefet Provides fluent interface
     */    
    public function setDepartment($department)
    {
        $this->getEntity()->setDepartement($departement);
        return $this;
    }
}
