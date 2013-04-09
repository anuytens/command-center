<?php

class ApplicationTest extends PHPUnit_Framework_TestCase
{
    public function testBusinessLogic()
    {
        // Définition du profil maire
        $profile = new Application_Model_Business_Profile_Elu_Maire;
        $profile->setEmail("kdubuc@sdis62.fr");
        $profile->setFirstName("Kévin");
        $profile->setLastName("DUBUC");
        $profile->setCity("Arras");
        
        // création d'une application
        $application = new Application_Model_Business_Application;
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
        $applicationsGroup = new Application_Model_Business_ApplicationsGroup;
        $applicationsGroup->setName("Service prévention");
        $applicationsGroup->add($application);
        $this->assertCount(1, $applicationsGroup);

        // assigne l'utilisateur avec le profil
        $user = new Application_Model_Business_User_Db($profile);
        $user->setPassword("test");
        $user->setActiveStatus(true);
        $this->assertEquals($user->getLogin(), "kdubuc@sdis62.fr");
        $this->assertEquals($user->getProfile()->getCity(), "Arras");
        
        // création d'un groupe d'utilisateur
        $usersGroup = new Application_Model_Business_UsersGroup;
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
        $this->assertTrue(Application_Model_Business_Role::GUEST < Application_Model_Business_Role::USER);
        $user->setRole(Application_Model_Business_Role::GUEST);
        $usersGroup->setRole(Application_Model_Business_Role::USER);
        $this->assertEquals($user->getRole(), Application_Model_Business_Role::GUEST);
    }

    public function testUsersDbMappers()
    {
        $user_mapper = new Application_Model_Mapper_User_Db;
        
        $last_name = rand(9,2) . "Tost" . rand(9,2) . rand(9,2);

        // Création du profile que l'on affectera à l'utilisateur test
        $profile = new Application_Model_Business_Profile_Elu_Maire;
        $profile->setEmail("kdubuc@sdis62.fr")
            ->setFirstName("Kévin")
            ->setLastName($last_name)
            ->setCity("Arras")
            ->setAsMan();
        
        // Création de l'utilisateur test
        $user = new Application_Model_Business_User_Db($profile);
        $user->setPassword("test")
            ->setActiveStatus(true)
            ->setRole(Application_Model_Business_Role::GUEST);

        // Test de sauvegarde dans la base de données
        $this->assertEquals($user->getId(), 0);
        $user_mapper->save($user);
        $this->assertGreaterThan(0, $user->getId());
        $user->getProfile()->setFirstName("Kenny");
        $user->getProfile()->setCity("Carency");
        $user_mapper->save($user);

        unset($user);

        // On essaye de le récupérer en base
        $rowset_user = $user_mapper->getByLastName($last_name);
        $this->assertTrue(is_array($rowset_user));
        $this->assertCount(1, $rowset_user);
        $user = $rowset_user[0];
        $this->assertInstanceOf("Application_Model_Business_User", $user);
        $this->assertEquals($user->getProfile()->getLastName(), $last_name);
        $this->assertGreaterThan(0, $user->getId());
        $user->getProfile()->setFirstName("YOOOOOO");
        $user_mapper->save($user);
        
        // On supprime la donnée test
        $user_mapper->delete($user);
    }
    
    public function testUsersLDAPMappers()
    {
        $user_mapper = new Application_Model_Mapper_User_LDAP;
        
        // Création du profile que l'on affectera à l'utilisateur test
        $profile = new Application_Model_Business_Profile;
        $profile->setEmail("kdubuc@sdis62.fr")
            ->setFirstName("Kévin")
            ->setLastName("fdfd")
            ->setAsMan();
        
        // Création de l'utilisateur test
        $user = new Application_Model_Business_User_LDAP($profile);
        $user->setObjectId("test")
            ->setDN(Zend_Ldap_Dn::fromString('CN=Baker\\, Alice,CN=Users+OU=Lab,DC=example,DC=com'))
            ->setActiveStatus(true)
            ->setRole(Application_Model_Business_Role::GUEST);
            
        $user_mapper->save($user);
        $user_mapper->delete($user);
    }
}