<?php

class Admin_Block_Ticket_Index_View extends Core_Block_Template
{
    protected $_tree = null;
    protected $_comments = null;
    protected $_ticket = null;
    protected $_row = null;
    protected $_start = null;

    public function __construct()
    {
        $this->setTemplate('admin/ticket/index/view.phtml');
    }

    public function getId()
    {
        return $this->getRequest()->getQuery('ticket_id');
    }

    public function getTicket()
    {
        if ($this->_ticket == null) {
            $this->_ticket =  Mage::getModel('ticket/ticket')
                ->load($this->getRequest()->getQuery('ticket_id'));
        }
        return $this->_ticket;
    }

    public function getComments()
    {
        // if ($this->_comments == null) {
        $params = $this->getRequest()->getQuery();
        // Mage::log($params);

        if (isset($params['ticket_id'])) {
            // echo "12";
            $this->_comments =  Mage::getModel('ticket/comment')
                ->getCollection()
                ->addFieldToFilter('ticket_id', ['=' => $params['ticket_id']]);
            if (isset($params['comments']) && $params['comments'] === 'true') {
                $this->_comments->addFieldToFilter('is_active', ['=' => '1']);
            }
        }

        if (isset($params['last'])) {
            $this->_start =  Mage::getModel('ticket/comment')
                ->getCollection()
                ->select(['maxlevel' => 'MAX(level)-' . $params['last']])
                ->addFieldToFilter('ticket_id', ['=' => $this->getRequest()->getQuery('ticket_id')])
                // ->prepareQuery();
                // Mage::log($last5);
                // die;
                ->getFirstItem()
                ->getMaxlevel();
            $this->_comments->addFieldToFilter('level', ['>' => $this->_start]);
        } else {
            $this->_start = null;
        }

        // Mage::log($this->_comments);
        return $this->_comments->getData();
        // }
        // return $this->_comments;
    }
    
    public function getStartLevel() {
        // echo $this->_start;
        if($this->_start == null || $this->_start < 0) {
            return 0;
        } else {
            return $this->_start;
        }
    }


    public function buildCommentTree()
    {
        $lookup = [];

        foreach ($this->getComments() as $comment) {
            // Mage::log($comment->getData());
            $id = $comment->getCommentId();
            $lookup[$id] = $comment->getData();
            $lookup[$id]['count'] = 0;
            $lookup[$id]['children'] = [];
        }

        $tree = [];
        foreach ($lookup as $id => &$node) {
            $parentId = $node['parent_id'];
            if ($parentId == 0 || $parentId === null || $parentId == "") {
                $node['parent_id'] = 0;
                $tree[] = &$node;
            } else {
                if (isset($lookup[$parentId])) {
                    $lookup[$parentId]['children'][] = &$node;
                } else {
                    $tree[] = &$node;
                }
            }
        }

        $newTree[0] = $this->getTicket()->getData();
        $newTree[0]['comment'] = $newTree[0]['title'];
        $newTree[0]['comment_id'] = 0;
        $newTree[0]['parent_id'] = 0;
        $newTree[0]['level'] = 0;
        $newTree[0]['children'] = $tree;



        foreach ($newTree as &$node) {
            $this->assignCount($node);
        }

        return $newTree;
    }

    private function assignCount(&$node)
    {
        if (empty($node['children'])) {
            $node['count'] = 1;
            return 1;
        }

        $total = 0;
        foreach ($node['children'] as &$child) {
            $total += $this->assignCount($child);
        }

        $node['count'] = $total;
        return $total;
    }

    public function getTree()
    {
        if ($this->_tree == null) {
            $this->_tree = $this->buildCommentTree();
        }
        return $this->_tree;
    }

    public function maxDepth()
    {
        return max(array_column($this->getRow(), 'depth'));
    }

    public function makeRow()
    {
        return $this->dfs($this->getTree()[0], 0);
    }

    public function getRow()
    {
        if ($this->_row == null) {
            $this->_row = $this->makeRow();
        }
        return $this->_row;
    }

    public function dfs($child, $index, $depth = 1)
    {
        static $row = [];
        $rowstart = ($index >= 1) ? 1 : 0;
        $rowend = (count($child['children']) == 0) ? 1 : 0;
        $id = $child['comment_id'];
        $row[$id] = [
            'parent_id' => $child['parent_id'],
            'comment' => $child['comment'],
            'rowend' => $rowend,
            'rowstart' => $rowstart,
            'rowspan' => $child['count'],
            'depth' => $depth,
            'level' => $child['level'],
            'is_active' => $child['is_active']
        ];
        if (count($child['children']) > 0) {
            foreach ($child['children'] as $key => $_child) {
                $this->dfs($_child, $key, $depth + 1);
            }
        }

        return $row;
    }
}
