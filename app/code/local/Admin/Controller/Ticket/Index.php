<?php 

class Admin_Controller_Ticket_Index extends Core_Controller_Admin_Action {
    public function listAction() {
        $list = $this->getLayout()
            ->createBlock('admin/ticket_index_list');
        $this->getLayout()
            ->getChild('content')
            ->addChild('list', $list);
        $this->getLayout()
            ->toHtml();
    }

    public function newAction() {
        $new = $this->getLayout()
            ->createBlock('admin/ticket_index_new');
        $this->getLayout()
            ->getChild('content')
            ->addChild('new', $new);
        $this->getLayout()
            ->getChild('head')
            ->addCss('admin/ticket/new.css');
        $this->getLayout()
            ->toHtml();
    }

    public function saveAction() {
        Mage::getModel('ticket/ticket')
            ->setData($this->getRequest()->getParam('ticket'))
            ->save();
        
        $this->getMessage()
            ->addSuccess('Ticket Added Successfully.');
        
        $this->redirect('admin/ticket_index/list');
    }

    public function viewAction() {
        $view = $this->getLayout()
            ->createBlock('admin/ticket_index_view');
        $this->getLayout()
            ->getChild('content')
            ->addChild('view', $view);
        $this->getLayout()
            ->getChild('head')
            ->addCss('admin/ticket/view.css')
            ->addJs('admin/ticket/view.js');
        $this->getLayout()
            ->toHtml();
    }

    public function saveCommentAction() {
        $comments = $this->getRequest()->getParam('comment');

        foreach ($comments as $comment) {
            if($comment['parent_id'] == null){
                unset($comment['parent_id']);
            }
            Mage::getModel('ticket/comment')
                ->setData($comment)
                ->save();
        }

        echo json_encode(["success"=>true, "message"=>"comments added successfully"]);
    }

    public function saveCompleteAction() {
        Mage::getModel('ticket/comment')
            ->load($this->getRequest()->getParams()['comment_id'])
            ->setIsActive(0)
            ->save();

        echo json_encode(["success"=>true, "message"=>"comments completed successfully"]);
        
        // Mage::log($comment);

        // $comment->completeParentComment();


        // $parent_id = $comment->getParentId();
        // echo $parent_id;


    }
}

?>