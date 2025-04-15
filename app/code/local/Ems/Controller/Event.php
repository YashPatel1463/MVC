<?php

class Ems_Controller_Event extends Core_Controller_Admin_Action {
    public function newAction() {
        $new = $this->getLayout()
            ->createBlock('ems/event_new');
        $this->getLayout()
            ->getChild('content')
            ->addChild('new', $new);
        $this->getLayout()
            ->toHtml();
    }

    public function ListAction() {
        $list = $this->getLayout()
            ->createBlock('ems/event_list');
        $this->getLayout()
            ->getChild('content')
            ->addChild('list', $list);
        $this->getLayout()
            ->getChild('head')
            ->addCss('ems/event/list.css');
        $this->getLayout()
            ->toHtml();
    }

    public function saveAction() {
        Mage::getModel('ems/event')
            ->setData($this->getRequest()->getParam('event'))
            ->setCreatedBy($this->getSession()->get('adminlogin'))
            ->save();
        $this->redirect('ems/event/list');
    }

    public function DeleteAction() {
        Mage::getModel('ems/event')
            ->load($this->getRequest()->getQuery('delete_id'))
            ->delete();

        $this->getMessage()
            ->addSuccess('Event Deleted.');

        $this->redirect("ems/event/list");
    }

    public function viewAction() {
        $view = $this->getLayout()
            ->createBlock('ems/event_view');
        $this->getLayout()
            ->getChild('content')
            ->addChild('view', $view);
        $this->getLayout()
            ->getChild('head')
            ->addCss('ems/event/list.css')
            ->addJs('ems/view.js');
        $this->getLayout()
            ->toHtml();
    }

    public function updateStatusAction() {
        $data = $this->getRequest()->getParam('event');
        $status = Mage::getModel('ems/registrations')
            ->load($data['registration_id'])
            ->setStatus($data['status'])
            ->setUpdatedAt(Date('Y-m-d H:i:s'))
            ->save();
        // Mage::log($status->getEventId());

        // echo json_encode(["success"=>true, "message"=>"successfully."]);
        $this->redirect('ems/event/view?event_id='.$status->getEventId());
    }
}

?>