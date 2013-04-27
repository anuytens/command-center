<?php
/**
 * SDIS 62
 *
 * @category   Connect
 * @package    Connect_Service_Connect
 */

 /**
 * Service connect
 *
 * @category   Connect
 * @package    Connect_Service_Connect
 */
class Connect_Service_Connect
{
    /**
     * login form
     *
     * @var Zend_Form
     */
    private $form;
    
    /**
     * auth instance
     *
     * @var Zend_Auth
     */
    private $auth;
    
    /**
     * Construct the connect service
     *
     * @return Application_Service_User
     * 
     */    
    public function __construct()
    {
        $this->form = new Connect_Form_Login;
        $this->auth = Zend_Auth::getInstance();
    }

    /**
     * Return the login form
     *
     * @return Zend_Form
     * 
     */        
    public function getLoginForm()
    {
        return $this->form;
    }

    /**
     * Proceed the auth
     *
     * @return bool
     * 
     */   
    public function login($data)
    {
        // if the user is authenticated, redirect to index action
        if($this->auth->hasIdentity())
        {
            return true;
        }
        
        if($this->getLoginForm()->isValid($data))
        {
            // perform login
            return $this->proceedLogin(
                $data["email"],
                $data["password"],
                //$data["remember_me"]
                false
            );
        }

        return false;
    }
    
    private function proceedLogin($email, $password, $remember_me)
    {
        $auth = Zend_Auth::getInstance();
        $auth_result = null;
        
        $connect_session = new Zend_Auth_Storage_Session('connect');
        $auth->setStorage($connect_session);
    
        // Do I proceed LDAP auth ?
        /*
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
        */


        // if user est application_model_user_db
        if(true)
        {
            // get the auth adapter instance
            require_once APPLICATION_PATH . DIRECTORY_SEPARATOR . "modules" . DIRECTORY_SEPARATOR . 
            "connect" . DIRECTORY_SEPARATOR . "auth" . DIRECTORY_SEPARATOR . "adapter" . 
            DIRECTORY_SEPARATOR . "Db.php";
            $auth_adapter_db = new Connect_Auth_Adapter_Db($email, $password);
            
            // try to authenticate user
            $auth_result = $auth_adapter_db->authenticate($auth_adapter_db);
        }

        if($auth_result->isValid())
        {
            // persist the user
            $auth->getStorage()->write($auth_result->getIdentity());
            
            // remember the user ?
            /*
            if($remember_me == 1)
            {
                $seconds  = 60 * 60 * 24 * 7; // 7 days
                Zend_Session::rememberMe($seconds);
            }
            else
            {
                Zend_Session::forgetMe();
            }
            */
            
            return true;
        }
        
        return false;
    }
    
    /**
     * Logout
     *
     * 
     */    
    public function logout()
    {
        // get the instance of auth
        $this->auth = Zend_Auth::getInstance();
        
        // clear the identity
        $auth->clearIdentity();
        
        // Forget the session lifetime
        Zend_Session::forgetMe();

        // redirect to index
        $this->_helper->redirector("index", "index");
    }
}