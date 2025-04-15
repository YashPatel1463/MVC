<?php
class Admin_Block_Widget_Grid extends Core_Block_Template
{
    protected $_collection;
    protected $_columns = [];

    public function __construct()
    {
        $this->setTemplate('admin/widget/grid.phtml');
        $this->getLayout()
            ->getChild('head')
            ->addCss('admin/sales/order/list.css')
            ->addJs('admin/grid/list.js');
        $toolbar = $this->getLayout()->createBlock("admin/widget_grid_toolbar")
            ->setTemplate("admin/widget/grid/toolbar.phtml");
        $this->getLayout()->getChild('head')->addJs('admin/grid/toolbar.js');
        $export = $this->getLayout()->createBlock("admin/widget_grid_export")
            ->setTemplate("admin/widget/grid/export.phtml");

        $this->addChild("toolbar", $toolbar);
        $this->addChild("export", $export);
        $this->init();
    }

    public function init()
    {
        $this->getChild('toolbar')->prepareToolbar();
        $this->getChild('export')->prepareCsv();
    }

    public function addColumn($key, $data)
    {
        if (!isset($data['is_filter'])) {
            $data['is_filter'] = 1;
        }

        $columnBlock = Mage::getBlock("admin/widget_grid_columns_{$data['render']}")
            ->setData($data)
            ->setLink($this);

        $this->_columns[$key] = $columnBlock;
    }

    public function getColumns()
    {
        return $this->_columns;
    }

    public function setCollection($collection)
    {
        $this->_collection = $collection;
        return $this;
    }

    public function getCollection()
    {
        // $fiters = $this->getRequest()->getQuery();
        // Mage::log($fiters);
        return $this->_collection;
    }

    // public function renderFilter($data)
    // {
    //     if (isset($data['filter'])) {
    //         $filter = Mage::getBlockSingleTon("admin/widget_grid_filter_{$data['filter']}");
    //         $filter->setFilter($data);
    //         echo $filter->toHtmlTag();
    //     }
    // }

    public function renderColumn($data, $id)
    {
        $data['id'] = $id;
        $filter = Mage::getBlockSingleTon("admin/widget_grid_columns_{$data['render']}");
        $filter->setType($data);
        echo $filter->toHtmlTag();
    }

    public function getValue($data)
    {
        echo $data;
    }
}
