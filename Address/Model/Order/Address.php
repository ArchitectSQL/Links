<?php

namespace Web4pro\Address\Model\Order;

class Address extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init('Web4pro\Address\Model\Order\ResourceModel\Address');
    }
}