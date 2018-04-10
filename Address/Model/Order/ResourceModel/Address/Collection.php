<?php

namespace Web4pro\Address\Model\Order\ResourceModel\Address;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Web4pro\Address\Model\Order\Address', 'Web4pro\Address\Model\Order\ResourceModel\Address');
    }

}