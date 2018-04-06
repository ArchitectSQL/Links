<?php

namespace Web4pro\Address\Plugin\Checkout;

class LayoutProcessor
{
    protected $typeCustomer;
    public function __construct(\Web4pro\Address\Model\Customer\Attribute\Source\AddressField $typeCustomer)
    {
        $this->typeCustomer = $typeCustomer;
    }

    /**
     * @param \Magento\Checkout\Block\Checkout\LayoutProcessor $subject
     * @param array $jsLayout
     * @return array
     */
    public function afterProcess(
        \Magento\Checkout\Block\Checkout\LayoutProcessor $subject,
        array  $jsLayout
    ) {

        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['custom_field'] = [
            'component' => 'Magento_Ui/js/form/element/select',
            'config' => [
                'customScope' => 'shippingAddress.custom_attributes',
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/select',
                'id' => 'custom-field'
            ],
            'dataScope' => 'shippingAddress.custom_attributes.custom_field',
            'label' => 'Address Custom Type',
            'provider' => 'checkoutProvider',
            'visible' => true,
            'validation' => [],
            'sortOrder' => 250,
            'id' => 'custom-field',
            'options' => $this->typeCustomer->getAllOptions()
        ];


        return $jsLayout;
    }
}