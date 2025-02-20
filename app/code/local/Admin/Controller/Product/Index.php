<?php

class Admin_Controller_Product_Index {
    public function newAction() {
        // echo get_class() . "<br>" . __FUNCTION__;
        $layout =  Mage::getBlock('core/layout');
        $new = $layout->createBlock('admin/product_index_new');
        $layout->getChild('content')->addChild('new', $new);
        $layout->toHtml();
    }

    public function listAction() {
        // echo get_class() . "----" . __FUNCTION__;
        $layout =  Mage::getBlock('core/layout');
        $list = $layout->createBlock('admin/product_index_list');
        $layout->getChild('content')->addChild('list', $list);
        $layout->getChild('head')->addCss('list/list.css');
        $layout->toHtml();
    }

    public function saveAction() {
        // echo get_class() . "----" . __FUNCTION__;
        $request = Mage::getModel("core/request");
        $data = $request->getParam('catlog_product');
        $product = Mage::getModel('catalog/product');

        if(isset($_FILES['catlog_product']['name']['image']) && $_FILES['catlog_product']['error']['image'] == 0) {
            $file_path = time() . "_" . $_FILES['catlog_product']['name']['image'];
            $tmp_name = $_FILES['catlog_product']['tmp_name']['image'];

            $data['image'] = "Media/Product/".$file_path;
        }
        
        $product->setData($data);
        
        $id = $product->save();

        if($id) {
            move_uploaded_file($tmp_name, "Media/Product/".$file_path);
        } else {
            echo "File not uploaded.";
        }
        
        echo $url = Mage::getBaseUrl() . $request->getModuleName() . "/" . $request->getControllerName() . "/list";
        // die();
        header("location: {$url}");
        exit();
    }
    
    public function deleteAction() {
        // echo get_class() . "----" . __FUNCTION__;
        $request = Mage::getModel("core/request");
        $product = Mage::getModel('catalog/product');

        // $product->setData($data);
        $class = Mage::getModel('core/request');
        $id = $class->getQuery('id');
        // echo $id;
        $data = $product->load($id);
        $file_path = $data->getImage();

        $id = $product->delete();
        if($id) {
            unlink($file_path);
        }

        header("location: http://localhost/mvc/admin/product_index/list");
        // $layout =  Mage::getBlock('core/layout');
        // $delete = $layout->createBlock('admin/product_index_delete')
        //             ->setTemplate('admin/product/index/delete.phtml');
        // $layout->getChild('content')->addChild('delete', $delete);
        // $layout->toHtml();
    }


}

?>