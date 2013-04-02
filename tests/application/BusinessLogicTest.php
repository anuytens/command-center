<?php

class BusinessLogicTest extends PHPUnit_Framework_TestCase
{
    public function testUserLogic()
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
        $application->setUrl("https://apps.sdis62.fr/prevarisc");
        $this->assertEquals($application->getName(), "Application 1");
        $this->assertEquals($application->getURL(), "https://apps.sdis62.fr/prevarisc");
        
        // création d'un groupe d'application contenant l'application précédemment créée
        $applicationsGroup = new Application_Model_Business_ApplicationsGroup;
        $applicationsGroup->setName("Service prévention");
        $applicationsGroup->add($application);
        $this->assertCount(1, $applicationsGroup);

        // assigne l'utilisateur avec le profil
        $user = new Application_Model_Business_User_Db;
        $user->setProfile($profile);
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
}