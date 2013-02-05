<?php

class Application_Form_Login extends Twitter_Bootstrap_Form_Horizontal
{
    public function init()
    {
        $this->setMethod("post");
        
        $this->addElement('text', 'username', array(
            'label' => 'Identifiant SDIS 62',
            'required' => true,
            'filters' => array(new Zend_Filter_HtmlEntities, new Zend_Filter_StripTags),
            'validators' => array(new Zend_Validate_StringLength(1,255) , new Zend_Validate_Alpha)
        ));
        
        $this->addElement('password', 'password', array(
            'label' => 'Mot de passe',
            'required' => true,
            'filters' => array(new Zend_Filter_HtmlEntities, new Zend_Filter_StripTags),
            'validators' => array(new Zend_Validate_StringLength(1,255))
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