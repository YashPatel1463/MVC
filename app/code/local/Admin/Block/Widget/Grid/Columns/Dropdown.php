<?php

class Admin_Block_Widget_Grid_Columns_Dropdown extends Admin_Block_Widget_Grid_Columns_Abstract
{

    public function render()
    {
        $output = '<select class"' . implode(' ', $this->getData()['class']) . '" name="order">';
        foreach ($this->getData()['option'] as $option) {
            $output .= '<option';
            $output .= ($this->getValue() == $option) ? ' selected' : '';
            $output .= ' value="' . $option . '">';
            $output .= ucfirst($option);
            $output .= '</option>';
        }
        $output .= '</select>';
        return $output;
    }
}
