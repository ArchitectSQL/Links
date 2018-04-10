<?php

namespace Web4pro\Address\Model\Plugin;

class General
{
    public function beforePopulateWithArray($helper,$dataObject, array $data, $interfaceName)
    {
        switch($interfaceName){
            case '\Magento\Sales\Api\Data\OrderAddressInterface':
                if($data['extension_attributes'] instanceof \Magento\Quote\Api\Data\AddressExtensionInterface){
                    $data['extension_attributes'] = $data['extension_attributes']->__toArray();
                }
                break;
            case '\Magento\Customer\Api\Data\AddressInterface':
                if($data['extension_attributes'] instanceof \Magento\Quote\Api\Data\AddressExtensionInterface){
                    $data['extension_attributes'] = $data['extension_attributes']->__toArray();
                    if(isset($data['extension_attributes']['type'])){
                        $data['type'] = $data['extension_attributes']['type'];
                    }
                }
                break;
            case '\Magento\Quote\Api\Data\TotalsInterface':
                unset($data['extension_attributes']);
                break;
        }

        return array($dataObject,$data,$interfaceName);
    }

    public function beforeGetFormattedAddress($block,$address)
    {
        if($attributes = $address->getExtensionAttributes()){
            $address->setType($attributes->getType());
        }

        return array($address);
    }
}