<?php

namespace Web4pro\Address\Model\Plugin\Checkout;

use Web4pro\Address\Model\Address\TypeFactory;
//use Magento\Checkout\Block\Checkout\LayoutProcessor;

class LayoutProcessor
{
    protected $type;

    public function __construct(
        TypeFactory $type
    ) {
        $this->type = $type;
    }

    public function afterProcess(
        \Magento\Checkout\Block\Checkout\LayoutProcessor $subject,
        array  $jsLayout
    ) {
        $select = [
            ['key' => 0,'value' => 'Please Select'],
            ['key' => 1,'value' => 'Residence'],
            ['key' => 2,'value' => 'Business']
        ];


        $options = $this->type->create();
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['type'] = [
            'component' => 'Magento_Ui/js/form/element/select',
            'config' => [
                'customScope' => 'shippingAddress.custom_attributes',
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/select',
                'options' => $options->getAllOptions(),
                'id' => 'type'
            ],
            'dataScope' => 'shippingAddress.custom_attributes.type',
            'label' => 'Address Type',
            'provider' => 'checkoutProvider',
            'visible' => true,
            'validation' => [],
            'sortOrder' => 250,
            'id' => 'type'
        ];
        /*$jsLayout['component']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['address-list']['children'][0] = [
            'config' => [

                'customSelect' => $select
            ]
        ];*/
        $configuration = $jsLayout['components']['checkout']['children']['steps']['children']
        ['billing-step']['children']['payment']['children']['payments-list']['children'];
        foreach ($configuration as $paymentGroup => $groupConfig) {
            if (isset($groupConfig['component']) AND $groupConfig['component'] === 'Magento_Checkout/js/view/billing-address') {

                $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']
                ['payment']['children']['payments-list']['children'][$paymentGroup]['children']['form-fields']['children']['company_tax_id'] = [
                    'component' => 'Magento_Ui/js/form/element/select',
                    'config' => [
                        'customScope' => 'billingAddress.custom_attributes',
                        'template' => 'ui/form/field',
                        'elementTmpl' => 'ui/form/element/select',
                        'options' => $options->getAllOptions(),
                        'id' => 'type'

                    ],
                    'dataScope' => 'billingAddress.custom_attributes.type',
                    'label' => 'Address Type',
                    'provider' => 'checkoutProvider',
                    'visible' => true,
                    'validation' => [],
                    'sortOrder' => 250,
                    'id' => 'type'
                ];
            }
        }

        return $jsLayout;
    }
}