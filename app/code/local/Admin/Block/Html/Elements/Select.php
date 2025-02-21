<?php 

class Admin_Block_Html_Elements_Select {
    protected $_data = [];

    public function __construct($data) {
        $this->_data =$data;
    }

    public function render() {
        $html = sprintf("<select id='%s' name='%s'>",$this->_data['id'],$this->_data['name']);
        $html .= sprintf("<option value='' disabled selected>--SELECT YOUR CITY--</option>");

        foreach ($this->_data['option'] as $value => $name) {
            $html .= sprintf("<option value='%s'>%s</option>",$value,ucfirst($name));
        }
        $html .= "</select>";
        return $html;
    }
}

?>