<?php

class Connect_Model_Tokens extends Zend_Db_Table_Abstract
{
    protected $_name = "tokens";
    protected $_referenceMap = array(
        'consumer' => array(
            'columns' => 'id_application',
            'refTableClass' => 'Connect_Model_Consumers',
		),
        'token-type' => array(
            'columns' => 'id_token-types',
            'refTableClass' => 'Connect_Model_TokenTypes'
		)
    );
    protected $_dependentTables = array("Connect_Model_TokensUser");
    protected $_rowClass = 'Connect_Model_Row_Token';
    
    public function getTokenByToken($token)
    {
        $select = $this->select()
            ->where("token = ?", $token);

        return $this->fetchRow($select);
    }
}