<?php

class Connect_Model_TokenTypes extends Zend_Db_Table_Abstract
{
    protected $_name = "token-types";
    protected $_dependentTables = array("Connect_Model_Tokens");
}
