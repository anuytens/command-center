<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_Entity_Profile_Elu_Prefet
 */

 /**
 * Abstract class for Profil instance.
 *
 * @category   Application
 * @package    Application_Model_Entity_Profile_Elu_Prefet
 */
class Application_Model_Entity_Profile_Elu_Prefet extends Application_Model_Entity_Profile_Elu implements Application_Model_Entity_Profile_Elu_Prefet_Interface
{
    /**
     * Department.
     *
     * @var string
     */
    public $department;

    /**
     * Get the prefet's department
     *
     * @return string
     */    
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * Set the department
     *
     * @param  string $department
     * @return Application_Model_Entity_Profile_Elu_Prefet Provides fluent interface
     */    
    public function setDepartment($department)
    {
        $this->department = $department;
        return $this;
    }
    
    /**
	* Hydrate an array who contain informations to add at entity
	*
	* @params Array $array
	* @return SDIS62_Model_Entity_Abstract Provides fluent interface
	*/
    public function hydrate($array)
	{
		foreach($array as $n => $v)
		{
			$this->$n = $v;
		}
		return $this;
	}
	
	/**
	* Extract an array from entity who contain informations about the entity
	*
	* @return Array
	*/
	public function extract()
	{
		$array = parent::extract();
		$array['department'] = $this->department;
		return $array;
	}
}
