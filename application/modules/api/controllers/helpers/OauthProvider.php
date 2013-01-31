<?php

class Api_Controller_Helper_OauthProvider extends Zend_Controller_Action_Helper_Abstract
{

    private $provider;
    
    public function init()
    {
        // Instanciate oauth provider object and setup check functions
        $this->provider = new OAuthProvider();
        $this->provider->consumerHandler(array($this, "_consumerHandler"));
        $this->provider->timestampNonceHandler(array($this, "_timestampNonceHandler"));
        $this->provider->tokenHandler(array($this, "_tokenHandler"));
    }
    
    public function getProvider()
    {
        return $this->provider;
    }
    
        /**
     * Checks the oauth requests
     */
    public function checkRequest()
    {
        try
        {
            $this->provider->checkOAuthRequest();
        }
        catch(OAuthException $exception)
        {
            Zend_Debug::Dump( $this->provider->reportProblem($exception) );
            die();
        }
    }
    
    /**
     * Check if the application is registered
     */
    public function _consumerHandler($provider)
    {

        // fetch the current consumer
        $model_consumer = new Api_Model_Consumers;
        $row_consumer = $model_consumer->getConsumerByConsumerKey($provider->consumer_key);
    
        // If consumer is unknown or inactive
        if ($row_consumer == null)
        {
            return OAUTH_CONSUMER_KEY_UNKNOWN;
        }
        else if($row_consumer->is_active == false)
        {
            return OAUTH_CONSUMER_KEY_REFUSED;
        }

        // current consumer 
        $provider->consumer_secret = $row_consumer->consumer_secret;

        return OAUTH_OK;
    }
    
     /**
     * Check whether the timestamp of the request is sane and falls within the window of our Nonce checks
     */
    public function _timestampNonceHandler($provider)
    {
    
        // fetch the current consumer
        $model_consumer = new Api_Model_Consumers;
        $row_consumer = $model_consumer->getConsumerByConsumerKey($provider->consumer_key);

        // Prepare SQl for check if nonce exists for consumer
        $model_consumersNonce = new Api_Model_ConsumersNonce;
        
        $select = $model_consumersNonce->select()
            ->where("id_consumer = ?", $row_consumer->id_consumer)
            ->where("timestamp = ?", $this->provider->timestamp)
            ->where("nonce = ?", $provider->nonce);
    
        // ignore all requests older than 5 minutes
        if ($this->provider->timestamp < time() - 5 * 60)
        {
            return OAUTH_BAD_TIMESTAMP;
        }
        elseif (null != ($model_consumersNonce->fetchRow($select)))
        {
            return OAUTH_BAD_NONCE;
        }
        
        // Add the new nonce to the db
        $row_newConsumernonce = $model_consumersNonce->createRow();
        $row_newConsumernonce->nonce = $this->provider->nonce;
        $row_newConsumernonce->id_consumer = $row_consumer->id_consumer;
        $row_newConsumernonce->save();

        return OAUTH_OK;
    }
    
    /**
     * check whether a request or access token is valid
     */
    public function _tokenHandler($provider)
    {
        // get the request token
        $model_tokens = new Api_Model_Tokens;
        $row_token = $model_tokens->getTokenByToken($provider->token);
            
        // token not found
        if ($row_token == null)
        {
            return OAUTH_TOKEN_REJECTED;
        }
        
        // get the consumer
        $row_consumer = $row_token->findParentApi_Model_Consumers();
        
        // The consumer must be the same as the one this request token was originally issued for
        if($row_consumer->consumer_key != $provider->consumer_key)
        {
            return OAUTH_TOKEN_REJECTED;
        }
        // bad verifier for request token
        elseif($row_token["id_token-types"] == 1 && $row_token->token_verifier != $provider->verifier)
        {
            return OAUTH_VERIFIER_INVALID;
        }
        elseif ($row_token["id_token-types"] == 2 && $row_token->is_used == false)
        {
            return OAUTH_TOKEN_REVOKED;
        }
        elseif($row_token["id_token-types"] == 1 && $row_token->is_used == true)
        {
            return OAUTH_TOKEN_USED;
        }

        $provider->token_secret = $row_token->token_secret;
        
        return OAUTH_OK;
    }

}