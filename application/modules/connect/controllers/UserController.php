<?php

class Connect_UserController extends Zend_Controller_Action
{

    public function init()
    {
        // disable the view renderer and activate application/json
        $this->_helper->contextSwitch->addActionContext($this->_request->getActionName(), 'json');
        $this->_helper->contextSwitch->initContext('json');

        // Check the request
        $this->_helper->oauthProvider->checkRequest();
    }

    // forward to show
    public function indexAction()
    {
        $this->_forward("show");
    }

    // REST action
    // GET : show the user's informations
    public function showAction()
    {
        if($this->_request->isGet())
        {
            // get the authorization header's values
            $array_authorizationHeader = $this->_helper->getAuthorizationHeaderAsAssociativeArray();
            
            // get the user by token
            $model_tokens = new Connect_Model_Tokens;
            $row_token = $model_tokens->getTokenByToken($array_authorizationHeader["oauth_token"]);
            $user = $row_token->findApplication_Model_DbTable_UsersViaConnect_Model_TokensUser()->current();

            $service_user = new Application_Service_User;
            
            // get the LDAP account object
            echo Zend_Json::Encode( $service_user->getAccount($user->id_user)->toArray() );
        }
        
        die();
    }
}