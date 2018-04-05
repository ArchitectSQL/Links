<?php
namespace Web4pro\Address\Model\Customer\Attribute\Source;

class AddressField extends \Magento\Eav\Model\Entity\Attribute\Source\Table
{
    public function getAllOptions()
    {
        return [
            ['value' => '1', 'label' => __('Residence')],
            ['value' => '2', 'label' => __('Business')]
        ];
    }
}