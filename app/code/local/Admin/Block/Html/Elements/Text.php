<?php 

class Admin_Block_Html_Elements_Text {
    protected $_data = [];

    public function __construct($data) {
        $this->_data =$data;
    }

    public function render() {
        $html = "<input type='text' ";
        if(isset($this->_data['id'])) {
            $html .= sprintf(" id='%s'",$this->_data['id']);
        }
        if(isset($this->_data['class'])) {
            $html .= sprintf(" class='%s'",$this->_data['class']);
        }
        $html .= " />";
        return $html;
    }
}

?>