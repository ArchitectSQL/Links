<?php

namespace Web4pro\Address\Model\Plugin;


class FormatterAddress
{
    public function beforeGetFormattedAddress($block,$address)
    {
        if($attributes = $address->getExtensionAttributes()){
            $address->setType($attributes->getType());
        }
        return array($address);
    }
}