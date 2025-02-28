<?php

class Admin_Controller_Product_Index extends Core_Controller_Admin_Action {
    // protected $_allowedActions = ["list"];
    public function newAction() {
        // echo get_class() . "<br>" . __FUNCTION__;
        $layout =  Mage::getBlock('core/layout');
        $new = $layout->createBlock('admin/product_index_new');
        $layout->getChild('content')->addChild('new', $new);
        $layout->getChild('head')->addJs('page/admin/new.js')
                                ->addCss('admin/form.css');
        $layout->toHtml();
    }

    public function listAction() {
        
        // echo get_class() . "----" . __FUNCTION__;
        $layout =  Mage::getBlock('core/layout');
        $list = $layout->createBlock('admin/product_index_list');
        $layout->getChild('content')->addChild('list', $list);
        $layout->getChild('head')->addCss('admin/list.css');
        $layout->toHtml();
    }

    public function saveAction() {
        // echo get_class() . "----" . __FUNCTION__;
        $request = Mage::getModel("core/request");
        $data = $request->getParam('catalog_product');
        $pattributes = array_filter($request->getParam('catalog_product_attribute'));
        $product = Mage::getModel('catalog/product');
        $attributes_model = Mage::getModel('catalog/attribute');
        $product_attribute_model = Mage::getModel("catalog/product_attribute");
        
        $product->setData($data);
        $id = $product->save();
        // $id = "2";
        $product_id = $id->getProductId();
        if($id) {
            // $product_id = $id;
            foreach($pattributes as $clm => $attr){
                $attribute_id = $attributes_model->getCollection()
                                            ->select("attribute_id")
                                            ->addFieldToFilter('name',$clm);
                $aid = $attribute_id->getData()[0]->getAttributeId();

                $productAttribute = $product_attribute_model->getCollection()
                                    ->addFieldToFilter('product_id', $product_id)
                                    ->addFieldToFilter('attribute_id',$aid);
 
                // die();
                if(isset($productAttribute->getData()[0])){
                    $value_id = $productAttribute->getData()[0]->getValueId();
                }
                // echo $value_id;
                $product_attribute_data = ["value_id" => $value_id,
                                            "attribute_id" => $aid,
                                            "product_id" => $product_id,
                                            "value" => $attr];

                // echo "<pre>";
                // print_r($product_attribute_data);
                // echo "</pre>";
                $product_attribute_model->setData($product_attribute_data);
                $attid = $product_attribute_model->save();
            }
            // die();
        }

        // echo "<pre>";
        // print_r($_FILES);
        // echo "</pre>";
        if(isset($_FILES['catalog_product_media']['name']['image'])) {
            for($i=0; $i<count($_FILES['catalog_product_media']['name']['image']); $i++) {
                // echo $_FILES['catalog_product_media']['name']['image'][$i];
                $file_path = $product_id . "_" . time() . "_" . $_FILES['catalog_product_media']['name']['image'][$i];
                $tmp_name = $_FILES['catalog_product_media']['tmp_name']['image'][$i];
                $type = $_FILES['catalog_product_media']['type']['image'][$i];
                $type = substr($type, 0, strpos($type, '/'));

                $product_image_data = ["product_id" => $product_id,
                                       "file_path" => "Media/Product/".$file_path,
                                        "type" =>  $type
                                      ];

                $product_media = Mage::getModel("catalog/media_gallery");
                $product_media->setData($product_image_data);
                $piid = $product_media->save();

                if($piid) {
                    move_uploaded_file($tmp_name, "Media/Product/".$file_path);
                } else {
                    echo "File not uploaded.";
                }
            }

            
        }
        
        // die();
    
        echo $url = Mage::getBaseUrl() . $request->getModuleName() . "/" . $request->getControllerName() . "/new";
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
        $id = $class->getQuery('delete_id');
        // echo $id;
        $data = $product->load($id);
        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        // die();
        $file_path = $data->getImage();

        $id = $product->delete();
        if($id) {
            unlink($file_path);
        }

        header("location: http://localhost/mvcproject/admin/product_index/list");
        // $layout =  Mage::getBlock('core/layout');
        // $delete = $layout->createBlock('admin/product_index_delete')
        //             ->setTemplate('admin/product/index/delete.phtml');
        // $layout->getChild('content')->addChild('delete', $delete);
        // $layout->toHtml();
    }

    public function testAction() {
        // echo get_class() . "<br>" . __FUNCTION__;
        $layout =  Mage::getBlock('core/layout');
        $test = $layout->createBlock('admin/product_index_test');
        $layout->getChild('content')->addChild('test', $test);
        $layout->toHtml();
    }


}

?>