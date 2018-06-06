<?php

namespace Web4pro\DontShowPrice\Observer\Product;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Customer\Model\Session as CustomerSession;

class HidePriceOnProduct implements ObserverInterface
{
    protected $customerSession;

    protected $scopeConfig;

    public function __construct(CustomerSession $customerSession,
                                \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig)
    {
        $this->customerSession = $customerSession;
        $this->scopeConfig = $scopeConfig;
    }

    public function execute(Observer $observer)
    {
        
        $isEnableDontShowPrice = $this->scopeConfig->getValue('catalog/available/hide_price',\Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        if (!$this->customerSession->isLoggedIn() && $isEnableDontShowPrice)
        {
            $product = $observer->getEvent()->getProduct();
            $product->setCanShowPrice(false);
        }
    }
}