<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_Entity_Profile_Elu_Maire
 */

 /**
 * Abstract class for Profil instance.
 *
 * @category   Application
 * @package    Application_Model_Entity_Profile_Elu_Maire
 */
class Application_Model_Entity_Profile_Elu_Maire extends Application_Model_Entity_Profile_Elu implements Application_Model_Entity_Profile_Elu_Maire_Interface
{
    /**
     * City.
     *
     * @var string
     */
    public $city;

    /**
     * Get the mayor's city
     *
     * @return string
     */    
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set the city
     *
     * @param  string $city
     * @return Application_Model_Entity_Profile_Elu_Maire Provides fluent interface
     */    
    public function setCity($city)
    {
        $this->city = $city;
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
		$array['city'] = $this->city;
		return $array;
	}
}
