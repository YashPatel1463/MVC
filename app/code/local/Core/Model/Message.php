<?php 

class Core_Model_Message extends Core_Model_Session {
    public function addSuccess($message) {
        // $this->set('message', ['success' => [$message]]);
        $messages = $this->get('message') ?: [];
        $messages['success'][] = $message;
        $this->set('message', $messages);
        return $this;
    }
    
    public function addError($message) {
        // $this->set('message', ['error' => [$message]]);
        $messages = $this->get('message') ?: [];
        $messages['error'][] = $message;
        $this->set('message', $messages);
        return $this;
    }

    public function addWarning($message) {
        // $this->set('message', ['warning' => [$message]]);
        $messages = $this->get('message') ?: [];
        $messages['warning'][] = $message;
        $this->set('message', $messages);
        return $this;
    }

    public function getSuccess() {
        // return $this->get('message')['success'];
        $messages = $this->get('message');
        $success = isset($messages['success']) ? $messages['success'] : [];
        unset($messages['success']);  // Remove only 'success' messages
        $this->set('message', $messages);
        return $success;
    }

    public function getError() {
        // return $this->get('message')['error'];
        $messages = $this->get('message');
        $error = isset($messages['error']) ? $messages['error'] : [];
        unset($messages['error']);  
        $this->set('message', $messages);
        return $error;
    }

    public function getWarning() {
        // return $this->get('message')['warning'];
        $messages = $this->get('message');
        $warning = isset($messages['warning']) ? $messages['warning'] : [];
        unset($messages['warning']);
        $this->set('message', $messages);
        return $warning;
    }

    public function getAllMessages() {
        if(!empty($this->get('message'))) {
            return $this->get('message');
        } else {
            return [];
        }
    }
}

?>