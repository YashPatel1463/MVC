<?php 

class Admin_Block_Widget_Grid_Columns_Abstract {
    protected $_data;
    protected $_row;
    protected $_link;

    public function render() {
        return "<span>".$this->getValue()."</span>";
    }

    public function setRow($data) {
        $this->_row = $data;
    }

    public function getRow() {
        return $this->_row;
    }

    public function getValue() {
        return $this->_row->{$this->_data['data_index']};
    }

    public function getIsFilter() {
        return $this->_data['is_filter'];
    }

    public function setData($data) {
        $this->_data = $data;
        return $this;
    }

    public function getData() {
        return $this->_data;
    }

    public function setLink($link) {
        $this->_link = $link;
        return $this;
    }

    public function getLink() {
        return $this->_link;
    }

    public function getFilter()
    {
        if (isset($this->_data['filter'])) {
            return Mage::getBlock("admin/widget_grid_filter_{$this->_data['filter']}")
                ->setData($this->getData());
        }
    }   
}

?>