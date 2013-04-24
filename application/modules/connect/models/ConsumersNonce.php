<?php

class Connect_Model_ConsumersNonce extends Zend_Db_Table_Abstract
{
    protected $_name = "consumers-nonce";
    protected $_referenceMap = array(
        'consumer' => array(
            'columns' => 'id_application',
            'refTableClass' => 'Connect_Model_Consumers'
		)
    );
}