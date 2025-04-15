<?php

class Ems_Block_User_Dashboard extends Core_Block_Template
{
    public function __construct()
    {
        $this->setTemplate('ems/user/dashboard.phtml');
    }

    public function getPastEvents()
    {
        $session = Mage::getModel('core/session');
        if ($session->get('customer_id')) {
            return Mage::getModel('ems/event')
                ->getCollection()
                ->leftJoin(["r" => "registrations"], "r.event_id = main_table.event_id", [])
                ->addFieldToFilter('date', ['<' => Date('Y-m-d')])
                ->addFieldToFilter('r.user_id', ['=' => $session->get('customer_id')])
                ->addFieldToFilter('r.status', ['IN' => ['approve', 'pending']])
                // ->prepareQuery();
                ->getData();
        } else {
            return [];
        }
    }

    public function getUpcomingEvents()
    {
        $sesion = Mage::getModel('core/session');
        $id = $sesion->get('customer_id');
        // var_dump($id);
        $data = Mage::getModel('ems/event')
            ->getCollection();
        if ($id != null) {
            $data->select(['*', 'total' => "COUNT(CASE WHEN r.status NOT IN ('reject') THEN 1 END)", 'status' => 'MAX(IF(r.user_id =' . $id . ', r.status, null))']);
        } else {
            $data->select(['*', 'total' => "COUNT(CASE WHEN r.status NOT IN ('reject') THEN 1 END)"]);
        }
        return $data->leftJoin(["r" => "registrations"], "r.event_id = main_table.event_id", [])
            ->addFieldToFilter('date', ['>=' => Date('Y-m-d')])
            ->groupBy('main_table.event_id')
            // ->prepareQuery();
            ->getData();
    }
}
