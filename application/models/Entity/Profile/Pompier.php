<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_Entity_Profile_Pompier
 */

 /**
 * Abstract class for Profil instance.
 *
 * @category   Application
 * @package    Application_Model_Entity_Profile_Pompier
 */
class Application_Model_Entity_Profile_Pompier extends Application_Model_Entity_Profile implements Application_Model_Entity_Profile_Pompier_Interface
{
    /**
     * Grade.
     *
     * @var string
     */
    public $grade;

    /**
     * Get grade
     *
     * @return string
     */    
    public function getGrade()
    {
        return $this->grade;
    }

    /**
     * Set grade
     *
     * @param  string $grade
     * @return Application_Model_Entity_Profile_Pompier Provides fluent interface
     */    
    public function setGrade($grade)
    {
        $this->grade = $grade;
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
		$array['grade'] = $this->grade;
		return $array;
	}
}
