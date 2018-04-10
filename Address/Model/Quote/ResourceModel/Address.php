<?php

namespace Web4pro\Address\Model\Quote\ResourceModel;

class Address extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('web4pro_quote_address', 'address_id');
    }
}