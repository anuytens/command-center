<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_Proxy_Profile
 */

 /**
 * Class for Profil instance.
 *
 * @category   Application
 * @package    Application_Model_Proxy_Profile
 */
class Application_Model_Proxy_Profile extends SDIS62_Model_Proxy_Abstract implements Application_Model_Entity_Profile_Interface
{
	/**
	* Type of object
	*
	* @var string
	*/
	public $type_objet = 'Profile';
		
    /**
     * Get the first name
     *
     * @return string
     */
    public function getFirstName()
    {
		$res = $this->getEntity()->getFirstName();
		if($res === null)
		{
			SDIS62_Model_DAO_Abstract::getInstance($this->type_objet)->create($this);
			return $this->getEntity()->getFirstName();
		}
        return $res;
    }

    /**
     * Get the last name
     *
     * @return string
     */
    public function getLastName()
    {
        $res = $this->getEntity()->getLastName();
		if($res === null)
		{
			SDIS62_Model_DAO_Abstract::getInstance($this->type_objet)->create($this);
			return $this->getEntity()->getLastName();
		}
        return $res;
    }

    /**
     * Get the full name
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->getEntity()->getFullName();
    }     
    
    /**
     * Return true if the profil concern a man, else false.
     *
     * @return bool
     */  
    public function isMan()
    {
        $res = $this->getEntity()->isMan();
		if($res === null)
		{
			SDIS62_Model_DAO_Abstract::getInstance($this->type_objet)->create($this);
			return $this->getEntity()->isMan();
		}
        return $res;
    }
    
    /**
     * Return true if the profil concern a woman, else false.
     *
     * @return bool
     */  
    public function isWoman()
    {
        return !$this->isMan();
    }
    
    /**
     * Get the phone number
     *
     * @return string
     */      
    public function getPhone()
    {
        $res = $this->getEntity()->getPhone();
		if($res === null)
		{
			SDIS62_Model_DAO_Abstract::getInstance($this->type_objet)->create($this);
			return $this->getEntity()->getPhone();
		}
        return $res;
    }
    
    /**
     * Get the postal address
     *
     * @return string
     */          
    public function getAddress()
    {
        $res = $this->getEntity()->getAddress();
		if($res === null)
		{
			SDIS62_Model_DAO_Abstract::getInstance($this->type_objet)->create($this);
			return $this->getEntity()->getAddress();
		}
        return $res;
    }
    
    /**
     * Get email.
     *
     * @return string
     */      
    public function getEmail()
    {
        $res = $this->getEntity()->getEmail();
		if($res === null)
		{
			SDIS62_Model_DAO_Abstract::getInstance($this->type_objet)->create($this);
			return $this->getEntity()->getEmail();
		}
        return $res;
    }

    /**
     * Set the first name
     *
     * @param  string $first_name
     * @return Application_Model_Proxy_Profile Provides fluent interface
     */
    public function setFirstName($first_name)
    {
        $this->getEntity()->setFirstName($first_name);
        return $this;
    }
    
    /**
     * Set the last name
     *
     * @param  string $last_name
     * @return Application_Model_Proxy_Profile Provides fluent interface
     */
    public function setLastName($last_name)
    {
        $this->getEntity()->setLastName($last_name);
        return $this;
    }
    
    /**
     * Set the profile to man
     *
     * @return Application_Model_Proxy_Profile Provides fluent interface
     */
    public function setAsMan()
    {
        $this->getEntity()->setAsMan();
        return $this;
    }
 
    /**
     * Set the profile to woman
     *
     * @return Application_Model_Proxy_Profile Provides fluent interface
     */
    public function setAsWoman()
    {
        $this->getEntity()->setAsWoman();
        return $this;
    }
    
    /**
     * Set the phone number
     *
     * @param  string $phone
     * @return Application_Model_Proxy_Profile Provides fluent interface
     */
    public function setPhone($phone)
    {
        $this->getEntity()->setAsWoman($phone);
        return $this;
    }
    
    /**
     * Set the postal address
     *
     * @param  string $address
     * @return Application_Model_Proxy_Profile Provides fluent interface
     */
    public function setAddress($address)
    {
        $this->getEntity()->setAsWoman($address);
        return $this;
    }
    
     /**
     * Set email
     *
     * @param  string $email
     * @return Application_Model_Proxy_Profile Provides fluent interface
     */   
    public function setEmail($email)
    {    
        $this->getEntity()->setAsWoman($email);
        return $this;
    }
}
