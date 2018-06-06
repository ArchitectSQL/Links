<?php 

namespace Web4pro\PaymentCustom\Observer;

use Magento\Framework\Event\Observer as EventObserver;

class Bonus implements \Magento\Framework\Event\ObserverInterface
{
    protected $_customerRepoInterface;
    
    public function __construct(
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepoInterface
    )
    {
        $this->_customerRepoInterface = $customerRepoInterface;
    }
    
    public function execute(EventObserver $observer)
    {   
        $customerId = $observer->getData('customer')->getId();
        $customerModel = $this->_customerRepoInterface->getById($customerId);
        //defult value

        $customerModel->setCustomAttribute('bonuses',100);
        $this->_customerRepoInterface->save($customerModel);
        
    }
}