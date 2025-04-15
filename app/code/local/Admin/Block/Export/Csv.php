<?php

class Admin_Block_Export_Csv extends Core_Block_Template {

    public function prepareCsv() {
        echo "export";
        // $fname = "product_list.csv";
    //    Mage::log($this->getParent()->getCollection()->getData());
    

        // if (empty($products)) {
        //     die('No products found.');
        // }
    
        // $header = array_keys($products[0]->getData());  
    
        // header('Content-Type: text/csv');
        // header('Content-Disposition: attachment; filename="'.$fname.'";');
    
        // $file = fopen("php://output", "w");
        // fputcsv($file, $header, ",");
    
        // foreach($products as $product) {
        //     fputcsv($file, array_values($product->getData()), ",");
        // }
    
        // fclose($file);
    }
}

?>