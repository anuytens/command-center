<?php

class Application_Form_UsersGroup extends Twitter_Bootstrap_Form_Horizontal
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

        $this->addElement('textarea', 'description', array(
            'label' => 'Description',
            'required' => true,
            'filters' => array(new Zend_Filter_StripTags),
            'attribs' => array('cols' => '8', 'rows' => '8')
        ));
        
        // Liste des utilisateurs
        $user_service = new Application_Service_User;
        $users = array();
        foreach($user_service->getAllUsers() as $users_non_parse)
        {
            $users[$users_non_parse->getId()] = $users_non_parse->getProfile()->getFullName();
        }
        
        $this->addElement('multiselect', 'users', array(
            'label' => 'Utilisateurs du groupe',
            'filters' => array('StripTags'),
            'validators' => array('Int'),
            'required' => true,
            'multiOptions' => $users,
            "class" => "chosen input-xxlarge",
            "data-placeholder" => "Choisir les utilisateurs du groupe ..."
        ));
        
        // Droit du groupe entier
        $this->addElement('select', 'role', array(
            'label' => 'Droit du groupe',
            'filters' => array('StripTags'),
            'validators' => array('Int'),
            'required' => true,
            'multiOptions' => array(
                Application_Model_Role::GUEST => "GUEST",
                Application_Model_Role::USER => "USER"
            )
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