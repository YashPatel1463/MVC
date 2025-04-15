<?php

class Ems_Block_Grid_Toolbar extends Core_Block_Template {
    public function __construct() {
        $this->getLayout()->getChild('head') //->addJs('admin/grid/toolbar.js')
            ->addCss('admin/grid/toolbar.css')
            ->addJs('admin/grid/toolbar.js');    
    }

    protected $_limit = 5;
    protected $_page = 0;
    protected $_collection;

    public function prepareToolbar() {
		//echo "12";
        $limit = $this->getRequest()->getQuery('limit');
        $page = $this->getRequest()->getQuery('page');

        if(is_numeric($page)) {
            $this->_page = $page;
        } else {
            $this->_page = 1;
        }

        if(is_numeric($limit)){
            $this->_limit = intval($limit);   
        } else {
            // $this->_limit = count($this->_collection
            // ->getData());
        }

        // Mage::log($this->getParent()->getCollection());
        $this->_collection = clone $this->getParent()
            ->getCollection();
        
		//Mage::log($this->getParent()->getCollection()->prepareQuery());
		//die;
        $this->getParent()
            ->getCollection()
            ->limit($this->_limit, $this->_page);
            //->getData();   
    }

    public function getTotalRecords() {
        return count($this->_collection
			->getData());
    }
}

?>