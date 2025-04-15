<?php

class Admin_Block_Widget_Grid_Filter_Text  extends Admin_Block_Widget_Grid_Filter_Abstract
{
    public function render()
    {
        $output = '<input type="search" class="form-control d-inline-block w-45" placeholder="';
        $output .= $this->getData()['lable'] . '" ';
        $output .= ' name="' . $this->getData()['data_index'] .'">';

        return $output;
    }
}
