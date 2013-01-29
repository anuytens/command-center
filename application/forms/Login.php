<?php

class Application_Form_Login extends Zend_Form
{
    public function init()
    {
        $this->setMethod("post");
        
        $username = new Zend_Form_Element_Text('username');
        $username->addFilter(new Zend_Filter_HtmlEntities);
        $username->addValidators(array(new Zend_Validate_StringLength(1,255) , new Zend_Validate_Alpha));
        $username->setLabel("Username : ");
        $username->setRequired(true);
        $this->addElement($username);

        $password = new Zend_Form_Element_Password('password');
        $password->addFilter(new Zend_Filter_HtmlEntities);
        $password->addValidators(array(new Zend_Validate_StringLength(1,255)));
        $password->setLabel("Password : ");
        $password->setRequired(true);
        $this->addElement($password);

        $submit = new Zend_Form_Element_Submit('Se connecter');
        $this->addElement($submit);
    }
}

