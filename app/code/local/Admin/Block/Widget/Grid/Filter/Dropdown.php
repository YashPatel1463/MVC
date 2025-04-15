<?php

class Admin_Block_Widget_Grid_Filter_Dropdown extends Admin_Block_Widget_Grid_Filter_Abstract
{
    public function render()
    {
        $output = '<select name="filter">';
        $output .= '<option value="all">All</option>';
        // foreach () {
            
        // }
        return $output;
    }
}