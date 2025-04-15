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
        // $data = $this->getRequest()->getParams();
        // $parentnodeid = $data['parentnode_id'];
        // unset($data['parentnode_id']);
        // if ($parentnodeid != 1) {
        //     $commentId = Mage::getModel('ticket/comment')
        //         ->getCollection()
        //         ->addFieldToFilter('ticket_id', $data['ticket_id'])
        //         ->addFieldToFilter('node_id', $parentnodeid)
        //         ->getFirstItem()
        //         ->getCommentId();
        //     $data['parent_id'] = $commentId;
        // }
        // $a = Mage::getModel('ticket/comment')
        //     ->setData($data)
        //     ->save();
        // Mage::log($a);
    }
}

?>