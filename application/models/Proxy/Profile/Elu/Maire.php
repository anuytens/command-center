<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_Proxy_Profile_Elu_Maire
 */

 /**
 * Abstract class for Profil instance.
 *
 * @category   Application
 * @package    Application_Model_Proxy_Profile_Elu_Maire
 */
class Application_Model_Proxy_Profile_Elu_Maire extends Application_Model_Proxy_Profile_Elu implements Application_Model_Entity_Profile_Elu_Maire_Interface
{
	/**
	* Type of object
	*
	* @var string
	*/
	public static $type_objet = 'Profile_Elu_Maire';

    /**
     * Get the mayor's city
     *
     * @return string
     */    
    public function getCity()
    {
        $res = $this->getEntity()->getCity();
		if($res == null)
		{
			SDIS62_Model_DAO_Abstract::getInstance($this::$type_objet)->create($this);
			return $this->getEntity()->getCity();
		}
		return $res;
    }

    /**
     * Set the city
     *
     * @param  string $city
     * @return Application_Model_Proxy_Profile_Elu_Maire Provides fluent interface
     */    
    public function setCity($city)
    {
        $this->getEntity()->setCity($city);
        return $this;
    }
}
