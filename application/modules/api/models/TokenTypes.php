<?php

class Api_Model_TokenTypes extends Zend_Db_Table_Abstract
{
    protected $_name = "token-types";
    protected $_dependentTables = array("Api_Model_Tokens");
}
