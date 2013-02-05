<?php

class IndexControllerTest extends Zend_Test_PHPUnit_ControllerTestCase
{

    public function setUp()
    {
        $this->bootstrap = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
        parent::setUp();
    }

    public function testIndexAction()
    {
    }

    public function testAuthenticateAction()
    {
    }

    public function testLogoutAction()
    {
    }
    
    //test creation formulaire
    public function testCanCreateForm()
    {
        $form = new Application_Form_Login();
        $this->assertInstanceOf('Zend_Form',$form);
    }
    
    
    // connexion fictive
    public function testRedirectionLoginUser()
    {
    }
}







