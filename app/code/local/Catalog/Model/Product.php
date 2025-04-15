<?php

class Catalog_Model_Product extends Core_Model_Abstract
{
    // public $status = [0 => "Disable", 1 => "Enable"];
    public function init()
    {
        $this->_resourceClassName = "Catalog_Model_Resource_Product";
        $this->_collectionClassName = "Catalog_Model_Resource_Product_Collections";
    }

    // public function getStatusText()
    // {
    //     return isset($this->status[$this->getStatus()]) ? $this->status[$this->getStatus()] : "NA";
    // }

    protected function _afterLoad()
    {
        if ($this->getProductId()) {
            $collection = Mage::getModel("catalog/product_attribute")
                ->getCollection()
                ->addFieldToFilter("product_id", $this->getProductId())
                ->leftJoin(["attr" => "catalog_attribute"], "attr.attribute_id = main_table.attribute_id", ["name" => "attribute_code"]);

            $imagescollection = Mage::getModel("catalog/media_gallery")
                ->getCollection()
                ->addFieldToFilter("product_id", $this->getProductId());

            // echo "<pre>";
            // print_r($collection->getData());
            // print_r($imagescollection->getData());
            // echo "</pre>";

            foreach ($collection->getData() as $_data) {
                $this->{$_data->getName()} = $_data->getValue();
            }

            $filepaths = [];
            foreach ($imagescollection->getData() as $image) {
                $filepaths[] = $image->getFilePath();
                if ($image->getDefaultImage()) {
                    $default_image = $image->getFilePath();
                    $this->_data['default_image'] = $default_image;
                }
            }

            $this->_data['file_path'] = $filepaths;

            // echo "<pre>";
            // print_r($collection->getData());
            // echo "</pre>";
        }
        // echo "<pre>";
        // print_r($this);
        // echo "</pre>";
        return $this;
    }

    protected function _afterSave()
    {
        // echo "<pre>";
        // echo "</pre>";
        // die();

        // echo "<pre>";
        // print_r($this);
        // print_r($deleteimg);
        // echo "</pre>";
        // die();

        $attributes = Mage::getModel("catalog/attribute")
            ->getCollection()
            ->getData();

        foreach ($attributes as $_attribute) {
            $product_attributes = Mage::getModel("catalog/product_attribute")
                ->getCollection()
                ->addFieldToFilter("product_id", $this->getProductId())
                ->addFieldToFilter("attribute_id", $_attribute->getAttributeId())
                ->getData();

            // $data = $product_attributes->getData()[0];
            // echo "<pre>";
            // print_r($product_attribute->getData()[0]);
            // echo "</pre>";
            $value = $this->{$_attribute->getAttributeCode()};
            if (isset($product_attributes[0])) {
                $product_attributes[0]
                    ->setAttributeId($_attribute->getAttributeId())
                    ->setProductId($this->getProductId())
                    ->setValue($value)
                    ->save();
            } else {
                Mage::getModel("catalog/product_attribute")
                    ->setAttributeId($_attribute->getAttributeId())
                    ->setProductId($this->getProductId())
                    ->setValue($value)
                    ->save();
            }
        }

        $deleteimg = Mage::getModel('core/request')
            ->getParam('catalog_image_delete');

        if (isset($deleteimg['images'])) {
            foreach ($deleteimg['images'] as $img) {
                $product_media = Mage::getModel("catalog/media_gallery")
                                    ->load($img, "file_path");

                                    // echo "<pre>";
                                    // print_r($product_media);
                                    // echo "</pre>";
                if (file_exists($img)) {
                    unlink($img);
                }
                $product_media->delete();
            }
        }
        // echo "<pre>";
        // print_r($_FILES);
        // print_r($this);
        // echo "</pre>";
        // 
        // }
        // die();
        if (isset($_FILES['catalog_product']['name']['image']) && $_FILES['catalog_product']['error']['image'][0] == 0) {
            for ($i = 0; $i < count($_FILES['catalog_product']['name']['image']); $i++) {
                $default_image = ($_FILES['catalog_product']['name']['image'][$i] == $this->getDefaultImage()) ? 1 : 0;

                // echo $_FILES['catalog_media_gallery']['name']['image'][$i];
                $file_path = $this->getProductId() . "_" . time() . "_" . $_FILES['catalog_product']['name']['image'][$i];
                $tmp_name = $_FILES['catalog_product']['tmp_name']['image'][$i];
                $type = $_FILES['catalog_product']['type']['image'][$i];
                $type = substr($type, 0, strpos($type, '/'));

                // $product_media = Mage::getModel("catalog/media_gallery")
                //     ->getCollection()
                //     ->addFieldToFilter("product_id", $this->getProductId())
                //     ->getData();

                // if(isset($product_media[0])) {

                // } else {
                Mage::getModel("catalog/media_gallery")
                    ->setProductId($this->getProductId())
                    ->setFilePath("Media/Product/" . $file_path)
                    ->setType($type)
                    ->setDefaultImage($default_image)
                    ->save();
                // }

                // $product_image_data = [
                //     "product_id" => $product_id,
                //     "file_path" => "Media/Product/" . $file_path,
                //     "type" =>  $type,
                //     "default_image" => $default_image
                // ];

                // $product_media = Mage::getModel("catalog/media_gallery");
                // $product_media->setData($product_image_data);
                // $piid = $product_media->save();

                // if ($piid) {
                move_uploaded_file($tmp_name, "Media/Product/" . $file_path);
                // } else {
                //     echo "File not uploaded.";
                // }
            }
        }

        // die();
    }
}
