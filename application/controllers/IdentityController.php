<?php

class IdentityController extends SDIS62_Oauth_Consumer_Controller_Abstract
{
    protected $stock_access_token_url = array("stock-access-token");
    
    public function stockAccessTokenAction()
    {
        // get my session
        $session = new Zend_Session_Namespace();
        
        // if we have not request_token
        if($session->ACCESS_TOKEN)
        {
            // Get the access token
            $access_token = unserialize($session->ACCESS_TOKEN);
            
            // Get the user account
            $connect = new SDIS62_Service_Connect($access_token, array(
                'callbackUrl' => $this->config_file->oauth->callback,
                'siteUrl' => $this->config_file->oauth->siteurl,
                'consumerKey' => $this->config_file->oauth->consumerkey, // consumer key
                'consumerSecret' => $this->config_file->oauth->consumersecret // consumer secret
            ));
            
            // Store the user and the access token
            $data = $connect->getAccount();
            $data->ACCESS_TOKEN = $session->ACCESS_TOKEN;
            $data->navigation = $connect->getNavigation();
            Zend_Auth::getInstance()->getStorage()->write($data);
            
            // Unset the access token the session
            unset($session->ACCESS_TOKEN);
        }
 
        $this->_helper->redirector("index", "index");
    }
}