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
        $user_service = new Application_Service_User;
        $this->view->users = $user_service->getAllUsers();
    }
    
    public function listGroupsAction()
    {
        $group_service = new Application_Service_UsersGroup;
        
        // récupération des groupes et des utilisateurs
        $this->view->groups = $group_service->getAllGroups();
        $this->view->users_without_group = $group_service->getUsersWithoutGroup();
    }

    public function addUserAction()
    {
        $user_service = new Application_Service_User;
        
        if($this->_request->isPost())
        {
            if(null !== ($user = $user_service->save($this->_request->getPost())))
            {
                $this->_helper->flashMessenger(array(
                    'context' => 'success',
                    'title' => 'Ajout réussi !',
                    'message' => $user->getProfile()->getFirstName() . ' a bien été ajouté !'
                ));
                
                $this->_helper->redirector('list');
            }
        }
        
        $this->view->form = $user_service->getUserForm();
        $this->render("form");
    }
    
    public function editUserAction()
    {
        $user_service = new Application_Service_User;
        
        $user = $user_service->getAccount($this->_request->getParam("id"));
        foreach($this->view->nav->findAllByLabel("[NOM_USER]") as $node)
        {
            $node->setLabel($user->getProfile()->getFullName());
        }
        
        if($this->_request->isPost())
        {
            if(null !== ($user = $user_service->save($this->_request->getPost())))
            {
                $this->_helper->flashMessenger(array(
                    'context' => 'success',
                    'title' => 'Mise à jour réussie !',
                    'message' => $user->getProfile()->getFirstName() . ' a bien été mis à jour !'
                ));
    
                $this->_helper->redirector('list');
            }
        }
        
        $this->view->form = $user_service->getUserForm($this->_request->getParam("id"));
        $this->view->id_user = $this->_request->getParam("id");
        $this->render("edit-form");
    }
    
    public function deleteUserAction()
    {
        $this->_helper->viewRenderer->setNoRender();
        
        $user_service = new Application_Service_User;
        
        $user = $user_service->getAccount($this->_request->getParam("id"));
        
        $this->_helper->flashMessenger(array(
            'context' => 'success',
            'title' => 'Suppression réussie !',
            'message' => $user->getProfile()->getFirstName() . ' a bien été supprimé !'
        ));
        
        $user_service->delete($user);
        
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
        $user_service = new Application_Service_User;

        if($this->_request->isPost())
        {
            if(false !== $user_service->saveACL($this->_request->getPost()))
            {
                $this->_helper->flashMessenger(array(
                    'context' => 'success',
                    'title' => 'Mise à jour réussie !',
                    'message' => 'La liste de contrôle des ACL a bien été mise à jour.'
                ));
            }
        }
        
        $this->view->form = $user_service->getACLForm(true);
        $this->render("form");
    }
    
    public function editGroupAction()
    {
        $group_service = new Application_Service_UsersGroup;
        
        $group = $group_service->get($this->_request->getParam("id"));
        
        $this->view->nav->findOneByLabel("[NOM_GROUPE]")->setLabel($group->getName());
        
        if($this->_request->isPost())
        {
            if(null !== ($group = $group_service->save($this->_request->getPost())))
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
        $this->view->form = $group_service->getGroupForm($this->_request->getParam("id"));
    }
    
    public function deleteGroupAction()
    {
        $this->_helper->viewRenderer->setNoRender();
        
        $group_service = new Application_Service_UsersGroup;
        
        $group = $group_service->get($this->_request->getParam("id"));
        
        $this->_helper->flashMessenger(array(
            'context' => 'success',
            'title' => 'Suppression réussie !',
            'message' => 'Le groupe ' . $group->getName() . ' a bien été supprimé !'
        ));
        
        $group_service->delete($group);
        
        $this->_helper->redirector('groups');
    }
    
    public function addGroupAction()
    {
        $group_service = new Application_Service_UsersGroup;
        
        if($this->_request->isPost())
        {
            if(null !== ($group = $group_service->create($this->_request->getPost())))
            {
                $this->_helper->flashMessenger(array(
                    'context' => 'success',
                    'title' => 'Ajout réussi !',
                    'message' => 'Le groupe ' . $group->getName() . ' a bien été ajouté !'
                ));
                
                $this->_helper->redirector('groups');
            }
        }
        
        $this->view->form = $group_service->getGroupForm();
        $this->render("form");
    }

    public function groupsAction()
    {
        $group_service = new Application_Service_UsersGroup;
        $this->view->groups = $group_service->getAllGroups();
    }

}