<?php

class ApplicationTest extends PHPUnit_Framework_TestCase
{
    public function testBusinessLogic()
    {
        // Définition du profil maire
        $profile = new Application_Model_Proxy_Profile_Elu_Maire;
        $profile->setEmail("kdubuc@sdis62.fr");
        $profile->setFirstName("Kévin");
        $profile->setLastName("DUBUC");
        $profile->setCity("Arras");
        
        // création d'une application
        $application = new Application_Model_Proxy_Application;
        $application->setName("Application 1");
        $application->setConsumerSecret("aaa");
        $application->setUrl("https://apps.sdis62.fr/prevarisc");
        $application->setConsumerKey("aa");
        $application->setActiveStatus(true);
        $this->assertEquals($application->getName(), "Application 1");
        $this->assertEquals($application->getURL(), "https://apps.sdis62.fr/prevarisc");
        $this->assertTrue($application->isActive());
        $this->assertEquals($application->getConsumerSecret(), "aaa");
        $this->assertEquals($application->getConsumerKey(), "aa");
        
        // création d'un groupe d'application contenant l'application précédemment créée
        $applicationsGroup = new Application_Model_Proxy_ApplicationsGroup;
        $applicationsGroup->setName("Service prévention");
        $applicationsGroup->add($application);
        $this->assertCount(1, $applicationsGroup);

        // assigne l'utilisateur avec le profil
        $user = new Application_Model_Proxy_User_Db($profile);
        $user->setPassword("test");
        $user->setActiveStatus(true);
        $this->assertEquals($user->getLogin(), "kdubuc@sdis62.fr");
        $this->assertEquals($user->getProfile()->getCity(), "Arras");
        
        // création d'un groupe d'utilisateur
        $usersGroup = new Application_Model_Proxy_UsersGroup;
        $usersGroup->setName("Administrateur");
        $this->assertEquals($usersGroup->getName(), "Administrateur");
        $usersGroup->add($user);
        $usersGroup->remove($user);
        $this->assertCount(0, $usersGroup);
        $usersGroup->add($user);
        $this->assertCount(1, $usersGroup);
        
        // On assigne des applications à l'utilisateur (soit à l'unité, soit par groupe)
        $user->addApplication($application);
        $user->addApplication($application);
        $user->removeApplication($application);
        $this->assertCount(0, $user->getApplications());
        $user->addApplications($applicationsGroup);
        $this->assertCount(1, $user->getApplications());
        $this->assertTrue($user->hasApplication($application));
        
        // On test les roles
        $this->assertTrue(Application_Model_Entity_Role::GUEST < Application_Model_Entity_Role::USER);
        $user->setRole(Application_Model_Entity_Role::GUEST);
        $usersGroup->setRole(Application_Model_Entity_Role::USER);
        $this->assertEquals($user->getRole(), Application_Model_Entity_Role::GUEST);
    }

