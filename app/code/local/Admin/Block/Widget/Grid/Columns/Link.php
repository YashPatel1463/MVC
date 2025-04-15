<?php

class Admin_Block_Widget_Grid_Columns_Link extends Admin_Block_Widget_Grid_Columns_Abstract {
    public function render() {
        // Mage::log($this->getLink()->{$this->getData()['callback']}($this->getRow()));
        // Mage::log($this->getLink()->{$this->getData()['callback']}($this->getRow()));
        $output = '<a href="' . $this->getLink()->{$this->getData()['callback']}($this->getRow()) . '"';
        $output .= ' class ="' . implode(' ', $this->getData()['class']) . '"';

        if ($this->getData()['action'] == 'delete') {
            $output .= `onclick="return confirm('Are you sure you want to delete this record?');"`;
        }

        $output .= '>';
        $output .= $this->getData()['lable'];
        $output .= '</a>';
        return $output;
    }

}

?>