<?php

class Admin_Controller_Product_Index extends Core_Controller_Admin_Action
{
    // protected $_allowedActions = ["list"];
    public function newAction()
    {
        // echo get_class() . "<br>" . __FUNCTION__;
        $new = $this->getLayout()->createBlock('admin/product_index_new');
        $this->getLayout()->getChild('content')
            ->addChild('new', $new);
        $this->getLayout()->getChild('head')->addJs('admin/new.js')
            ->addCss('admin/form.css');
        $this->getLayout()->toHtml();
    }

    public function listAction()
    {
        $list = $this->getLayout()->createBlock('admin/product_index_list');
        $this->getLayout()->getChild('content')->addChild('list', $list);
        $this->getLayout()->getChild('head')->addCss('admin/sales/order/list.css');
        // $fiters = $this->getRequest()->getQuery();
        // Mage::log($fiters);
        $this->getLayout()->toHtml();
    }

    public function saveAction()
    {
        $request = Mage::getModel("core/request");
		
        $data = $request->getParam('catalog_product');

        // $image = $request->getParam('catalog_media_gallery');
        // echo "<pre>";
        // // print_r($image);
        // print_r($_FILES);
        // print_r($data);
        // echo "</pre>";
        // die();
        // $pattributes = array_filter($request->getParam('catalog_product_attribute'));
        //Mage::log($data);
		//die;
		$product = Mage::getModel('catalog/product')
            ->load($data["product_id"]);

        // $attributes_model = Mage::getModel('catalog/attribute');
        // $product_attribute_model = Mage::getModel("catalog/product_attribute");

        $product->setData($data);
        $id = $product->save();
        // echo $url = Mage::getBaseUrl() . $request->getModuleName() . "/" . $request->getControllerName() . "/list";
        // // die();
        // header("location:{$url}");
        $this->getMessage()
            ->addSuccess('New Product Added.');
        $this->redirect("admin/product_index/list");
    }

    public function deleteAction()
    {
        // echo get_class() . "----" . __FUNCTION__;
        $request = Mage::getModel("core/request");
        $product = Mage::getModel('catalog/product');

        // $product->setData($data);
        $class = Mage::getModel('core/request');
        $id = $class->getQuery('delete_id');
        // echo $id;
        $data = $product->load($id);
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        // die();
        $file_path = $data->getImage();

        $id = $product->delete();
        if ($id) {
            unlink($file_path);
        }
        $this->getMessage()
            ->addSuccess('Product Deleted.');

        $this->redirect("admin/product_index/list");
    }

    public function exportAction()
    {
        $fname = "product_list.csv";

        $products = Mage::getModel('catalog/product')
            ->getCollection()
            ->addAttributeToSelect(["color", "weight", "material", "warranty", "manufacturer", "countryoforigin"])
            ->getData();

        if (empty($products)) {
            die('No products found.');
        }

        $header = array_keys($products[0]->getData());

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $fname . '";');

        $file = fopen("php://output", "w");
        fputcsv($file, $header, ",");

        foreach ($products as $product) {
            fputcsv($file, array_values($product->getData()), ",");
        }

        fclose($file);
        
        $this->getMessage()
            ->addSuccess('Data Exported.');
    }


    public function testAction()
    {
        // echo get_class() . "<br>" . __FUNCTION__;
        $test = $this->getLayout()->createBlock('admin/product_index_test');
        $this->getLayout()->getChild('content')->addChild('test', $test);
        $this->getLayout()->toHtml();
    }

    public function test2Action() {
        echo Mage::getModel('catalog/product')
            ->getCollection()
            ->select(['total' => 'count(*)'])
            ->prepareQuery();
    }
}
