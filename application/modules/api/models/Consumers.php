<?php

class Api_Model_Consumers extends Zend_Db_Table_Abstract
{
    protected $_name = "consumers";
    protected $_dependentTables = array("Api_Model_Tokens", "Api_Model_ConsumersNonce");
    
    public function getConsumerByConsumerKey($consumer_key)
    {
        $select = $this->select()
            ->where("consumer_key = ?", $consumer_key);

        return $this->fetchRow($select);
    }
}