<?php

class Catalog_Controller_Category
{
    public function listAction()
    {
        // echo get_class() . "----" . __FUNCTION__;
        $layout = Mage::getBlock('core/layout');
        $list = $layout->createBlock('catalog/category_list');
        $layout->getChild('content')->addChild('list', $list);
        $layout->toHtml();
    }

    public function getSubCategoey($category)
    {
        $category = Mage::getModel("catalog/category")
            ->getCollection()
            ->addFieldToFilter('parent_id', ["=" => $category]);
        return $category->getData();
    }

    public function subCategoryAction()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (isset($data['category_id'])) {
            $categoryId = intval($data['category_id']);

            // Fetch subcategories from the database
            $subcategories = $this->getSubCategoey($categoryId);

            // Prepare response
            $response = array_map(function ($sub) {
                return [
                    "id" => $sub->getCategoryId(),
                    "name" => $sub->getName()
                ];  
            }, $subcategories);

            // Return JSON response
            header('Content-Type: application/json');
            echo json_encode($response);
        } else {
            echo json_encode(["error" => "Invalid category ID"]);
        }       
    }
}
