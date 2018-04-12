define([
    'jquery',
    'mage/utils/wrapper',
    'Magento_Checkout/js/model/quote'
], function ($, wrapper, quote) {
    'use strict';
    
    return function (setShippingInformationAction) {
        return wrapper.wrap(setShippingInformationAction, function (originalAction) {
            var shippingAddress = quote.shippingAddress();
    
            if (shippingAddress['extensionAttributes'] === undefined) {
                shippingAddress['extensionAttributes'] = {};
            }

            var tp = shippingAddress.customAttributes['type'];
    
            if (typeof tp=='object'){
                tp = tp.value;
            }
            debugger;
            shippingAddress['extensionAttributes']['checkoutFields']['type'] = {'type':tp};
    
            return originalAction();
        });
    };
});
