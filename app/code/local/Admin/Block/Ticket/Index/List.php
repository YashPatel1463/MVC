<?php

class Admin_Block_Ticket_Index_List extends Admin_Block_Widget_Grid {

    protected $_collection;

    public function __construct()
    {
        $this->addColumn('ticket_id', [
            'render' => 'text',
            'filter' => 'number',
            'data_index' => 'ticket_id',
            'lable' => 'Ticket Id',
            'name' => 'ticket_id'
        ]);

        $this->addColumn('title', [
            'render' => 'text',
            'filter' => 'text',
            'data_index' => 'title',
            'lable' => 'Title',
            'name' => 'title'
        ]);

        $this->addColumn('view', [
            'render' => 'link',
            'data_index' => 'ticket_id',
            'lable' => 'View',
            'action' => 'view',
            'param' => 'ticket_id',
            'class' => ['btn', 'view-btn'],
            'is_filter' => 0,
            'callback' => 'getViewUrl'
        ]);

        $ticket = Mage::getModel("ticket/ticket")
            ->getCollection();


        $this->setCollection($ticket);

        Parent::__construct();
    }

    public function getViewUrl($row)
    {
        return $this->getUrl('*/*/view') . '?ticket_id=' . $row->getTicketId();
    }
}


?>