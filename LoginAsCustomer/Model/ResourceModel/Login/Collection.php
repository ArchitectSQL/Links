<?php

namespace Web4pro\LoginAsCustomer\Model\ResourceModel\Login;

/**
 * LoginAsCustomer collection
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Constructor
     * Configures collection
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init('Web4pro\LoginAsCustomer\Model\Login', 'Web4pro\LoginAsCustomer\Model\ResourceModel\Login');
    }
}
