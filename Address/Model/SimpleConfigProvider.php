<?php

namespace Web4pro\Address\Model;

use Magento\Checkout\Model\ConfigProviderInterface;

class SimpleConfigProvider implements ConfigProviderInterface
{
    public function getConfig()
    {
        return [
            'foo' => [
                    0 => 'Please Select',
                    1 => 'Residence',
                    2 => 'Business'
            ]
        ];
    }
}