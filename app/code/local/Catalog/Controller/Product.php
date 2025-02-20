<?php

class Catalog_Controller_Product
{
    public function viewAction()
    {
        // echo get_class() . "----" . __FUNCTION__;
        $product = Mage::getModel('catalog/product');
        $resource = $product->getResourceModel();

        // echo "<pre>";
        // print_r($product);
        // print_r($resource);
        // echo "</pre>";

        $layout =  Mage::getBlock('core/layout');
        $view = $layout->createBlock('catalog/product_view')
            ->setTemplate('catalog/product/view.phtml');
        // echo "<pre>";
        // print_r($view);
        // echo "</pre>";
        $layout->getChild('content')->addChild('view', $view);
        // print_r($layout);
        $layout->toHtml();
    }

    public function listAction()
    {
        // echo get_class() . "----" . __FUNCTION__;
        $layout =  Mage::getBlock('core/layout');
        $list = $layout->createBlock('catalog/product_list')
            ->setTemplate('catalog/product/List.phtml');
        // echo "<pre>";
        // print_r($view);
        // echo "</pre>";
        $layout->getChild('content')->addChild('list', $list);
        $layout->toHtml();
    }

    public function TestAction()
    {
        // echo get_class() . "----" . __FUNCTION__;
        $product = Mage::getModel('catalog/product')
                        ->getCollection()
                        // ->addFieldToFilter('product_id',28)
                        // ->join("catlog_category","catlog_category.category_id = catlog_product.category_id", ["category_name" => "name"])
                        ->leftJoin("catlog_category","catlog_category.category_id = catlog_product.category_id", ["category_name" => "name"]);
                        // ->rightJoin("catlog_category","catlog_category.category_id = catlog_product.category_id", ["category_name" => "name"]);
                        // ->fullJoin("catlog_category","catlog_category.category_id = catlog_product.category_id", ["category_name" => "name"])
                        // ->orderBy(["price desc","rating"])
                        // ->orderBy(["price"]);
                        // ->addFieldToFilter('product_id',["IN"=>[2,3,4]]);
                        // ->groupBy(["price","rating"]);
                        // ->groupBy("catlog_product.category_id")
                        // ->having('product_id',28)
                        // ->having('count(catlog_product.category_id)',[">"=>1])
                        // ->limit(10);
        
        // $product->getData();

        echo "<pre>";
        print_r($product->getData());
        echo "</pre>";
    }
}
