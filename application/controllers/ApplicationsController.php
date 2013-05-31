<?php

class ApplicationsController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_helper->layout->setLayout('menu_left');
    }

    public function indexAction()
    {
        $this->_helper->redirector('list');
    }

    public function listAction()
    {
        $group_service = new Application_Service_ApplicationsGroup;
        
        // récupération des groupes et des utilisateurs
        $this->view->groups = $group_service->getAllGroups();
        $this->view->applications_without_group = $group_service->getApplicationsWithoutGroup();
    }
    
    public function addApplicationAction()
    {
        $application_service = new Application_Service_Application;
        
        if($this->_request->isPost())
        {
            if(null !== ($application = $application_service->create($this->_request->getPost())))
            {
                $this->_helper->flashMessenger(array(
                    'context' => 'success',
                    'title' => 'Ajout réussi !',
                    'message' => 'L\'application ' . $application->getName() . ' a bien été ajoutée !'
                ));
                
                $this->_helper->redirector('list');
            }
        }
        
        $this->view->form = $application_service->getApplicationForm();
        $this->render("form");
    }
    
    public function editApplicationAction()
    {
        $application_service = new Application_Service_Application;
        
        $application = $application_service->get($this->_request->getParam("id"));
        $this->view->nav->findOneByLabel("[NOM_APPLICATION]")->setLabel($application->getName());
        
        if($this->_request->isPost())
        {
            if(null !== ($application = $application_service->save($this->_request->getPost())))
            {
                $this->_helper->flashMessenger(array(
                    'context' => 'success',
                    'title' => 'Mise à jour réussie !',
                    'message' => 'L\'application ' . $application->getName() . ' a bien été mise à jour !'
                ));
                
                $this->_helper->redirector('list');
            }
        }
        
        $this->view->form = $application_service->getApplicationForm($this->_request->getParam("id"));
        $this->view->id_application = $this->_request->getParam("id");
    }
    
    public function deleteApplicationAction()
    {
        $this->_helper->viewRenderer->setNoRender();
        
        $application_service = new Application_Service_Application;
        
        $application = $application_service->get($this->_request->getParam("id"));
        
        $this->_helper->flashMessenger(array(
            'context' => 'success',
            'title' => 'Suppression réussie !',
            'message' => 'L\'application  ' . $application->getName() . ' a bien été supprimée !'
        ));
        
        $application_service->delete($application);
        
        $this->_helper->redirector('list');
    }
    
    public function addGroupAction()
    {
        $group_service = new Application_Service_ApplicationsGroup;
        
        if($this->_request->isPost())
        {
            if(null !== ($group = $group_service->create($this->_request->getPost())))
            {
                $this->_helper->flashMessenger(array(
                    'context' => 'success',
                    'title' => 'Ajout réussi !',
                    'message' => 'Le groupe d\'application ' . $group->getName() . ' a bien été ajouté !'
                ));
                
                $this->_helper->redirector('list');
            }
        }
        
        $this->view->form = $group_service->getGroupForm();
        $this->render("form");
    }
    
    public function editGroupAction()
    {
        $group_service = new Application_Service_ApplicationsGroup;
        
        $group = $group_service->get($this->_request->getParam("id"));
        $this->view->nav->findOneByLabel("[NOM_APPLICATION_GROUPE]")->setLabel($group->getName());
        
        if($this->_request->isPost())
        {
            if(null !== ($group = $group_service->save($this->_request->getPost())))
            {
                $this->_helper->flashMessenger(array(
                    'context' => 'success',
                    'title' => 'Mise à jour effectuée !',
                    'message' => 'Le groupe d\'application ' . $group->getName() . ' a bien été mis à jour !'
                ));
                
                $this->_helper->redirector('list');
            }
        }
        
        $this->view->form = $group_service->getGroupForm($this->_request->getParam("id"));
        $this->view->id_group = $this->_request->getParam("id");
    }
    
    public function deleteGroupAction()
    {
        $this->_helper->viewRenderer->setNoRender();
        
        $group_service = new Application_Service_ApplicationsGroup;
        
        $group = $group_service->get($this->_request->getParam("id"));
        
        $this->_helper->flashMessenger(array(
            'context' => 'success',
            'title' => 'Suppression réussie !',
            'message' => 'Le groupe ' . $group->getName() . ' a bien été supprimé !'
        ));
        
        $group_service->delete($group);
        
        $this->_helper->redirector('groups');
    }

    public function groupsAction()
    {
        $group_service = new Application_Service_ApplicationsGroup;
        $this->view->groups = $group_service->getAllGroups();
    }
    
    public function getApplicationsStatusAction()
    {
        $commandcenter_service = Application_Service_CommandCenter::getInstance();
        
        // Disable the renderer
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        // Get all applications
        $applications = $commandcenter_service->getAllApplications();
        
        // Set an array
        $results = array();
        
        // Populate the array with 3 values for each applications
        // success : available
        // error : non reachable
        // inactive
        foreach($applications as $application)
        {
            $value = null;
            
            if($application->isActive())
            {
                $value = $application->isAvailable() ? "success" : "error";
            }
            else
            {
                $value = "inactive";
            }
            
            $results[$application->getId()] = $value;
        }
        
        echo Zend_Json::Encode($results);
    }
}