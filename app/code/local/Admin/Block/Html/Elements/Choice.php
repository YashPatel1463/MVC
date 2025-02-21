<?php 

class Admin_Block_Html_Elements_Choice {
    protected $_data = [];

    public function __construct($data) {
        $this->_data =$data;
    }

    public function render() {
        // <input type="radio" name="gender" value="male"> Male
        $html = "";

        foreach ($this->_data['option'] as $value => $name) {
            if($this->_data['type'] == 'radio') {
                $html .= "<input type='radio'";
            }
    
            if($this->_data['type'] == 'checkbox') {
                $html .= "<input type='checkbox'";
            }
            
            if(isset($this->_data['id'])) {
                $html .= sprintf(" id='%s'",$this->_data['id']);
            }
            if(isset($this->_data['name'])) {
                $html .= sprintf(" name='%s'",$this->_data['name']);
            }
            if(isset($value)) {
                $html .= sprintf(" value='%s'",$value);
            }
            $html .= "/>".$name;
        }
        return $html;
    }
}

?>