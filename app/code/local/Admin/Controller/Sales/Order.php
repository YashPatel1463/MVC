<?php

class Admin_Controller_Sales_Order extends Core_Controller_Admin_Action
{

    public function listAction()
    {
        $layout = $this->getLayout();
        $list = $layout->createBlock("admin/sales_order_list");
        $layout->getChild('content')->addChild("list", $list);
        $layout->getChild('head')->addCss("admin/sales/order/list.css")
            ->addJs("admin/sales/order/list.js");
        $layout->toHtml();
    }

    public function viewAction()
    {
        $order_id = $this->getRequest()->getQuery('order_id');
        $order = Mage::getModel("sales/order")
            ->load($order_id);

        $layout =  $this->getLayout();
        $view = $layout->createBlock('admin/sales_order_view')
            ->setOrderData($order);

        $order_info = $layout->createBlock('admin/sales_order_view_info'); //orders
        // ->setOrderBlock($view);
        $view->addChild('order_info', $order_info);
        // Mage::log($layout);
        // die;
        $order_address = $layout->createBlock('admin/sales_order_view_address');
        // ->setOrderBlock($view);
        $view->addChild('order_address', $order_address);
        $order_item = $layout->createBlock('admin/sales_order_view_item');
        // ->setOrderBlock($view);
        $view->addChild('order_item', $order_item);

        $layout->getChild('content')
            ->addChild('view', $view);
        // Mage::log($layout);
        // die;
        $layout->getChild('head')
            ->addCss('admin/sales/order/view/detail.css');
        $layout->toHtml();
    }

    public function updateStatusAction()
    {
        $order = $this->getRequest()->getParam('order');

        Mage::getModel("sales/order")
            ->load($order['order_id'])
            ->setOrderStatus($order['order_status'])
            ->save();
        $this->getMessage()
            ->addSuccess($order['order_id']." order id's order is " . $order['order_status']);
        // $this->redirect("admin/sales_order/list");
    }
}
