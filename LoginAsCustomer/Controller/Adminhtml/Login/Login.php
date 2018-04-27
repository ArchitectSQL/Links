<?php

namespace Web4pro\LoginAsCustomer\Controller\Adminhtml\Login;

/**
 * LoginAsCustomer login action
 */
class Login extends \Magento\Backend\App\Action
{
    /**
     * Login as customer action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $customerId = (int) $this->getRequest()->getParam('customer_id');

        $login = $this->_objectManager
            ->create('\Web4pro\LoginAsCustomer\Model\Login')
            ->setCustomerId($customerId);

        $login->deleteNotUsed();

        $customer = $login->getCustomer();

        if (!$customer->getId()) {
            $this->messageManager->addError(__('Customer with this ID are no longer exist.'));
            $this->_redirect('customer/index/index');
            return;
        }

        $user = $this->_objectManager->get('Magento\Backend\Model\Auth\Session')->getUser();
        // Здесь записываются данные в таблицу, тоесть логгирование , под кем зашел админ
        $login->generate($user->getId());
        // We're not using the $customer->getStoreId() method due to a bug where it returns the store for the customer's
        // website
        $customerStoreId = $customer->getData('store_id');

        $store = $this->_objectManager->get('Magento\Store\Model\StoreManagerInterface')
            ->getStore($customerStoreId);
        $url = $this->_objectManager->get('Magento\Framework\Url')
            ->setScope($store);

        $redirectUrl = $url->getUrl('loginascustomer/login/index', ['secret' => $login->getSecret(), '_nosid' => true]);

        $this->getResponse()->setRedirect($redirectUrl);
    }

    /**
     * Check is allowed access
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Web4pro_LoginAsCustomer::login_button');
    }
}
