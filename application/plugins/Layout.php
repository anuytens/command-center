<?php

class Application_Plugin_Layout extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        // On récupère la vue
        $view = Zend_Controller_Front::getInstance()->getParam('bootstrap')->getResource('view');

        // On définit le titre de l'application
        $view->headTitle("Command Center")
            ->setSeparator(" | ")
            ->append(strip_tags( $view->navigation()->breadcrumbs()->setMinDepth(0)->setSeparator(" > ") ));
            
        // LESS file for development env
        // min CSS file for production env
        if(APPLICATION_ENV !== "production")
        {
            $view->headLink()->appendStylesheet(ASSETS_PATH . 'css/main.less?v=' . time(), 'all', null, array('rel' => 'stylesheet/less'));
        }
        else
        {
            $view->headLink()->appendStylesheet(ASSETS_PATH . 'css/main.css', 'all');
        }
            
        // Balises META de l'application
        $view->headMeta()
            ->appendName('viewport', 'width=device-width,initial-scale=1')
            ->appendHttpEquiv('X-UA-Compatible', 'IE=edge,chrome=1')
            ->appendName('description', 'Centre de commande de l\'écosystème applicatif du SDIS 62')
            ->appendName('author', 'SDIS 62');
            
        // Javascript
        $view->inlineScript()
            ->appendFile(ASSETS_PATH . "components/jquery/jquery.min.js")
            ->appendFile(ASSETS_PATH . "components/bootstrap/docs/assets/js/bootstrap.js")
            ->appendFile(ASSETS_PATH . "components/chosen/chosen/chosen.jquery.min.js")
            ->appendFile(ASSETS_PATH . "components/jquery.tablesorter/js/jquery.tablesorter.min.js")
            ->appendFile(ASSETS_PATH . "components/sdis62-ui/js/main.js")
            ->appendFile(ASSETS_PATH . "js/main.js");

        // (LESS required for non-production env)
        if(APPLICATION_ENV !== "production")
        {
            $view->inlineScript()->appendFile(ASSETS_PATH . "components/less.js/dist/less-1.3.3.min.js");
        }
 
        // Icône du site
        $view->headLink()->headLink(array("rel" => "shortcut icon", "href" => ASSETS_PATH . "favicon.ico"));
    }
}