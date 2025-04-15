<?php 

class Admin_Block_Widget_Grid_Filter_Abstract {
    protected $_data;

    public function render() {
        return "<span></span>";
    }

    public function setData($data) {
        $this->_data = $data;
        return $this;
    }

    public function getData() {
        return $this->_data;
    }
}

?>