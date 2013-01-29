<?php

class Api_OauthController extends Zend_Controller_Action
{
    /**
     * OAuthProvider object
     */
    private $provider;

    /**
     * Initialize the controller
     */
    public function init() {
        // Set underscore for url (request_token and access_token)
        $dispatcher = Zend_Controller_Front::getInstance()->getDispatcher();
        $dispatcher->setWordDelimiter(array('_', '.', '-'))->setPathDelimiter('_');
        
        // Instanciate oauth provider object and setup check functions
        $this->provider = new OAuthProvider();
        $this->provider->consumerHandler(array($this, "_consumerHandler"));
        $this->provider->timestampNonceHandler(array($this, "_timestampNonceHandler"));
        $this->provider->tokenHandler(array($this, "_tokenHandler"));

        // Set the request token path
        $this->provider->setRequestTokenPath($this->_helper->url("request_token"));
    }

    /**
     * Index action
     */
    public function indexAction()
    {
        // NOTHING TO DO HERE !
    }

    /**
     * Request token endpoint
     */
    public function requestTokenAction()
    {
        // Disable the renderer
        $this->_helper->viewRenderer->setNoRender(true);

        // Define the endpoint
        $this->provider->isRequestTokenEndpoint(true); 
        
        // Add the oauth_call param required
        $this->provider->addRequiredParameter("oauth_callback");
        
        // Check the request
        $this->checkRequest();

        // Generate the tokens (request and token)
        $oauth_token = sha1($this->provider->generateToken(20, true));
        $oauth_token_secret = sha1($this->provider->generateToken(20, true));
        
        // output the response
        echo "oauth_token=" . $oauth_token . "&oauth_token_secret=" . $oauth_token_secret . "&oauth_callback_confirmed=true";
    }

    /**
     * Access token endpoint
     */
    public function accessTokenAction()
    {
        // Disable the renderer
        $this->_helper->viewRenderer->setNoRender(true);

        // Check the request
        $this->checkRequest();

        // Generate the tokens (token and access token)
        $oauth_token = sha1($this->provider->generateToken(20,true));
        $oauth_token_secret = sha1($this->provider->generateToken(20,true));

        // output the response
        echo "oauth_token=" . $oauth_token . "&oauth_token_secret=" . $oauth_token_secret;
    }

    /**
     * Authorize action
     */
    public function authorizeAction()
    {
        // Log in
        $form_login = new Application_Form_Login;
        
        $this->view->form = $form_login;
    }
    
    /**
     * Checks the oauth requests
     */
    private function checkRequest()
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
        if ($provider->token === 'rejected')
        {
            return OAUTH_TOKEN_REJECTED;
        }
        elseif ($provider->token === 'revoked')
        {
            return OAUTH_TOKEN_REVOKED;
        }

        $provider->token_secret = "test";
        
        return OAUTH_OK;
    }

}