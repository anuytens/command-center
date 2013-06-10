<?php

class UsersController extends Zend_Controller_Action
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
        $this->view->users = $commandcenter_service->getAllUsers();
    }
    
    public function listGroupsAction()
    {
        $commandcenter_service = Application_Service_CommandCenter::getInstance();
        
        // récupération des groupes et des utilisateurs
        $this->view->groups = $commandcenter_service->getAllUsersGroups();
        $this->view->users_without_group = $commandcenter_service->getUsersByGroupId();
    }

    public function addUserAction()
    {
        $commandcenter_service = Application_Service_CommandCenter::getInstance();
        
        if($this->_request->isPost())
        {
            if(null !== ($user = $commandcenter_service->saveUser($this->_request->getPost())))
            {
                $this->_helper->flashMessenger(array(
                    'context' => 'success',
                    'title' => 'Ajout réussi !',
                    'message' => $user->getProfile()->getFirstName() . ' a bien été ajouté !'
                ));
                
                $this->_helper->redirector('list');
            }
        }
        
        $this->view->form = $commandcenter_service->getUserForm();
        $this->render("form");
    }
    
    public function editUserAction()
    {
        $commandcenter_service = Application_Service_CommandCenter::getInstance();
        
        $user = $commandcenter_service->getUserById($this->_request->getParam("id"));
        
        foreach($this->view->nav->findAllByLabel("[NOM_USER]") as $node)
        {
            $node->setLabel($user->getProfile()->getFullName());
        }
        
        if($this->_request->isPost())
        {
            if(null !== ($user = $commandcenter_service->saveUser($this->_request->getPost())))
            {
                $this->_helper->flashMessenger(array(
                    'context' => 'success',
                    'title' => 'Mise à jour réussie !',
                    'message' => $user->getProfile()->getFirstName() . ' a bien été mis à jour !'
                ));
    
                $this->_helper->redirector('list');
            }
        }
        
        $this->view->form = $commandcenter_service->getUserForm($this->_request->getParam("id"));
        $this->view->id_user = $this->_request->getParam("id");
        $this->render("edit-form");
    }
    
    public function deleteUserAction()
    {
        $this->_helper->viewRenderer->setNoRender();
        
        $commandcenter_service = Application_Service_CommandCenter::getInstance();
        
        $user = $commandcenter_service->getUserById($this->_request->getParam("id"));
        
        $this->_helper->flashMessenger(array(
            'context' => 'success',
            'title' => 'Suppression réussie !',
            'message' => $user->getProfile()->getFirstName() . ' a bien été supprimé !'
        ));
        
        $commandcenter_service->deleteUser($user);
        
        if($this->_request->getParam("ref") == "users")
        {
            $this->_helper->redirector('list');
        }
        else
        {
            $this->_helper->redirector('list-groups');
        }
    }
    
    public function aclAction()
    {
        $commandcenter_service = Application_Service_CommandCenter::getInstance();

        if($this->_request->isPost())
        {
            if(false !== $commandcenter_service->saveACL($this->_request->getPost()))
            {
                $this->_helper->flashMessenger(array(
                    'context' => 'success',
                    'title' => 'Mise à jour réussie !',
                    'message' => 'La liste de contrôle des ACL a bien été mise à jour.'
                ));
            }
        }
        
        $this->view->form = $commandcenter_service->getACLForm(true);
        $this->render("form");
    }
    
    public function editGroupAction()
    {
        $commandcenter_service = Application_Service_CommandCenter::getInstance();
        
        $group = $commandcenter_service->getUsersGroupById($this->_request->getParam("id"));
        
        $this->view->nav->findOneByLabel("[NOM_GROUPE]")->setLabel($group->getName());
        
        if($this->_request->isPost())
        {
            if(null !== ($group = $commandcenter_service->saveUsersGroup($this->_request->getPost())))
            {
                $this->_helper->flashMessenger(array(
                    'context' => 'success',
                    'title' => 'Mise à jour réussie !',
                    'message' => 'Le groupe ' . $group->getName() . ' a bien été mis à jour !'
                ));
                
                $this->_helper->redirector('groups');
            }
        }
        
        $this->view->id_group = $this->_request->getParam("id");
        $this->view->form = $commandcenter_service->getUsersGroupForm($this->_request->getParam("id"));
    }
    
    public function deleteGroupAction()
    {
        $this->_helper->viewRenderer->setNoRender();
        
        $commandcenter_service = Application_Service_CommandCenter::getInstance();
        
        $group = $commandcenter_service->getUsersGroupById($this->_request->getParam("id"));
        
        $this->_helper->flashMessenger(array(
            'context' => 'success',
            'title' => 'Suppression réussie !',
            'message' => 'Le groupe ' . $group->getName() . ' a bien été supprimé !'
        ));
        
        $commandcenter_service->deleteUsersGroup($group);
        
        $this->_helper->redirector('groups');
    }
    
    public function addGroupAction()
    {
        $commandcenter_service = Application_Service_CommandCenter::getInstance();
        
        if($this->_request->isPost())
        {
            if(null !== ($group = $commandcenter_service->saveUsersGroup($this->_request->getPost())))
            {
                $this->_helper->flashMessenger(array(
                    'context' => 'success',
                    'title' => 'Ajout réussi !',
                    'message' => 'Le groupe ' . $group->getName() . ' a bien été ajouté !'
                ));
                
                $this->_helper->redirector('groups');
            }
        }
        
        $this->view->form = $commandcenter_service->getUsersGroupForm();
        $this->render("form");
    }

    public function groupsAction()
    {
        $commandcenter_service = Application_Service_CommandCenter::getInstance();
        $this->view->groups = $commandcenter_service->getAllUsersGroups();
    }

}