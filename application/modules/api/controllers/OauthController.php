<?php

class Api_OauthController extends Zend_Controller_Action
{

    /**
    * OAuthProvider object
    */
    private $provider;
    
    /**
    * Boolean wich care of error statement
    */
    private $oauth_error;

    /**
    * Initialize the controller
    */
    public function init()
    {
        /* Initialize action controller here */
        
        // Set underscore for url (request_token and access_token)
        $dispatcher = Zend_Controller_Front::getInstance()->getDispatcher();
        $dispatcher->setWordDelimiter('_')->setPathDelimiter('');
        
        // Set privates members
        $this->provider = new OAuthProvider();
        $this->oauth_error = false;
        
        // Check if the application is registered
        $this->provider->consumerHandler(function($provider) {
        
            // fetch the current consumer
            $model_consumer = new Api_Model_Consumers;
            $row_consumer = $model_consumer->fetchRow("consumer_key = ?", $provider->consumer_key);
        
            // If consumer is unknown
            if ($row_consumer == null)
            {
                return OAUTH_CONSUMER_KEY_UNKNOWN;
            }
            // or inactive
            else if($row_consumer->active == false)
            {
                return OAUTH_CONSUMER_KEY_REFUSED;
            }

            // current consumer 
            $provider->consumer_secret = $row_consumer->consumer_secret;

            return OAUTH_OK;
        });

        //  check whether the timestamp of the request is sane and falls within the window of our Nonce checks
        $this->provider->timestampNonceHandler(function($provider) {
        
            $model_consumersNonce = new Api_Model_ConsumersNonce;
        
            // ignore all requests older than 5 minutes
            if ($provider->timestamp < time() - 5 * 60)
            {
                return OAUTH_BAD_TIMESTAMP;
            }
            elseif (null != ($model_consumersNonce->fetchAll("id_consumer = ? and timestamp = ?")))
            {
                return OAUTH_BAD_NONCE;
            }

            return OAUTH_OK;
        });

        // check whether a request or access token is valid
        $this->provider->tokenHandler(function($provider) {
            if ($provider->token === 'rejected') {
            return OAUTH_TOKEN_REJECTED;
            } elseif ($provider->token === 'revoked') {
            return OAUTH_TOKEN_REVOKED;
            }

            $provider->token_secret = "test";
            return OAUTH_OK;
        });

        $this->provider->setRequestTokenPath($this->_helper->url("request_token"));
    }

    /**
    * Index action
    */
    public function indexAction()
    {
        // action body
    }

    /**
    * Request token endpoint
    */
    public function requestTokenAction()
    {
        // action body
    }

    /**
    * Access token endpoint
    */
    public function accessTokenAction()
    {
        // action body
    }

    /**
    * Authorize action
    */
    public function authorizeAction()
    {
        // action body
    }


}







