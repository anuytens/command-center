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
            $view->headLink()->appendStylesheet('/css/main.less?v=' . time(), 'all', null, array('rel' => 'stylesheet/less'));
        }
        else
        {
            $view->headLink()->appendStylesheet('/css/main.css', 'all');
        }
            
        // Balises META de l'application
        $view->headMeta()
            ->appendName('viewport', 'width=device-width,initial-scale=1')
            ->appendHttpEquiv('X-UA-Compatible', 'IE=edge,chrome=1')
            ->appendName('description', 'Centre de commande de l\'écosystème applicatif du SDIS 62')
            ->appendName('author', 'SDIS 62');
            
        // Javascript
        // (LESS required for non-production env)
        if(APPLICATION_ENV !== "production")
        {
            $view->inlineScript()
                ->setAllowArbitraryAttributes(true)
                ->appendFile("/components/less.js/dist/less-1.3.3.min.js")
                ->appendFile("/components/requirejs/require.js", "text/javascript", array("data-main" => "/js/main"));
        }
        else
        {
            $view->inlineScript()
            ->appendFile("/js/main.min.js", "text/javascript");
        }
 
        // Icône du site
        $view->headLink()->headLink(array("rel" => "shortcut icon", "href" => "/favicon.ico"));
    }
}