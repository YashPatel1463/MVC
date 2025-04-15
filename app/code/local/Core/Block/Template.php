<?php

class Core_Block_Template {
    protected $_child = [];
    protected $_parent = null;
    protected $_template;

    public function toHtml() {
        include(Mage::getBaseDir().'\app\design\frontend\template\\'.$this->_template);
    }
    public function toHtmlTag() {
        include(Mage::getBaseDir().'\app\design\frontend\template\\'.$this->_template);
    }

    public function addChild($key, $block) {
        // Mage::log($block);
        $block->setParent($this);
        $this->_child[$key] = $block;
        return $this;
    }

    public function setParent($parent) {
        $this->_parent = $parent;
        // Mage::log($this->_parent);
        return $this;
    }

    public function getParent() {
        // Mage::log($this->_parent);
        return $this->_parent;
    }

    public function removeChild($key) {
        // $this->_child = $key;
        if(isset($this->_child[$key])) {
            unset($this->_child[$key]);
        }
        return $this;
    }

    public function getChild($key) {
        // echo "<pre>";
        // print_r($this->_child);
        // echo "</pre>";
        return isset($this->_child[$key]) ? $this->_child[$key] : "";
    }

    public function setTemplate($template) {
        $this->_template = $template;
        return $this;
    }

    public function getChildHtml($key) {
        if($key == '' && count($this->_child)) {
            $html = '';
            foreach ($this->_child as $child) {
                $html.=$child->toHtml();
            }
            return $html;
        }

        return isset($this->_child[$key]) ? $this->_child[$key]->toHtml() : "";
    }

    
    public function getUrl($url) {
        $url = explode("/", $url);
        $_url = [];
        $request = Mage::getModel('core/request');
        
        $_url[] = ($url[0] == "*") ? $request->getModuleName() : $url[0];
        $_url[] = ($url[1] == "*") ? $request->getControllerName() : $url[1];
        $_url[] = ($url[2] == "*") ? $request->getActionName() : $url[2];

        return Mage::getBaseUrl() . implode("/",$_url);
    }

    public function getLayout() {
        return Mage::getBlockSingleTon("core/layout");
    }

    public function getRequest() {
        return Mage::getSingleTon("core/request");
    }   

    public function getMessage() {
        return Mage::getSingleTon("core/message");
    }   
}

?>