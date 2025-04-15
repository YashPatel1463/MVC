<?php

class Cms_Controller_Index extends Core_Controller_Front_Action {
    // public function __construct() {
    //     // $class = Mage::getBlock('core/layout');    
    //     // echo $class;
        
    // }

    public function indexAction() {
        // echo "default index page";
        $layout =  Mage::getBlock('core/layout');
        $slide = $layout->createBlock("cms/index_slide");
        $layout->getChild('content')->addChild('slide',$slide);
        $products = $layout->createBlock("cms/index_products");
        $layout->getChild('content')->addChild('products',$products);
        $layout->getChild('head')->addCss("cms/slider.css")
                                ->addJs("cms/slider.js");
        $layout->toHtml();
    }
}

?>