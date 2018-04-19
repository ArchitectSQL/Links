var config = {
    config: {
        mixins: {
            'Magento_Checkout/js/action/set-billing-address': {
                'Web4pro_Address/js/action/set-billing-address-mixin': true
            },
            'Magento_Checkout/js/action/set-shipping-information': {
                'Web4pro_Address/js/action/set-shipping-information-mixin': true
            },
            'Magento_Checkout/js/action/create-shipping-address': {
                'Web4pro_Address/js/action/create-shipping-address-mixin': true
            },
            'Magento_Checkout/js/action/place-order': {
                'Web4pro_Address/js/action/set-billing-address-mixin': true
            },
            'Magento_Checkout/js/action/create-billing-address': {
                'Web4pro_Address/js/action/set-billing-address-mixin': true
            }
        }
    },
    map: {
        '*': {
            "Magento_Checkout/js/view/shipping-address/address-renderer/default":
                "Web4pro_Address/js/view/shipping-address/address-renderer/default-override",
            "Magento_Checkout/js/view/shipping-information/address-renderer/default":
                "Web4pro_Address/js/view/shipping-information/address-renderer/default",
            "Magento_Checkout/js/view/billing-address":
                "Web4pro_Address/js/view/billing-address"
            
        }
    }
};