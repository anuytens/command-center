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
            ->appendStylesheet('/css/main.less', 'all', null, array('rel' => 'stylesheet/less'));
            
        // Balises META de l'application
        $view->headMeta()
            ->appendName('viewport', 'width=device-width,initial-scale=1')
            ->appendHttpEquiv('X-UA-Compatible', 'IE=edge,chrome=1')
            ->appendName('description', 'Centre de commande de l\'écosystème applicatif du SDIS 62')
            ->appendName('author', 'SDIS 62');
            //->appendName('keywords', 'KICKSTATR, tags')
            
        // Scripts éxecutés en fin de page
        $view->inlineScript()
            ->appendFile("/components/less.js/dist/less-1.3.3.min.js")
            ->appendFile("/components/jquery/jquery.min.js")
            ->appendFile("/components/bootstrap/js/bootstrap-collapse.js")
            ->appendFile("/components/bootstrap/js/bootstrap-dropdown.js")
            ->appendFile("/components/bootstrap/js/bootstrap-alert.js")
            ->appendFile("/components/chosen/chosen/chosen.jquery.min.js")
            ->appendFile("/components/jquery.tablesorter/js/jquery.tablesorter.min.js")
            ->appendFile("/js/main.js");
            
        // Icône du site
        $view->headLink()
            ->headLink(array("rel" => "shortcut icon", "href" => "/favicon.ico"));
    }
}