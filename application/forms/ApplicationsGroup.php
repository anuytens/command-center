<?php

class Application_Form_ApplicationsGroup extends Twitter_Bootstrap_Form_Horizontal
{
    public function init()
    {
        $this->setMethod("post");
        
        // ID du groupe
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
        
        // Liste des applications
        $commandcenter_service = Application_Service_CommandCenter::getInstance();
        $applications = array();
        foreach($commandcenter_service->getAllApplications() as $application_non_parse)
        {
            $applications[$application_non_parse->getId()] = $application_non_parse->getName();
        }
        
        $this->addElement('multiselect', 'applications', array(
            'label' => 'Applications du groupe',
            'filters' => array('StripTags'),
            'validators' => array('Int'),
            'required' => true,
            'multiOptions' => $applications,
            "class" => "chosen input-xxlarge",
            "data-placeholder" => "Choisir les applications du groupe ..."
        ));
        
        $this->addElement('text', 'color', array(
            'label' => 'Couleur du groupe',
            //'attribs' => array('type' => 'color'),
            'filters' => array(new Zend_Filter_StripTags),
            'validators' => array(new Zend_Validate_StringLength(7)),
            'placeholder' => 'ex: #000000'
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