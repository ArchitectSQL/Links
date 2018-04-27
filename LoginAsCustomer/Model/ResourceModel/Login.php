<?php

namespace Web4pro\LoginAsCustomer\Model\ResourceModel;

/**
 * LoginAsCustomer resource model
 */
class Login extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     * Get tablename from config
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('web4pro_login_as_customer', 'login_id');
    }
}
