<?php

class IdentityController extends SDIS62_Oauth_Consumer_Controller_Abstract
{
    protected $redirection_url = array("auth");

    public function authAction()
    {
        // get my session
        $session = new Zend_Session_Namespace();
        
		// get the instance of auth
        $auth = Zend_Auth::getInstance();
        
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
            $data["ACCESS_TOKEN"] = $access_token;
            Zend_Auth::getInstance()->getStorage()->write($data);
            
            // Unset the access token the session
            unset($session->ACCESS_TOKEN);

            $this->_helper->redirector("index", "index");
        }
        else
        {
            $this->_helper->redirector("index");
        }
    }

    public function logoutAction()
    {
        // get the instance of auth
        $auth = Zend_Auth::getInstance();

        // clear the identity
        $auth->clearIdentity();

        // Forget the session lifetime
        // Zend_Session::forgetMe();
                
        $this->_helper->flashMessenger(array(
            'context' => 'success',
            'title' => 'Au revoir !',
            'message' => 'Vous avez été correctement deconnecté.'
        ));
        
        // redirect to index
        $this->_helper->redirector("index", "index");
    }
}