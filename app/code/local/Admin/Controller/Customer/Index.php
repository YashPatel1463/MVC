<?php

class Admin_Controller_Customer_Index extends Core_Controller_Admin_Action
{
    public function newAction()
    {
        // echo __CLASS__ . "----" . __FUNCTION__;
        $new = $this->getLayout()->createBlock('admin/customer_index_new')
            ->setTemplate('admin/customer/index/new.phtml');
        $this->getLayout()->getChild('content')->addChild('new', $new);
        $this->getLayout()->toHtml();
    }

    public function listAction()
    {
        $list = $this->getLayout()->createBlock('admin/customer_index_list');
        $this->getLayout()->getChild('content')->addChild('list', $list);
        $this->getLayout()->getChild('head')->addCss('admin/sales/order/list.css')
            ->addJs('admin/customer/index/list.js');
        $this->getLayout()->toHtml();
    }

    public function saveAction()
    {
        // echo get_class() . "----" . __FUNCTION__;
        $save = $this->getLayout()->createBlock('admin/customer_index_save')
            ->setTemplate('admin/customer/index/save.phtml');
        $this->getLayout()->getChild('content')->addChild('save', $save);
        $this->getLayout()->toHtml();
    }

    public function deleteAction()
    {
        // echo get_class() . "----" . __FUNCTION__;
        $delete = $this->getLayout()->createBlock('admin/customer_index_delete')
            ->setTemplate('admin/customer/index/delete.phtml');
        $this->getLayout()->getChild('content')->addChild('delete', $delete);
        $this->getLayout()->toHtml();
    }

    public function importAction()
    {
        $csvMimes = ['text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain'];


        if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)) {
            if (is_uploaded_file($_FILES['file']['tmp_name'])) {
                $csvfile = fopen($_FILES['file']['tmp_name'], 'r');

                fgetcsv($csvfile);
                
                while (($line = fgetcsv($csvfile)) !== FALSE) {
                    Mage::getModel("customer/account")
                        ->setFirstName($line[1])
                        ->setLastName($line[2])
                        ->setEmail($line[3])
                        ->setPhone($line[4])
                        ->setBirthdate($line[5])
                        ->setGender($line[6])
                        ->setPassword($line[7])
                        ->save();
                }

                fclose($csvfile);
            }
        }
        $this->redirect('admin/customer_index/list');
    }
}
