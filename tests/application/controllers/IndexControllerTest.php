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
        $params = array('action' => 'index', 'controller' => 'Index', 'module' => 'default');
        $urlParams = $this->urlizeOptions($params);
        $url = $this->url($urlParams);
        $this->dispatch($url);
        
        // assertions
        $this->assertModule($urlParams['module']);
        $this->assertController($urlParams['controller']);
        $this->assertAction($urlParams['action']);
        //$this->assertQueryContentContains("div#welcome h3", "This is your project's main page");
    }

    public function testAuthenticateAction()
    {
        $params = array('action' => 'authenticate', 'controller' => 'Index', 'module' => 'default');
        $urlParams = $this->urlizeOptions($params);
        $url = $this->url($urlParams);
        $this->dispatch($url);
        
        // assertions
        $this->assertModule($urlParams['module']);
        $this->assertController($urlParams['controller']);
        $this->assertAction($urlParams['action']);
        $this->assertQueryContentContains(
            'div#view-content p',
            'View script for controller <b>' . $params['controller'] . '</b> and script/action name <b>' . $params['action'] . '</b>'
            );
    }

    public function testLogoutAction()
    {
        $params = array('action' => 'logout', 'controller' => 'Index', 'module' => 'default');
        $urlParams = $this->urlizeOptions($params);
        $url = $this->url($urlParams);
        $this->dispatch($url);
        
        // assertions
        $this->assertModule($urlParams['module']);
        $this->assertController($urlParams['controller']);
        $this->assertAction($urlParams['action']);
        $this->assertQueryContentContains(
            'div#view-content p',
            'View script for controller <b>' . $params['controller'] . '</b> and script/action name <b>' . $params['action'] . '</b>'
            );
    }
    
    //test creation formulaire
    public function testCanCreateForm()
    {
        $form = new Application_Form_Login();
        $this->assertInstanceOf('Zend_Form',$form);
    }
    
    
    // connexion fictive
    public function testRedirectionLoginUser($user, $password)
    {
        $this->request->setMethod('POST')
                      ->setPost(array(
                          'username' => $user,
                          'password' => $password,
                      ));
        $this->dispatch('/user/login');
        $this->assertRedirectTo('/user/view');
 
        $this->resetRequest()
             ->resetResponse();
 
        $this->request->setPost(array());
    }
}







