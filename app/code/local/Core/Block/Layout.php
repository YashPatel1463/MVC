<?php

class Core_Block_Layout extends Core_Block_Template
{
    public function __construct()
    {
        $this->prepareChild();
        $this->prepareJsCss();
        $this->_template = 'page\root.phtml';
    }

    public function prepareChild()
    {
        $head = $this->createBlock('page/head');
        $this->addChild('head', $head);
        $header = $this->createBlock('page/header');
        $this->addChild('header', $header);
        $message = $this->createBlock('core/message');
        $this->addChild('message', $message);
        $content = $this->createBlock('page/content');
        $this->addChild('content', $content);
        $footer = $this->createBlock('page/footer');
        $this->addChild('footer', $footer);
    }

    public function createBlock($block)
    {
        // echo $block;
        return Mage::getBlockSingleTon($block);
    }

    public function prepareJsCss()
    {
        $head = $this->getChild('head')
            ->addJs('page/common.js')
            ->addCss('page/common.css')
            ->addCss('page/header.css');
    }
}
