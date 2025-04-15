<?php

class Admin_Block_Category_Index_List extends Admin_Block_Widget_Grid
{
    protected $_collection;

    public function __construct()
    {
        $this->addColumn('category_id', [
            'render' => 'text',
            'filter' => 'number',
            'data_index' => 'category_id',
            'lable' => 'Category Id'
        ]);

        $this->addColumn('name', [
            'render' => 'text',
            'filter' => 'text',
            'data_index' => 'name',
            'lable' => 'Name'
        ]);

        $this->addColumn('description', [
            'render' => 'text',
            'filter' => 'text',
            'data_index' => 'description',
            'lable' => 'Description'
        ]);

        $this->addColumn('parent_id', [
            'render' => 'text',
            'filter' => 'number',
            'data_index' => 'parent_id',
            'lable' => 'Parent Category Id'
        ]);

        $this->addColumn('edit', [
            'render' => 'link',
            'data_index' => 'category_id',
            'lable' => 'Edit',
            'action' => 'new',
            'param' => 'edit_id',
            'is_filter' => 0,
            'class' => ['btn', 'view-btn'],
            'callback' => 'getEditUrl'
        ]);

        $this->addColumn('delete', [
            'render' => 'link',
            // 'filter' => 'text',
            'data_index' => 'category_id',
            'lable' => 'Delete',
            'action' => 'delete',
            'param' => 'delete_id',
            'is_filter' => 0,
            'class' => ['btn', 'btn-danger'],
            'callback' => 'getDeleteUrl'
        ]);

        $category = Mage::getModel("catalog/category")
            ->getCollection();
        $this->setCollection($category);

        Parent::__construct();
    }


    public function getEditUrl($row)
    {
        return $this->getUrl('*/*/new') . '?edit_id=' . $row->getCategoryId();
    }

    public function getDeleteUrl($row)
    {
        return $this->getUrl('*/*/delete') . '?delete_id=' . $row->getCategoryId();
    }
}
