<?php

class Api_Model_Tokens extends Zend_Db_Table_Abstract
{
    protected $_name = "tokens";
    protected $_referenceMap = array(
        'consumer' => array(
            'columns' => 'id_consumer',
            'refTableClass' => 'Api_Model_Consumers',
		),
        'token-type' => array(
            'columns' => 'id_token-types',
            'refTableClass' => 'Api_Model_TokenTypes'
		)
    );
    protected $_dependentTables = array("Api_Model_TokensUser");
    protected $_rowClass = 'Api_Model_Row_Token';
    
    public function getTokenByToken($token)
    {
        $select = $this->select()
            ->where("token = ?", $token);

        return $this->fetchRow($select);
    }
}