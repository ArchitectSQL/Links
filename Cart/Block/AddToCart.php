<?php

namespace Web4pro\Cart\Block;

class AddToCart extends \Magento\Framework\View\Element\Template
{
    protected $_objectManager;
    public function __construct(\Magento\Framework\View\Element\Template\Context $context,
                                    \Magento\Framework\ObjectManagerInterface $objectManager)
    {
        parent::__construct($context);
        $this->_objectManager = $objectManager;
    }


    /**
     * @return mixed
     */
    public function getBaseUrlForAddToCart()
    {
        $storeManager = $this->_objectManager->get('\Magento\Store\Model\StoreManagerInterface');
        $domaine = $storeManager->getStore()->getBaseUrl();
        return $domaine;
    }

}