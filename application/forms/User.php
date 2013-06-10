<?php

class Application_Form_User extends Twitter_Bootstrap_Form_Horizontal
{
    public function init()
    {
        $this->setMethod("post");
        $this->setAttrib('class', 'form-horizontal form-user');
        
        // ID de l'utilisateur
        $this->addElement('hidden', 'id', array(
            'filters' => array('StripTags'),
            'validators' => array('Int'),
            'value' => 0
        ));
        
        // Type de stockage de l'utilisateur : soit AD ou DB
        $this->addElement('select', 'type', array(
            'label' => 'Stockage de l\'utilisateur',
            'filters' => array('StripTags'),
            'validators' => array('Int'),
            'required' => true,
            'multiOptions' => array(
                0 => "Base de données",
                1 => "Active Directory"
            )
        ));
        
        // champ pour l'id du profil
        $this->addElement('hidden', 'id_profile', array(
            'filters' => array('StripTags'),
            'validators' => array('Int'),
            'value' => 0
        ));

        // =======================================================================
        // Champs pour l'active directory
        // =======================================================================
        
        $ldap_form = new Twitter_Bootstrap_Form_Horizontal;
        $ldap_form->setLegend("Informations requises pour un utilisateur stocké dans l'Active Directory");
        
        // DN
        $ldap_form->addElement('text', 'dn', array(
            'label' => 'DN',
            'class' => 'input-xxlarge',
            'placeholder' => 'ex: CN=Baker\\, Alice,CN=Users+OU=Lab,DC=example,DC=com',
            'description' => 'Le DN (Distinguished Name) d\'un utilisateur est un moyen d\'identifier de façon unique un objet dans la hiérarchie de l\'Active Directory.',
            'required' => true,
            'filters' => array(new Zend_Filter_StripTags),
            'validators' => array(new Zend_Validate_StringLength(1,255) )
        ));
        
        // On ajoute le forumulaire au formulaire de base
        $this->addSubForm($ldap_form, 'ldap');
        
        // =======================================================================
        // Champs pour l'utilisateur en base
        // =======================================================================
        
        $db_form = new Twitter_Bootstrap_Form_Horizontal;
        $db_form->setLegend("Informations requises pour un utilisateur a stocker dans la base de données");
        
        // Son sexe
        $db_form->addElement('select', 'gender', array(
            'label' => 'Civilité',
            'filters' => array('StripTags'),
            'validators' => array('Int'),
            'required' => true,
            'multiOptions' => array(
                0 => "Madame",
                1 => "Monsieur"
            )
        ));
        
        // Nom
        $db_form->addElement('text', 'last_name', array(
            'label' => 'Nom',
            'required' => true,
            'filters' => array(new Zend_Filter_StripTags),
            'validators' => array(new Zend_Validate_StringLength(1,45) )
        ));
        
        // Prénom
        $db_form->addElement('text', 'first_name', array(
            'label' => 'Prénom',
            'required' => true,
            'filters' => array(new Zend_Filter_StripTags),
            'validators' => array(new Zend_Validate_StringLength(1,45) )
        ));
        
        // email
        $db_form->addElement('text', 'email', array(
            'label' => 'Courriel',
            'prepend' => '@',
            'required' => true,
            'filters' => array(new Zend_Filter_StripTags),
            'validators' => array(new Zend_Validate_StringLength(1,45), new Zend_Validate_EmailAddress)
        ));

        // Mot de passe
        $db_form->addElement('password', 'password', array(
            'label' => 'Mot de passe',
            'required' => true,
            'filters' => array(new Zend_Filter_StripTags),
            'validators' => array(new Zend_Validate_StringLength(1,100) )
        ));
        
        // phone
        $db_form->addElement('text', 'phone', array(
            'label' => 'Numéro de téléphone',
            'required' => false,
            'filters' => array(new Zend_Filter_StripTags),
            'validators' => array(new Zend_Validate_StringLength(1,20) )
        ));
        
        // adresse
        $db_form->addElement('text', 'address', array(
            'label' => 'Adresse postale',
            'class'         => 'input-xxlarge',
            'required' => false,
            'filters' => array(new Zend_Filter_StripTags),
            'validators' => array(new Zend_Validate_StringLength(1,255) )
        ));
        
        // Choix du type de profil
        $db_form->addElement('select', 'typeprofile', array(
            'label' => 'Type de profil',
            'filters' => array('StripTags'),
            'validators' => array('Int'),
            'required' => true,
            'multiOptions' => array(
                1 => "Aucune spécialité",
                2 => "Pompier",
                3 => "Élu"
            ),
            'value' => 1
        ));
        
        // =======================================================================
        // Champs pour un élu
        // =======================================================================
        
        $db_elu_form = new Twitter_Bootstrap_Form_Horizontal;
        
        // Type de l'élu
        $db_elu_form->addElement('select', 'typeprofileelu', array(
            'label' => 'Type de profil de l\'élu',
            'description' => 'Ce champ ne concerne que les Élus.',
            'filters' => array('StripTags'),
            'validators' => array('Int'),
            'required' => true,
            'multiOptions' => array(
                0 => "Maire",
                1 => "Préfet"
            )
        ));
        
        // on ajoute le formulaire au formulaire de l'utilisateur en base
        $db_elu_form->setIsArray(true);
        $db_elu_form->removeDecorator('form'); 
        $db_elu_form->addDecorator(new Zend_Form_Decorator_HtmlTag(array("class" => "db_elu")));
        $db_form->addSubForm($db_elu_form, 'db_elu');
        
        // =======================================================================
        // Champs pour un élu - maire
        // =======================================================================
        
        $db_elu_maire_form = new Twitter_Bootstrap_Form_Horizontal;
        
        // sa commune
        $db_elu_maire_form->addElement('text', 'city', array(
            'label' => 'Ville du Maire',
            'placeholder' => 'ex: Arras',
            'description' => 'Ce champ ne concerne que les utilisateurs étant Maires.',
            'required' => false,
            'filters' => array(new Zend_Filter_StripTags),
            'validators' => array(new Zend_Validate_StringLength(1,100) )
        ));
        
        // on ajoute le formulaire au formulaire de l'utilisateur en base
        $db_elu_maire_form->setIsArray(true);
        $db_elu_maire_form->removeDecorator('form');   
        $db_elu_maire_form->addDecorator(new Zend_Form_Decorator_HtmlTag(array("class" => "db_elu_maire")));
        $db_elu_form->addSubForm($db_elu_maire_form, 'db_elu_maire');
        
        // =======================================================================
        // Champs pour un élu - prefet
        // =======================================================================
        
        $db_elu_prefet_form = new Twitter_Bootstrap_Form_Horizontal;
        
        // son département
        $db_elu_prefet_form->addElement('text', 'department', array(
            'label' => 'Département du Préfet',
            'placeholder' => 'ex: Pas-de-Calais',
            'description' => 'Ce champ ne concerne que les utilisateurs étant Préfets.',
            'required' => true,
            'filters' => array(new Zend_Filter_StripTags),
            'validators' => array(new Zend_Validate_StringLength(1,100) )
        ));
        
        // on ajoute le formulaire au formulaire de l'utilisateur en base
        $db_elu_prefet_form->setIsArray(true);
        $db_elu_prefet_form->removeDecorator('form');
        $db_elu_prefet_form->addDecorator(new Zend_Form_Decorator_HtmlTag(array("class" => "db_elu_prefet")));
        $db_elu_form->addSubForm($db_elu_prefet_form, 'db_elu_prefet');
        
        // =======================================================================
        // Champs pour un pompier
        // =======================================================================
        
        $db_pompier = new Twitter_Bootstrap_Form_Horizontal;
         
        $db_pompier->addElement('text', 'grade', array(
            'label' => 'Grade',
            'placeholder' => 'ex: Colonel',
            'description' => 'Ce champ ne concerne que les utilisateurs Pompiers.',
            'required' => true,
            'filters' => array(new Zend_Filter_StripTags),
            'validators' => array(new Zend_Validate_StringLength(1,45) )
        ));

        // on ajoute le formulaire au formulaire de l'utilisateur en base
        $db_pompier->setIsArray(true);
        $db_pompier->removeDecorator('form');   
        $db_pompier->addDecorator(new Zend_Form_Decorator_HtmlTag(array("class" => "db_pompier")));
        $db_form->addSubForm($db_pompier, 'db_pompier');
        
        
         // On ajoute le forumulaire au formulaire de base
        $this->addSubForm($db_form, 'db');

        // Droit de l'utilisateur
        $this->addElement('select', 'role', array(
            'label' => 'Droit de l\'utilisateur',
            'filters' => array('StripTags'),
            'validators' => array('Int'),
            'required' => true,
            'multiOptions' => array(
                Application_Model_Role::GUEST => "GUEST",
                Application_Model_Role::USER => "USER"
            )
        ));
        
        // Actif ou pas ?
        $this->addElement('checkbox', 'status', array(
            'label' => 'Utilisateur actif ?',
            'filters' => array('StripTags'),
            'validators' => array('Int'),
            'value' => 1
        ));
        
        
        $this->addElement(new Twitter_Bootstrap_Form_Element_Submit("Sauvegarder", array(
            "buttonType" => Twitter_Bootstrap_Form_Element_Submit::BUTTON_PRIMARY
        )), 'submit');
        
        $this->setSubFormDecorators(array(
            'FormElements',
            'Fieldset'
        ));
        
        $this->addDisplayGroup(
            array('submit', 'reset'),
            'actions',
            array(
                'disableLoadDefaultDecorators' => true,
                'decorators' => array('Actions')
            )
        );
    }
}