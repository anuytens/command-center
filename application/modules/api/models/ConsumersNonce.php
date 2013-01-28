<?php

class Api_Model_ConsumersNonce extends Zend_Db_Table_Abstract
{
    protected $_name = "consumers-nonce";
    protected $_referencemap = array(
        'consumer' => array(
            'columns' => 'id_consumer',
            'refTableClass' => 'Api_Model_Consumers'
		)
    );
}