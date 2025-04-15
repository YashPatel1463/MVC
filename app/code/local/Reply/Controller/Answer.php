<?php

class Reply_Controller_Answer extends Core_Controller_Customer_Action {
    protected $_allowedActions = ['index'];

    public function indexAction() {
        $list = $this->getLayout()
            ->createBlock('reply/answer_index');
        $this->getLayout()
            ->getChild('content')
            ->addChild('list', $list);
        $this->getLayout()
            ->getChild('head')
            ->addCss('reply/index.css');
        $this->getLayout()
            ->toHtml();
    }
}


?>