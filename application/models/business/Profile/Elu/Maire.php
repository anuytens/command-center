<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_Business_Profile_Elu_Maire
 */

 /**
 * Abstract class for Profil instance.
 *
 * @category   Application
 * @package    Application_Model_Business_Profile_Elu_Maire
 */
class Application_Model_Business_Profile_Elu_Maire extends Application_Model_Business_Profile_Elu
{
    /**
     * City.
     *
     * @var string
     */
    private $city;

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
     * @return Application_Model_Business_Profile_Elu_Maire Provides fluent interface
     */    
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }
}