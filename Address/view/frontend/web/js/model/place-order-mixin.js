define([
    'jquery',
    'mage/utils/wrapper',
    'Magento_CheckoutAgreements/js/model/agreements-assigner',
    'Magento_Checkout/js/model/quote'
], function ($, wrapper, agreementsAssigner, quote) {
    'use strict';

    return function (placeOrderAction) {

        return wrapper.wrap(placeOrderAction, function (originalAction, paymentData, messageContainer) {
            agreementsAssigner(paymentData);
            return originalAction(paymentData, messageContainer);
        });
    };
});