<?php

namespace Web4pro\Address\Model\Quote;

class Address extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init('Web4pro\Address\Model\Quote\ResourceModel\Address');
    }
}