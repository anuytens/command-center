<?php

class Api_Model_TokenTypes extends Zend_Controller_Action
{
    protected $_name = "token-types";
    protected $_dependentTables = array("Api_Model_Tokens");
}
