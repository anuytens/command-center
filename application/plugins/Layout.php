<?php

class Application_Plugin_Layout extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        // On récupère la vue
        $view = Zend_Controller_Front::getInstance()->getParam('bootstrap')->getResource('view');
        
        // On définit le titre de l'application
        $view->headTitle("Module utilisateur")
            ->setSeparator(" | ")
            ->append(strip_tags( $view->navigation()->breadcrumbs()->setMinDepth(0)->setSeparator(" > ") ));
            
        // On lie les feuilles de style
        $view->headLink()
            ->appendStylesheet('components/bootstrap/less/bootstrap.less', 'all', null, array('rel' => 'stylesheet/less'))
            ->appendStylesheet('components/bootstrap/less/responsive.less', 'all', null, array('rel' => 'stylesheet/less'));
            
        // Balises META de l'application
        $view->headMeta()
            ->appendName('viewport', 'width=device-width,initial-scale=1')
            ->appendHttpEquiv('X-UA-Compatible', 'IE=edge,chrome=1');
            /*
            ->appendName('description', 'KICKSTATR - Description de l\'app')
            ->appendName('author', 'Kévin DUBUC')
            ->appendName('keywords', 'KICKSTATR, tags')
            */
            
        // Scripts éxecutés en fin de page
        $view->inlineScript()
            ->appendFile("components/less.js/dist/less-1.3.3.min.js")
            ->appendFile("components/jquery/jquery.min.js");
            
        // Icône du site
        $view->headLink()
            ->headLink(array("rel" => "shortcut icon", "href" => "/favicon.ico"));
    }
}