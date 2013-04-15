<?php
/**
 * SDIS 62
 *
 * @category   Application
 * @package    Application_Model_Abstract
 */

 /**
 * Abstract class to business class.
 *
 * @category   Application
 * @package    Application_Model_Abstract
 */
abstract class Application_Model_Abstract
{
    /**
     * Object unique id
     *
     * @var int
     */
    private $id;

     /**
     * Get the unique id
     *
     * @return int
     */          
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the unique id for the current model
     *
     * @param  int $id
     * @return Application_Model_Abstract Provides fluent interface
     */    
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
}