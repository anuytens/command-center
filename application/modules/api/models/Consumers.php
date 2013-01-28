<?php

class Api_Model_Consumers extends Zend_Db_Table_Abstract
{
    protected $_name = "consumers";
    protected $_dependentTables = array("Api_Model_Tokens", "Api_Model_ConsumersNonce");
}