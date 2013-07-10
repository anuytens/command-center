<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_Entity_Profile
 */

 /**
 * Class for Profil instance.
 *
 * @category   Application
 * @package    Application_Model_Entity_Profile
 */
class Application_Model_Entity_Profile extends SDIS62_Model_Entity_Abstract implements Application_Model_Entity_Profile_Interface
{
    /**
     * First name.
     *
     * @var string
     */
    public $first_name;

    /**
     * Last name.
     *
     * @var string
     */
    public $last_name;

    /**
     * If the profile concern a man, the var equal true
     *
     * @var bool
     */
    public $is_man;

    /**
     * Phone.
     *
     * @var string
     */
    public $phone;

    /**
     * Postal address.
     *
     * @var string
     */
    public $address;

    /**
     * Email.
     *
     * @var string
     */
    public $email;
    
    /**
     * ID of userdb
     *
     * @var string
     */
    public $id_userdb;

    /**
     * Get the first name
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Get the last name
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Get the full name
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->first_name . " " . $this->last_name;
    }     
    
    /**
     * Return true if the profil concern a man, else false.
     *
     * @return bool
     */  
    public function isMan()
    {
        return $this->is_man;
    }
    
    /**
     * Return true if the profil concern a woman, else false.
     *
     * @return bool
     */  
    public function isWoman()
    {
        return !$this->is_man;
    }
    
    /**
     * Get the phone number
     *
     * @return string
     */      
    public function getPhone()
    {
        return $this->phone;
    }
    
    /**
     * Get the postal address
     *
     * @return string
     */          
    public function getAddress()
    {
        return $this->address;
    }
    
    /**
     * Get email.
     *
     * @return string
     */      
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the first name
     *
     * @param  string $first_name
     * @return Application_Model_Entity_Profile Provides fluent interface
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
        return $this;
    }
    
    /**
     * Set the last name
     *
     * @param  string $last_name
     * @return Application_Model_Entity_Profile Provides fluent interface
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
        return $this;
    }
    
    /**
     * Set the profile to man
     *
     * @return Application_Model_Entity_Profile Provides fluent interface
     */
    public function setAsMan()
    {
        $this->is_man = true;
        return $this;
    }
 
    /**
     * Set the profile to woman
     *
     * @return Application_Model_Entity_Profile Provides fluent interface
     */
    public function setAsWoman()
    {
        $this->is_man = false;
        return $this;
    }
    
    /**
     * Set the phone number
     *
     * @param  string $phone
     * @return Application_Model_Entity_Profile Provides fluent interface
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }
    
    /**
     * Set the postal address
     *
     * @param  string $address
     * @return Application_Model_Entity_Profile Provides fluent interface
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }
    
     /**
     * Set email
     *
     * @param  string $email
     * @return Application_Model_Entity_Profile Provides fluent interface
     */   
    public function setEmail($email)
    {    
        $this->email = $email;
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
		return array(
			'first_name' => $this->first_name,
			'last_name' => $this->last_name,
			'is_man' => $this->is_man,
			'phone' => $this->phone,
			'address' => $this->address,
			'email' => $this->email
		);
	}
}
