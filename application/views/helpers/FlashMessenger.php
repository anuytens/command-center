<?php

class Application_View_Helper_FlashMessenger extends Zend_View_Helper_Abstract  implements Countable
{

    protected $_fm;

    // Fluent interface
    public function flashMessenger()
    {
        return $this;
    }
 
    // get the action helper flashmessenger
    public function __construct()
    {
        $this->_fm = Zend_Controller_Action_HelperBroker::getStaticHelper('FlashMessenger');
    }

    // Output the messages
    public function output($my_key = null, $template = '<li class="alert alert-%s" ><button data-dismiss="alert" class="close">&times;</button><strong class="alert-%s">%s</strong> %s</li>')
    {
        // On récupère les messages
        $array_messages = $this->getMessages();

        // On initialise la chaine de sortie
        $output = '';

        // On stocke les messages
        foreach ($array_messages as $row_message) {

            $key = $row_message["context"];

            if($my_key == null || $key == $my_key ) {

                $output .= sprintf($template, $key, $key, $row_message["title"], $row_message["message"]);
            }
        }

        return $output;
    }

    // get messages
    private function getMessages()
    {
        // Messages
        $array_messages = $this->_fm->getMessages();
        
        // Messages en cours
        $array_currentMessages = $this->_fm->getCurrentMessages();

        return array_merge($array_currentMessages, $array_messages);
        //return $array_currentMessages;
    }

    // check if there are messages
    public function hasMessages()
    {
        return count($this->_fm) + count($this->_fm->getCurrentMessages());
    }

    public function count()
    {
        return $this->_fm->count();
    }
}