    public function testUsersDbMappers()
    {
        $user_dao = SDIS62_Model_DAO_Abstract::getInstance('User_Db');
        
        $last_name = rand(9,2) . "Tost" . rand(9,2) . rand(9,2);
        
        // Création du profile que l'on affectera à l'utilisateur test
        $profile = new Application_Model_Proxy_Profile;
        $profile->setEmail("kdubuc@sdis62.fr")
            ->setFirstName("Kévin")
            ->setLastName($last_name)
            ->setAsMan();
        
        // Création de l'utilisateur test
        $user = new Application_Model_Proxy_User_Db($profile);
        $user->setPassword("test")
            ->setActiveStatus(true)
            ->setRole(Application_Model_Entity_Role::GUEST);
            
        $user_dao->save($user);
        $this->assertGreaterThan(0, $user->getPrimary());
        $id_profile = $user->getProfile()->getPrimary();
        $user->getProfile()->setFirstName("Okay");
        $user_dao->save($user);
        $this->assertEquals($user->getProfile()->getPrimary(), $id_profile);
        $user_dao->delete($user);
        unset($user);

        // Création du profile que l'on affectera à l'utilisateur test
        $profile = new Application_Model_Proxy_Profile_Elu_Maire;
        $profile->setEmail("kdubuc@sdis62.fr")
            ->setFirstName("Kévin")
            ->setLastName($last_name)
            ->setCity("Arras")
            ->setAsMan();
        
        // Création de l'utilisateur test
        $user = new Application_Model_Proxy_User_Db($profile);
        $user->setPassword("test")
            ->setActiveStatus(true)
            ->setRole(Application_Model_Entity_Role::GUEST);

        // Test de sauvegarde dans la base de données
        $this->assertEquals($user->getId(), 0);
        $user_dao->save($user);
        $this->assertGreaterThan(0, $user->getId());
        $user->getProfile()->setFirstName("Kenny");
        $user->getProfile()->setCity("Carency");
        $user_dao->save($user);

        unset($user);

        // On essaye de le récupérer en base
        $rowset_user = $user_dao->getByLastName($last_name);
        $this->assertTrue(is_array($rowset_user));
        $this->assertCount(1, $rowset_user);
        $user = $rowset_user[0];
        $this->assertInstanceOf("Application_Model_Proxy_User", $user);
        $this->assertEquals($user->getProfile()->getLastName(), $last_name);
        $this->assertGreaterThan(0, $user->getId());
        $user->getProfile()->setFirstName("YOOOOOO");
        $user_dao->save($user);
        
        // On créé un groupe d'utilisateurs
        $usersGroup = new Application_Model_Proxy_UsersGroup;
        $usersGroup->setName("Administrateur");
        $usersGroup->setDesc("Groupe des administrateurs");
        $usersGroup->setRole(Application_Model_Entity_Role::GUEST);
        $usersGroup->add($user);
        
        // On met l'user dans un groupe
        $usergroup_dao = SDIS62_Model_DAO_Abstract::getInstance('UsersGroup');
        $usergroup_dao->save($usersGroup);
        $this->assertGreaterThan(0, $usersGroup->getId());
        
        // mapper général des users
        $user_test = $user_general_dao->getByLastName($last_name);
        $this->assertCount(1, $user_test);
        $this->assertEquals($user_test[0]->getProfile()->getLastName(), $last_name);
        unset($user_test);
        
        // on test de retrouver le groupe
        $groups_test = $usergroup_dao->getById($usersGroup->getId());
        $this->assertCount(1, $groups_test);
        $this->assertInstanceOf("Application_Model_Proxy_UsersGroup", $groups_test[0]);
        
        // on donne une application à l'utilisateur
        $application_dao = SDIS62_Model_DAO_Abstract::getInstance('Application');
        $application = new Application_Model_Proxy_Application;
        $application->setName("Application 1");
        $application->setConsumerSecret("aaa");
        $application->setUrl("https://apps.sdis62.fr/prevarisc");
        $application->setConsumerKey("aa");
        $application->setActiveStatus(true);
        $application_dao->save($application);
        $user->addApplication($application);
        $user_dao->save($user);
        $rowset_user = $user_dao->getByLastName($last_name);
        $user = $rowset_user[0];
        $this->assertCount(1, $user->getApplications());
        $user->removeApplication($application);
        $user_dao->save($user);
        $rowset_user = $user_dao->getByLastName($last_name);
        $user = $rowset_user[0];
        $this->assertCount(0, $user->getApplications());
        $application_dao->delete($application);
        
        // on change et on update le profil de l'user
        $id_profile = $user->getProfile()->getId();
        $user_dao->save($user);
        $this->assertEquals($id_profile, $user->getProfile()->getId());
        
        // On supprime les données test
        $user_dao->delete($user->getPrimary());
        $usergroup_dao->delete($usersGroup->getPrimary());
    }
    
    public function testUsersLDAPMappers()
    {
        $user_dao = SDIS62_Model_DAO_Abstract::getInstance('User_LDAP');
        
        // Création du profile que l'on affectera à l'utilisateur test
        $profile = new Application_Model_Proxy_Profile;
        $profile->setEmail("kdubuc@sdis62.fr")
            ->setFirstName("Kévin")
            ->setLastName("fdfd")
            ->setAsMan();
        
        // Création de l'utilisateur test
        $user = new Application_Model_Proxy_User_LDAP($profile);
        $user->setObjectId("test")
            ->setDN(Zend_Ldap_Dn::fromString('CN=Baker\\, Alice,CN=Users+OU=Lab,DC=example,DC=com'))
            ->setActiveStatus(true)
            ->setRole(Application_Model_Entity_Role::GUEST);
            
        $user_dao->save($user);
        $user_dao->delete($user->getPrimary());
    }
    
    public function testApplicationsMappers()
    {
		$application_dao = SDIS62_Model_DAO_Abstract::getInstance('Application');
        $applicationgroup_dao = SDIS62_Model_DAO_Abstract::getInstance('ApplicationsGroup');
        
        // création d'une application
        $application = new Application_Model_Proxy_Application;
        $application->setName("Application 1");
        $application->setConsumerSecret("aaa");
        $application->setUrl("https://apps.sdis62.fr/prevarisc");
        $application->setConsumerKey("aa");
        $application->setActiveStatus(true);
        
        // création d'un groupe d'application contenant l'application précédemment créée
        $applicationsGroup = new Application_Model_Proxy_ApplicationsGroup;
        $applicationsGroup->setName("Service prévention");
        $applicationsGroup->add($application);
        
        $application_dao->save($application);
        
        $applicationgroup_dao->save($applicationsGroup);
        
        $applicationsGroup->setName("Yop !");
        
        $applicationgroup_dao->save($applicationsGroup);
        
        $groups_test = $applicationgroup_dao->find($applicationsGroup->getPrimary());
        $this->assertCount(1, $groups_test);
        $this->assertInstanceOf("Application_Model_Proxy_ApplicationsGroup", $groups_test[0]);
        $this->assertCount(1, $groups_test[0]->getApplications());
        
        $applicationgroup_dao->delete($applicationsGroup);
        $application_dao->delete($application);
    }    
}
