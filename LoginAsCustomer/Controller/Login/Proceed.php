<?php
namespace Web4pro\LoginAsCustomer\Controller\Login;

/**
 * LoginAsCustomer proceed action
 */
class Proceed extends \Magento\Framework\App\Action\Action
{
    /**
     * Login as customer action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $this->_view->loadLayout();
        $this->_view->renderLayout();
    }
}
