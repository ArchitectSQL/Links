<?php

namespace Web4pro\Address\Model\Quote\ResourceModel;

class Address extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('mgcustom_quote_address', 'address_id');
        $this->_isPkAutoIncrement=false;
    }
}