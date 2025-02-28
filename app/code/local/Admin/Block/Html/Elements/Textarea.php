<?php 

class Admin_Block_Html_Elements_Textarea {
    protected $_data = [];

    public function __construct($data) {
        $this->_data =$data;
    }

    public function render() {
        // <textarea id="description" name="catlog_product[description]" required></textarea>
        $html = "<Textarea ";
        if(isset($this->_data['id'])) {
            $html .= sprintf(" id='%s'",$this->_data['id']);
        }
        if(isset($this->_data['class'])) {
            $html .= sprintf(" class='%s'",$this->_data['class']);
        }
        if(isset($this->_data['name'])) {
            $html .= sprintf(" name='%s'",$this->_data['name']);
        }
        $html .= ">";
        if(isset($this->_data['value'])) {
            $html .= sprintf("%s",$this->_data['value']);
        }
        $html .= "</textarea>";
        return $html;
    }
}

?>