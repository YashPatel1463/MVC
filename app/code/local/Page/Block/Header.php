<?php

class Page_Block_Header extends Core_Block_Template
{
    public function __construct()
    {
        $this->setTemplate('page/header.phtml');
    }

    public function getCategories() {
        $category = Mage::getModel("catalog/category")
                    ->getCollection()
                    ->addFieldToFilter('parent_id',["="=>"1"]);
        return $category->getData();
    }

    public function getSubCategoey($category) {
        $category = Mage::getModel("catalog/category")
                        ->getCollection()
                        ->addFieldToFilter('parent_id',["="=>$category]);
        return $category->getData();
    }
    
    public function renderCategoryMenu($categories)
    {
        echo '<div class="header-category-menu">';
        echo '<ul class="header-category-list">';
        foreach ($categories as $category) {
            // Dynamic category URL
            $categoryUrl = $this->getUrl("catalog/product/list").'/?categoryid='. $category["category_id"];
    
            echo '<li class="header-category-item">';
            echo '<a href="' . $categoryUrl . '" class="header-category-link" data-id="' . $category['category_id'] . '">' . 
                    $category['name'] . 
                    '<span class="header-category-toggle">+</span>' . 
                 '</a>';
    
            // If category has children, render them recursively
            if (!empty($category['children'])) {
                echo '<ul class="header-category-submenu" id="header-category-' . $category['category_id'] . '">';
                $this->renderCategoryMenu($category['children']);
                echo '</ul>';
            }
            echo '</li>';
        }
        echo '</ul>';
        echo '</div>';
    }
    

    public function getCategoryTree($categories, $parentId = 1)
    {
        $tree = [];
        // echo "<pre>";
        // print_r($categories);
        // die();
        foreach ($categories as $cat) {
            $category = $cat->getData();
            if ($category['parent_id'] == $parentId) {
                $children = $this->getCategoryTree($categories, $category['category_id']);
                if ($children) {
                    $category['children'] = $children;
                }
                $tree[] = $category;
            }
        }
        return $tree;
    }
}
