<?php

class Connect_Controller_Helper_GetAuthorizationHeaderAsAssociativeArray extends Zend_Controller_Action_Helper_Abstract
{
    public function direct()
    {
        $result = array();
    
        // get Authorization header
        $header = $this->getRequest()->getHeader("Authorization");
        
        // explode by ","
        $headerValues = explode(",", $header);
        
        // parse
        foreach($headerValues as $headerValue)
        {
            $key = strstr($headerValue, "=", true);
            preg_match("/$key=\"(.*)\"/", $headerValue, $value);
            
            $result[$key] = $value[1];
        }
        
        return $result;
    }
}