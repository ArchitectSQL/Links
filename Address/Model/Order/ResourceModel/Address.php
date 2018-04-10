<?php

namespace Web4pro\Address\Model\Order\ResourceModel;


class Address extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('web4pro_order_address', 'entity_id');
    }
}