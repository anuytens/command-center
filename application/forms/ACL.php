<?php

class Application_Form_ACL extends Twitter_Bootstrap_Form_Horizontal
{
    public function init()
    {
        $this->setMethod("post");

        $application_service = new Application_Service_Application;
        $user_service = new Application_Service_User;
        $usersgroup_service = new Application_Service_UsersGroup;
        
        // Valeurs du select
        $select = array();
        $select["users"] = array();
        $select["groups"] = array();
        foreach($user_service->getAllUsers() as $user_non_parse)
        {
            $select["users"]["user_" . $user_non_parse->getId()] = $user_non_parse->getProfile()->getFullName();
        }
        foreach($usersgroup_service->getAllGroups() as $group_non_parse)
        {
            $select["groups"]["group_" . $group_non_parse->getId()] = $group_non_parse->getName();
        }
        
        // Elements
        foreach($application_service->getAllApplications() as $application)
        {
            $this->addElement('multiselect', $application->getId(), array(
                'label' => $application->getName(),
                'filters' => array('StripTags'),
                'multiOptions' => array(
                    "Utilisateurs" => $select["users"],
                    "Groupes d'utilisateurs" => $select["groups"]
                ),
                "class" => "chosen input-xxlarge",
                "data-placeholder" => "Choisir les utilisateurs ou les groupes pouvant accéder à cette application ...",
                'belongsTo' => 'application'
            ));
        }

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