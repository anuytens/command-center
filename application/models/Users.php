<?php

abstract class Application_Model_Users
{

    // Metadatas
    private $first_name;
    private $last_name;
    private $phone;
    private $address;
    private $is_ldap_user;
    
    // getters and setters (http://www.shuchow.com/gettersetter.html)
    public function getFirstName() { return $this->first_name; } 
    public function getLastName() { return $this->last_name; } 
    public function getPhone() { return $this->phone; } 
    public function getAddress() { return $this->address; } 
    public function isLdapUser() { return $this->is_ldap_user; } 
    public function setFirstName($x) { $this->first_name = $x; return $this; } 
    public function setLastName($x) { $this->last_name = $x; return $this; }  
    public function setPhone($x) { $this->phone = $x; return $this; }  
    public function setAddress($x) { $this->address = $x; return $this; } 
    public function setLdapUser($x) { $this->is_ldap_user = $x; return $this; } 

    // behaviors
    
}