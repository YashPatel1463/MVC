<?php

class Catalog_Controller_Product
{
    public function viewAction()
    {
        // echo get_class() . "----" . __FUNCTION__;
        $layout =  Mage::getBlock('core/layout');
        $view = $layout->createBlock('catalog/product_view');
        $layout->getChild('content')->addChild('view', $view);
        $layout->getChild('head')->addCss('catalog/view.css')
                                ->addJs('catalog/view.js');
        $layout->toHtml();
    }

    public function listAction()
    {
        // echo get_class() . "----" . __FUNCTION__;
        $layout = Mage::getBlock('core/layout');
        $list = $layout->createBlock('catalog/product_list');
        $layout->getChild('content')->addChild('list', $list);
        $layout->getChild('head')->addCss('catalog/list.css')
                                ->addCss("catalog/product/list.css")
                                ->addJs("catalog/list.js");
        $layout->toHtml();
    }

    public function TestAction()
    {
        echo "<pre>";
        $collections = Mage::getModel("catalog/product")
                        ->load("1");
        // ->getCollection()
                            // ->addAttributeToSelect(["color", "material", "weight"])
                            // ->limit(5);
        // print_r($collections);
        echo "</pre>";
    }
}
