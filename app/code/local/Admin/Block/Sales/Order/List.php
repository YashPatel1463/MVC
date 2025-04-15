<?php

class Admin_Block_Sales_Order_List extends Admin_Block_Widget_Grid
{
    protected $_collection;

    public function __construct()
    {   
        $this->addColumn('order_id', [
            'render' => 'text',
            'filter' => 'number',
            'data_index' => 'order_id',
            'lable' => 'Order Id'
        ]);
        
        $this->addColumn('order_no', [
            'render' => 'text',
            'filter' => 'text',
            'data_index' => 'order_no',
            'lable' => 'Order No'
        ]);
        
        $this->addColumn('customer_id', [
            'render' => 'text',
            'filter' => 'number',
            'data_index' => 'customer_id',
            'lable' => 'Customer ID'
        ]);

        $this->addColumn('date', [
            'render' => 'text',
            // 'filter' => 'text',
            'data_index' => 'created_at',
            'is_filter' => 0,
            'lable' => 'Date Placed'
        ]);

        $this->addColumn('total', [
            'render' => 'text',
            'filter' => 'number',
            'data_index' => 'total_amount',
            'lable' => 'Total Amount'
        ]);

        $this->addColumn('coupon_code', [
            'render' => 'text',
            'filter' => 'text',
            'data_index' => 'coupon_code',
            'lable' => 'Coupon Code'
        ]);

        $this->addColumn('coupon_discount', [
            'render' => 'text',
            'filter' => 'number',
            'data_index' => 'coupon_discount',
            'lable' => 'Coupon Discount'
        ]);

        $this->addColumn('shipping_method', [
            'render' => 'text',
            'filter' => 'text',
            'data_index' => 'shipping_method',
            'lable' => 'Shipping Method'
        ]);

        $this->addColumn('shipping_price', [
            'render' => 'text',
            'filter' => 'number',
            'data_index' => 'shipping_price',
            'lable' => 'Shipping Price'
        ]);

        $this->addColumn('payment_method', [
            'render' => 'text',
            'filter' => 'text',
            'data_index' => 'payment_method',
            'lable' => 'Payment Method'
        ]);

        $this->addColumn('status', [
            'render' => 'dropdown',
            'filter' => 'dropdown',
            'option' => ['pending', 'processing', 'shipped', 'delivered', 'cancelled'],
            'data_index' => 'order_status',
            'is_filter' => 0,
            'lable' => 'Status',
            'class' => ['orderStatus']
        ]);

        $this->addColumn('view', [
            'render' => 'link',
            // 'data_index' => 'order_id',
            'lable' => 'View',
            'action' => 'view',
            'param' => 'order_id',
            'class' => ['view-btn'],
            'is_filter' => 0,
            'callback' => 'getviewUrl'
        ]);

        $order = Mage::getModel("sales/order")
            ->getCollection();
        $this->setCollection($order);

        Parent::__construct();
    }

    public function getViewUrl($row) {
        return $this->getUrl('*/*/view').'?order_id='.$row->getOrderId();
    }
}
