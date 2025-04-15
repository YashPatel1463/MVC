<?php

class Admin_Block_Product_Index_List extends Admin_Block_Widget_Grid
{
    protected $_collection;

    public function __construct()
    {
        $this->addColumn('product_id', [
            'render' => 'text',
            'filter' => 'number',
            'data_index' => 'product_id',
            'lable' => 'Product Id',
            'name' => 'product_id'
        ]);

        $this->addColumn('name', [
            'render' => 'text',
            'filter' => 'text',
            'data_index' => 'name',
            'lable' => 'Name',
            'name' => 'name'
        ]);

        $this->addColumn('description', [
            'render' => 'text',
            'filter' => 'text',
            'data_index' => 'description',
            'lable' => 'Description'
        ]);

        $this->addColumn('sku', [
            'render' => 'text',
            'filter' => 'text',
            'data_index' => 'sku',
            'lable' => 'SKU'
        ]);

        $this->addColumn('price', [
            'render' => 'text',
            'filter' => 'number',
            'data_index' => 'price',
            'lable' => 'Price'
            // 'name' => "filter['price']"
        ]);

        $this->addColumn('stock_quantity', [
            'render' => 'text',
            'filter' => 'number',
            'data_index' => 'stock_quantity',
            'lable' => 'Stock Quantity'
        ]);

        $this->addColumn('category_id ', [
            'render' => 'text',
            'filter' => 'number',
            'data_index' => 'category_id',
            'lable' => 'Category Id'
        ]);

        $this->addColumn('edit', [
            'render' => 'link',
            'data_index' => 'product_id',
            'lable' => 'Edit',
            'action' => 'new',
            'param' => 'edit_id',
            'class' => ['btn', 'view-btn'],
            'is_filter' => 0,
            'callback' => 'getEditUrl'
        ]);

        $this->addColumn('delete', [
            'render' => 'link',
            // 'filter' => 'text',
            'data_index' => 'product_id',
            'lable' => 'Delete',
            'action' => 'delete',
            'param' => 'delete_id',
            'class' => ['btn', 'btn-danger'],
            'is_filter' => 0,
            'callback' => 'getDeleteUrl'
        ]);

        $product = Mage::getModel("catalog/product")
            ->getCollection();

        $fliters = $this->getRequest()->getQuery();

        if (!empty($fliters['product_id-from']) || !empty($fliters['product_id-to'])) {
            $product->addFieldToFilter('product_id', ['>=' => ($fliters['product_id-from'] == "") ? 1 : $fliters['product_id-from']]);
            $product->addFieldToFilter('product_id', ['<=' => ($fliters['product_id-to'] == "") ? PHP_INT_MAX : $fliters['product_id-to']]);
        }

        if (!empty($fliters['price-from']) || !empty($fliters['price-to'])) {
            $product->addFieldToFilter('price', ['>=' => ($fliters['price-from'] == "") ? 1 : $fliters['price-from']]);
            $product->addFieldToFilter('price', ['<=' => ($fliters['price-to'] == "") ? PHP_INT_MAX : $fliters['price-to']]);
        }

        if (!empty($fliters['stock_quantity-from']) || !empty($fliters['stock_quantity-to'])) {
            $product->addFieldToFilter('stock_quantity', ['>=' => ($fliters['stock_quantity-from'] == "") ? 1 : $fliters['stock_quantity-from']]);
            $product->addFieldToFilter('stock_quantity', ['<=' => ($fliters['stock_quantity-to'] == "") ? PHP_INT_MAX : $fliters['stock_quantity-to']]);
        }

        if (!empty($fliters['category_id-from']) || !empty($fliters['category_id-to'])) {
            $product->addFieldToFilter('category_id', ['>=' => ($fliters['category_id-from'] == "") ? 1 : $fliters['category_id-from']]);
            $product->addFieldToFilter('category_id', ['<=' => ($fliters['category_id-to'] == "") ? PHP_INT_MAX : $fliters['category_id-to']]);
        }

        if (!empty($fliters['name'])) {
            $product->addFieldToFilter('name', ['LIKE' => "%{$fliters['name']}%"]);
        }

        if (!empty($fliters['description'])) {
            $product->addFieldToFilter('description', ['LIKE' => "%{$fliters['description']}%"]);
        }

        if (!empty($fliters['sku'])) {
            $product->addFieldToFilter('sku', ['LIKE' => "%{$fliters['sku']}%"]);
        }

        $this->setCollection($product);

        Parent::__construct();
    }

    public function getEditUrl($row)
    {
        // echo "123";
        return $this->getUrl('*/*/new') . '?edit_id=' . $row->getProductId();
    }

    public function getDeleteUrl($row)
    {
        return $this->getUrl('*/*/delete') . '?delete_id=' . $row->getProductId();
    }
}
