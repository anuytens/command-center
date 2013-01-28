<?php

class Api_Model_Consumers extends Zend_Controller_Action
{
    protected $_name = "consumers";
    protected $_dependentTables = array("Api_Model_Tokens", "Api_Model_ConsumersNonce");
}