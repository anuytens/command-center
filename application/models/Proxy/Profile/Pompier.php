<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_Proxy_Profile_Pompier
 */

 /**
 * Abstract class for Profil instance.
 *
 * @category   Application
 * @package    Application_Model_Proxy_Profile_Pompier
 */
class Application_Model_Proxy_Profile_Pompier extends Application_Model_Proxy_Profile implements Application_Model_Entity_Profile_Pompier_Interface
{
	/**
	* Type of object
	*
	* @var string
	*/
	public static $type_objet = 'Profile_Pompier';

    /**
     * Get grade
     *
     * @return string
     */    
    public function getGrade()
    {
        $res = $this->getEntity()->getGrade();
		if($res == null)
		{
			SDIS62_Model_DAO_Abstract::getInstance($this::$type_objet)->create($this);
			return $this->getEntity()->getGrade();
		}
		return $res;
    }

    /**
     * Set grade
     *
     * @param  string $grade
     * @return Application_Model_Proxy_Profile_Pompier Provides fluent interface
     */    
    public function setGrade($grade)
    {
        $this->getEntity()->setGrade($grade);
        return $this;
    }
}
