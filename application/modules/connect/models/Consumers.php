<?php

class Connect_Model_Consumers extends Zend_Db_Table_Abstract
{
    protected $_name = "applications";
    protected $_dependentTables = array("Connect_Model_Tokens", "Connect_Model_ConsumersNonce");
    
    public function getConsumerByConsumerKey($consumer_key)
    {
        $select = $this->select()
            ->where("consumer_key = ?", $consumer_key);

        return $this->fetchRow($select);
    }
    
    public function getByToken($token)
    {
        $select = $this->select()
            ->setIntegrityCheck(false)
            ->join("tokens", "tokens.id_application = applications.id_application", null)
            ->where("tokens.token = ?", $token);

        return $this->fetchRow($select);
    }
}