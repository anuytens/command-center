<?php

class Application_Form_Login extends Twitter_Bootstrap_Form_Horizontal
{
    public function init()
    {
        $this->setMethod("post");
        
        $this->addElement('text', 'email', array(
            'label' => 'Courriel',
            'required' => true,
            'filters' => array(new Zend_Filter_HtmlEntities, new Zend_Filter_StripTags),
            'validators' => array(new Zend_Validate_StringLength(1,255) , new Zend_Validate_EmailAddress)
        ));
        
        $this->addElement('password', 'password', array(
            'label' => 'Mot de passe',
            'required' => true,
            'filters' => array(new Zend_Filter_HtmlEntities, new Zend_Filter_StripTags),
            'validators' => array(new Zend_Validate_StringLength(1,255))
        ));
        
        $this->addElement('checkbox', 'remember_me', array(
            'label' => 'Se souvenir de moi',
            'filters' => array(new Zend_Filter_HtmlEntities, new Zend_Filter_StripTags),
            'validators' => array(new Zend_Validate_Int)
        ));
        
        $this->addElement(new Twitter_Bootstrap_Form_Element_Submit("Connexion", array(
                "buttonType" => Twitter_Bootstrap_Form_Element_Submit::BUTTON_PRIMARY
        )), 'submit');
                
        $this->addDisplayGroup(
            array('submit'),
            'actions',
            array(
                'disableLoadDefaultDecorators' => true,
                'decorators' => array('Actions')
            )
        );

    }
}