<?php

class Api_UsersController extends Zend_Controller_Action
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
            $model_tokens = new Api_Model_Tokens;
            $row_token = $model_tokens->getTokenByToken($array_authorizationHeader["oauth_token"]);
            
            // get the LDAP account object
            $this->view->results = $this->_helper->retrieveLdapAccountObject($row_token->getUser()->id_ldap);
        }
    }


}



