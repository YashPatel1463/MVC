<?php

class Admin_Block_Customer_Index_List extends Admin_Block_Widget_Grid
{
    protected $_collection;

    public function __construct()
    {
        $this->addColumn('customer_id', [
            'render' => 'text',
            'filter' => 'number',
            'data_index' => 'customer_id',
            'lable' => 'Customer Id'
        ]);

        $this->addColumn('first_name', [
            'render' => 'text',
            'filter' => 'text',
            'data_index' => 'first_name',
            'lable' => 'First Name'
        ]);

        $this->addColumn('last_name', [
            'render' => 'text',
            'filter' => 'text',
            'data_index' => 'last_name',
            'lable' => 'Last Name'
        ]);

        $this->addColumn('email', [
            'render' => 'text',
            'filter' => 'text',
            'data_index' => 'email',
            'lable' => 'Email'
        ]);

        $this->addColumn('phone', [
            'render' => 'text',
            'filter' => 'number',
            'data_index' => 'phone',
            'lable' => 'Phone'
        ]);

        $this->addColumn('birthdate', [
            'render' => 'text',
            'filter' => 'number',
            'data_index' => 'birthdate',
            'lable' => 'Birth Date'
        ]);

        $this->addColumn('gender ', [
            'render' => 'text',
            'filter' => 'text',
            'data_index' => 'gender',
            'lable' => 'Gender'
        ]);

        $this->addColumn('edit', [
            'render' => 'link',
            'data_index' => 'customer_id',
            'lable' => 'Edit',
            'action' => 'new',
            'param' => 'edit_id',
            'class' => ['btn', 'btn-primary'],
            'is_filter' => 0,
            'callback' => 'getEditUrl'
        ]);

        // $this->addColumn('delete', [
        //     'render' => 'link',
        //     // 'filter' => 'text',
        //     'data_index' => 'product_id',
        //     'lable' => 'Delete',
        //     'action' => 'delete',
        //     'param' => 'delete_id',
        //     'class' => ['btn', 'btn-danger'],
        //     'is_filter' => 0,
        //     'callback' => 'getDeleteUrl'
        // ]);

        $customer = Mage::getModel("customer/account")
            ->getCollection();

        $this->setCollection($customer);

        Parent::__construct();
    }

    public function getEditUrl($row)
    {
        // echo "123";
        return $this->getUrl('*/*/new') . '?edit_id=' . $row->getCustomerId();
    }

    public function getDeleteUrl($row)
    {
        return $this->getUrl('*/*/delete') . '?delete_id=' . $row->getProductId();
    }
}
