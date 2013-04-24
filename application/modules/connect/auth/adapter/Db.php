<?php
/**
 * SDIS 62
 * Credit to : http://stackoverflow.com/questions/3328047/creating-own-zend-auth-adapter
 *
 * @category   Connect
 * @package    Connect_Auth_Adapter_Db
 */
 
  /**
 * Adapter to authenticate the user with two tables
 *
 * @category   Connect
 * @package    Connect_Auth_Adapter_Db
 */
class Connect_Auth_Adapter_Db implements Zend_Auth_Adapter_Interface
{
    private $email;
    private $password;

    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function authenticate()
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        
        try
        {
            // user who try to auth
            $user_service = new Application_Service_User;
            $user = $user_service->getAccountByEmail($this->email);
            
            if($user->isActive())
            {
                // user tmp
                $profile_tmp = new Application_Model_Profile;
                $profile_tmp->setEmail($this->email);
                $user_tmp = new Application_Model_User_Db($profile_tmp);
                $user_tmp->setPassword($this->password);
                
                if ($user_tmp->getPassword() == $user->getPassword())
                {
                    return new Zend_Auth_Result(Zend_Auth_Result::SUCCESS, $user->toArray());
                }
                else
                {
                    return new Zend_Auth_Result(Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID, null);
                }
            }
            else
            {
                return new Zend_Auth_Result(Zend_Auth_Result::FAILURE, null);
            }
        } 
        catch (NonUniqueResultException $e)
        {
            return new Zend_Auth_Result(Zend_Auth_Result::FAILURE, null);
        }
        catch (NoResultException $e)
        {
            return new Zend_Auth_Result(Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND, null);
        }
        catch (Exception $e)
        {
            return new Zend_Auth_Result(Zend_Auth_Result::FAILURE, null);
        }
    }
} 