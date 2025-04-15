<?php

class Core_Block_Message extends Core_Block_Template {
    public function __construct() {
        $this->setTemplate('page/message.phtml');
    }

    public function getAllMessages() {
        return $this->getMessage()->getAllMessages();    
    }

    public function getSuccess() {
        return $this->getMessage()->getSuccess();
    }

    public function getWarning() {
        return $this->getMessage()->getWarning();
    }

    public function getError() {
        return $this->getMessage()->getError();
    }
}

?>