<?php

class Api_Model_Tokens extends Zend_Db_Table_Abstract
{
    protected $_name = "tokens";
    protected $_referencemap = array(
        'consumer' => array(
            'columns' => 'id_consumer',
            'refTableClass' => 'Api_Model_Consumers'
		),
        'token-type' => array(
            'columns' => 'id_token-types',
            'refTableClass' => 'Api_Model_TokenTypes'
		),
        'user' => array(
            'columns' => 'id_user',
            'refTableClass' => 'Application_Model_Users'
		)
    );
}