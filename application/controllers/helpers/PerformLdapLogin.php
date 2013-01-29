<?php

class Application_Controller_Helper_PerformLdapLogin extends Zend_Controller_Action_Helper_Abstract
{
    public function direct($username, $password)
    {
        // Get the config wichi contains secrets keys !
        $path_to_config = APPLICATION_PATH . DIRECTORY_SEPARATOR . "configs" . DIRECTORY_SEPARATOR . "secret.ini";
        $secret_config = new Zend_Config_Ini($path_to_config, APPLICATION_ENV);
        
        // get the auth instance
        $auth = Zend_Auth::getInstance();
        $auth_adapter_ldap = new Zend_Auth_Adapter_Ldap();
        
        // Connect to ldap
        $auth_adapter_ldap->setOptions(array( "ldap_server_sdis62" => $secret_config->ldap->toArray()));
        
        // Set the users's credentials
        $auth_adapter_ldap->setUsername($username);
        $auth_adapter_ldap->setPassword($password);
        
        // try to authenticate user
        $auth_result = $auth->authenticate($auth_adapter_ldap);

        if($auth_result->isValid())
        {
            $user = $auth_adapter_ldap->getAccountObject();
            $auth->getStorage()->write($user);
        }
    }
}