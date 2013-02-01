<?php

class Application_Controller_Helper_RetrieveLdapAccountObject extends Zend_Controller_Action_Helper_Abstract
{
    public function direct($id_ldap)
    {
        // Get the config wichi contains secrets keys !
        $path_to_config = APPLICATION_PATH . DIRECTORY_SEPARATOR . "configs" . DIRECTORY_SEPARATOR . "secret.ini";
        $secret_config = new Zend_Config_Ini($path_to_config, APPLICATION_ENV);
        
        // Connect to ldap
        $ldap = new Zend_Ldap($secret_config->ldap->toArray());

        // Search entries with objectguid filter ( one entry expected !)
        $array_entries = $ldap->search(Zend_Ldap_Filter::equals('objectGUID', $id_ldap))->toArray();
        
        if(count($array_entries) == 1)
        {
            $returnObject = new stdClass();
        
            // avoid array with only one value
            foreach ($array_entries[0] as $attr => $value) {
                if (is_array($value))
                {
                    $returnObject->$attr = (count($value) > 1) ? $value : $value[0];
                }
                else
                {
                    $returnObject->$attr = $value;
                }
            }
            
            return $returnObject;
        }
        else
        {
            return false;
        }
    }
}