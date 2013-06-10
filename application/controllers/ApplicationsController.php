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
        $commandcenter_service = Application_Service_CommandCenter::getInstance();
        
        // récupération des groupes et des utilisateurs
        $this->view->groups = $commandcenter_service->getAllApplicationsGroups();
        $this->view->applications_without_group = $commandcenter_service->getApplicationsByGroupId();
    }
    
    public function addApplicationAction()
    {
        $commandcenter_service = Application_Service_CommandCenter::getInstance();
        
        if($this->_request->isPost())
        {
            if(null !== ($application = $commandcenter_service->saveApplication($this->_request->getPost())))
            {
                $this->_helper->flashMessenger(array(
                    'context' => 'success',
                    'title' => 'Ajout réussi !',
                    'message' => 'L\'application ' . $application->getName() . ' a bien été ajoutée !'
                ));
                
                $this->_helper->redirector('list');
            }
        }
        
        $this->view->form = $commandcenter_service->getApplicationForm();
        $this->render("form");
    }
    
    public function editApplicationAction()
    {
        $commandcenter_service = Application_Service_CommandCenter::getInstance();
        
        $application = $commandcenter_service->getApplicationById($this->_request->getParam("id"));
        $this->view->nav->findOneByLabel("[NOM_APPLICATION]")->setLabel($application->getName());
        
        if($this->_request->isPost())
        {
            if(null !== ($application = $commandcenter_service->saveApplication($this->_request->getPost())))
            {
                $this->_helper->flashMessenger(array(
                    'context' => 'success',
                    'title' => 'Mise à jour réussie !',
                    'message' => 'L\'application ' . $application->getName() . ' a bien été mise à jour !'
                ));
                
                $this->_helper->redirector('list');
            }
        }
        
        $this->view->form = $commandcenter_service->getApplicationForm($this->_request->getParam("id"));
        $this->view->id_application = $this->_request->getParam("id");
    }
    
    public function deleteApplicationAction()
    {
        $this->_helper->viewRenderer->setNoRender();
        
        $commandcenter_service = Application_Service_CommandCenter::getInstance();
        
        $application = $commandcenter_service->getApplicationById($this->_request->getParam("id"));
        
        $this->_helper->flashMessenger(array(
            'context' => 'success',
            'title' => 'Suppression réussie !',
            'message' => 'L\'application  ' . $application->getName() . ' a bien été supprimée !'
        ));
        
        $commandcenter_service->deleteApplication($application);
        
        $this->_helper->redirector('list');
    }
    
    public function addGroupAction()
    {
        $commandcenter_service = Application_Service_CommandCenter::getInstance();
        
        if($this->_request->isPost())
        {
            if(null !== ($group = $commandcenter_service->saveApplicationsGroup($this->_request->getPost())))
            {
                $this->_helper->flashMessenger(array(
                    'context' => 'success',
                    'title' => 'Ajout réussi !',
                    'message' => 'Le groupe d\'application ' . $group->getName() . ' a bien été ajouté !'
                ));
                
                $this->_helper->redirector('list');
            }
        }
        
        $this->view->form = $commandcenter_service->getApplicationsGroupForm();
        $this->render("form");
    }
    
    public function editGroupAction()
    {
        $commandcenter_service = Application_Service_CommandCenter::getInstance();
        
        $group = $commandcenter_service->getApplicationsGroupById($this->_request->getParam("id"));
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
        
        $this->view->form = $commandcenter_service->getApplicationsGroupForm($this->_request->getParam("id"));
        $this->view->id_group = $this->_request->getParam("id");
    }
    
    public function deleteGroupAction()
    {
        $this->_helper->viewRenderer->setNoRender();
        
        $commandcenter_service = Application_Service_CommandCenter::getInstance();
        
        $group = $commandcenter_service->getApplicationsGroupById($this->_request->getParam("id"));
        
        $this->_helper->flashMessenger(array(
            'context' => 'success',
            'title' => 'Suppression réussie !',
            'message' => 'Le groupe ' . $group->getName() . ' a bien été supprimé !'
        ));
        
        $commandcenter_service->deleteApplicationsGroup($group);
        
        $this->_helper->redirector('groups');
    }

    public function groupsAction()
    {
        $commandcenter_service = Application_Service_CommandCenter::getInstance();
        $this->view->groups = $commandcenter_service->getAllApplicationsGroups();
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