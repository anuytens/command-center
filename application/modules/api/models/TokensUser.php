<?php

class Api_Model_TokensUser extends Zend_Db_Table_Abstract
{
    protected $_name = "tokens-user";
    protected $_referenceMap = array(
        'user' => array(
            'columns' => 'id_user',
            'refTableClass' => 'Application_Model_Users'
		),
        'token' => array(
            'columns' => 'id_token',
            'refTableClass' => 'Api_Model_Tokens'
		)
    );
}