<?php

class Admin_Block_Widget_Grid_Filter_Number extends Admin_Block_Widget_Grid_Filter_Abstract
{
    public function render()
    {
        $output = '<input type="number" class="form-control d-inline-block w-45" placeholder="From"';
        $output .= ' name="' . $this->getData()['data_index'] .'-from">';
        $output .= '<input type="number" class="form-control d-inline-block w-45" placeholder="To"';
        $output .= ' name="' . $this->getData()['data_index'] .'-to">';
        return $output;
    }
}
