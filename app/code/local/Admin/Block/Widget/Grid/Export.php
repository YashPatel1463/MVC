<?php

class Admin_Block_Widget_Grid_Export extends Admin_Block_Widget_Grid
{

    public function __construct() {}

    public function prepareCsv()
    {
        if ($this->getRequest()->getQuery('export')) {
            $data = $this->getParent()->getCollection()->getData();

            if (empty($data)) {
                die('No data found.');
            } else {
                $filename =  'data'. substr(get_class($data[0]), strrpos(get_class($data[0]), '_')).'.csv';
                $header = array_keys($data[0]->getData());
            }

            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename='.$filename.';');

            $file = fopen("php://output", "w");
            fputcsv($file, $header, ",");

            foreach ($data as $_data) {
                fputcsv($file, array_values($_data->getData()), ",");
            }

            fclose($file);
            // $this->redirect();
            exit;
        }
    }
}
