<?php

namespace Web4pro\Address\Observer;

class AddressCollectionLoad implements \Magento\Framework\Event\ObserverInterface
{
    protected $_joinProcessor;

    protected $_addressQuoteFactory;

    public function __construct(\Magento\Framework\Api\ExtensionAttribute\JoinProcessor $joinProcessor,
                                \Web4pro\Address\Model\Quote\AddressFactory $addressQuoteFactory )
    {
        $this->_joinProcessor = $joinProcessor;
        $this->_addressQuoteFactory = $addressQuoteFactory;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if($collection = $observer->getEvent()->getQuoteAddressCollection()){
            //$cpllectionFromFactory = $this->_addressQuoteFactory->create();
            //$proccessorInfo = $this->_joinProcessor->process($cpllectionFromFactory);
            //$data = $cpllectionFromFactory->getCollection();
            //$data->load();
            $this->_joinProcessor->process($collection);
        }
    }
}