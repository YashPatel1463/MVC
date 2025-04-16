<?php 

class Ticket_Model_Comment extends Core_Model_Abstract {
    public function init() {
        $this->_resourceClassName = "Ticket_Model_Resource_Comment";
        $this->_collectionClassName = "Ticket_Model_Resource_Comment_Collections";
    }

    
    protected function _afterSave() {
        $parent_id = $this->getParentId();
        $ticket_id = $this->getTicketId();

        $count = $this->getCollection()
            ->select(['total' => 'COUNT(*)'])
            ->addFieldToFilter('ticket_id', ['=' => $ticket_id])
            ->addFieldToFilter('parent_id', ['=' => $parent_id])
            ->addFieldToFilter('is_active', ['=' => '1'])
            ->getFirstItem()
            ->getTotal();

        if($count == 0) {
            $parent = $this->load($parent_id)
                ->setIsActive(0)
                ->save();
            Mage::log($parent);
        }
        // Mage::log($count);
    }
}

?>