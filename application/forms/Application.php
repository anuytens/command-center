<?php

class Application_Form_Application extends Twitter_Bootstrap_Form_Horizontal
{
    public function init()
    {
        $this->setMethod("post");
        
        // ID de l'application
        $this->addElement('hidden', 'id', array(
            'filters' => array('StripTags'),
            'validators' => array('Int'),
            'value' => 0
        ));
        
        $this->addElement('text', 'name', array(
            'label' => 'Nom',
            'required' => true,
            'filters' => array(new Zend_Filter_StripTags),
            'validators' => array(new Zend_Validate_StringLength(1,45))
        ));
        
        $this->addElement('text', 'url', array(
            'label' => 'URL',
            'placeholder' => 'ex: http://xxxxx.sdis62.fr',
            'required' => true,
            'filters' => array(new Zend_Filter_StripTags),
            'validators' => array(
                new Zend_Validate_StringLength(1,45),
                array(
                    'Callback',
                    true,
                    array(
                        'callback' => function($value) {
                            return Zend_Uri::check($value);
                        }
                    ),
                    'messages' => array(
                        Zend_Validate_Callback::INVALID_VALUE => 'Please enter a valid URL'
                    )
                )
            )
        ));
        
        // Actif ou pas ?
        $this->addElement('checkbox', 'status', array(
            'label' => 'Application active ?',
            'filters' => array('StripTags'),
            'validators' => array('Int'),
            'value' => 1
        ));
        
        // Accessible ou pas ?
        $this->addElement('checkbox', 'access', array(
            'label' => 'Application accessible ?',
            'description' => 'Rendre une application accessible génère des clés servant pour l\'authorisation de connexion. Ces clés sont générées qu\'une seule fois. Ceci est valable que pour les applications de l\'écosystème.',
            'filters' => array('StripTags'),
            'validators' => array('Int'),
            'value' => 1
        ));
        
        $this->addElement(new Twitter_Bootstrap_Form_Element_Submit("Sauvegarder", array(
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