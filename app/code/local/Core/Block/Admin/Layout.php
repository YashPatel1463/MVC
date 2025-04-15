<?php

class Core_Block_Admin_Layout extends Core_Block_Layout
{
    public function __construct()
    {
        $this->prepareChild();
        $this->prepareJsCss();
        $this->_template = 'page\root.phtml';
    }

    public function prepareChild() {
        $head = $this->createBlock('page/head')
            ->setTemplate('page/admin/head.phtml');    
        $this->addChild('head',$head);
        $header = $this->createBlock('page/header')
            ->setTemplate('page/admin/header.phtml');   
        $this->addChild('header',$header);
        $message = $this->createBlock('core/message');
        $this->addChild('message', $message);
        $content = $this->createBlock('page/content')
            ->setTemplate('page/admin/content.phtml');    
        $this->addChild('content',$content);
        $footer = $this->createBlock('page/footer')
            ->setTemplate('page/admin/footer.phtml');    
        $this->addChild('footer',$footer);
    }
}
