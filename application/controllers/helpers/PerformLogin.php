<?php

class Application_Controller_Helper_PerformLogin extends Zend_Controller_Action_Helper_Abstract
{
    public function direct($email, $password, $remember_me, $only_ldap_account = false)
    {
        // Get the config wichi contains secrets keys !
        $path_to_config = APPLICATION_PATH . DIRECTORY_SEPARATOR . "configs" . DIRECTORY_SEPARATOR . "secret.ini";
        $secret_config = new Zend_Config_Ini($path_to_config, APPLICATION_ENV);
            
        // Do I proceed LDAP auth ?
        if(null != ($username = strstr($email, '@sdis62.fr', true)))
        {
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
                // get the user model
                $model_users = new Application_Model_Users;
            
                // get the LDAP account object
                $user_ldap = $auth_adapter_ldap->getAccountObject();
                
                // try to retrieve the user into the db
                $row_user = $model_users->findUserByLDAPId($user_ldap->objectguid);

                // if the user is not in the db, the app store his info
                if($row_user == null)
                {
                    $row_user = $model_users->createRow();
                    $row_user->id_ldap = $user_ldap->objectguid;
                    $row_user->save();
                }
                
                // User attributes
                $user = new StdClass;
                $user->id = $row_user->id_user;
                $user->mail = $user_ldap->mail;
                $user->first_name = $user_ldap->givenname;
                $user->last_name = $user_ldap->sn;
                $user->display_name = $user_ldap->sn . " " . $user_ldap->givenname;
                
                // persist the user
                $auth->getStorage()->write($user);
                
                // remember the user ?
                if($remember_me == 1)
                {
                    $seconds  = 60 * 60 * 24 * 7; // 7 days
                    Zend_Session::rememberMe($seconds);
                }
                else
                {
                    Zend_Session::forgetMe();
                }
                
                return true;
            }
        }
        
        if(!$only_ldap_account)
        {
            // get the auth instance
            $auth = Zend_Auth::getInstance();
            $auth_adapter_db = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());
            
            // Set the users's columns
            $auth_adapter_db->setTableName('users')
                ->setIdentityColumn('non_ldap_mail')
                ->setCredentialColumn('non_ldap_password')
                ->setCredentialTreatment("MD5(CONCAT(?, '" . $secret_config->security->salt . "'))");
                
            // Set the users's credentials
            $auth_adapter_db->setIdentity($email)
                ->setCredential($password);
                
            // try to authenticate user
            $auth_result = $auth->authenticate($auth_adapter_db);
            
            if($auth_result->isValid())
            {
                // User attributes
                $user = new StdClass;
                $user->id = $auth_result->id_user;
                $user->mail = $auth_result->non_ldap_mail;
                $user->first_name = $auth_result->non_ldap_firstname;
                $user->last_name = $auth_result->non_ldap_lastname;
                $user->display_name = $auth_result->non_ldap_lastname . " " . $auth_result->non_ldap_firstname;
                
                // persist the user
                $auth->getStorage()->write($user);
                
                // remember the user ?
                if($remember_me == 1)
                {
                    $seconds  = 60 * 60 * 24 * 7; // 7 days
                    Zend_Session::rememberMe($seconds);
                }
                else
                {
                    Zend_Session::forgetMe();
                }
                
                return true;
            }
        }
        
        return false;
    }
}