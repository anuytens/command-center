<?php

class UsersControllerTest extends Zend_Test_PHPUnit_ControllerTestCase
{

    public function setUp()
    {
        $this->bootstrap = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
        parent::setUp();
    }

    private function _isIdExists()
    {
        $this->getRequest()->setQuery("id", 1);
        $this->dispatch($this->url(array("action" => "index", "controller" => "users")));
        $this->assertResponseCode(200);
        $this->resetRequest()->resetResponse();
        $this->dispatch($this->url(array("action" => "index", "controller" => "users")));
        $this->assertRedirectTo("list");
        $this->resetRequest()->resetResponse();
    }
    
    public function testIndexAction()
    {
        $this->_isIdExists();
    }

    public function testEditAction()
    {
        $this->_isIdExists();
        $this->getRequest()->setQuery("id", 1);
        $this->dispatch($this->url(array("action" => "index", "controller" => "users")));
        $this->assertQuery('form');
        
    }

    public function testListAction()
    {
        $this->assertResponseCode(200);
        $this->assertQuery('table');

    }
    
    public function testMeAction()
    {
        if( Zend_Auth::getInstance()->hasIdentity()  === true)
        {
            $this->assertResponseCode(200);
        }
        else
        {
            $this->assertRedirectTo("index");
        }

    }


}







