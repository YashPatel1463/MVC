<?php

class Admin_Block_Widget_Grid_Toolbar extends Admin_Block_Widget_Grid {

    public function __construct() {
        $this->getLayout()->getChild('head')->addJs('admin/grid/toolbar.js')
            ->addCss('admin/grid/toolbar.css');    
    }

    protected $_limit = 5;
    protected $_page = 0;
    protected $_collection;

    public function prepareToolbar() {
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

        $this->_collection = clone $this->getParent()
            ->getCollection();
        
        $this->getParent()
            ->getCollection()
            ->limit($this->_limit, $this->_page)
            ->getData();
        
        // return $collection;
    }

    public function getTotalRecords() {
        return count($this->_collection
            ->getData());
    }
}

?>