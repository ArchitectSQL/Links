/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    'jquery',
    'uiComponent',
    'Magento_Customer/js/customer-data'
], function ($,Component, customerData) {
    'use strict';

    var countryData = customerData.get('directory-data');

    return Component.extend({
        defaults: {
            template: 'Web4pro_Address/shipping-information/address-renderer/default'
        },
        getType: function (id) {
         
            console.log(this.address().customAttributes);
            var valueType;
            $.each(window.checkoutConfig.foo, function(index,value) {
                if(id == index) {
                    valueType = value;
                }
            });
            return valueType;
        },
        /**
         * @param {*} countryId
         * @return {String}
         */
        getCountryName: function (countryId) {
            return countryData()[countryId] != undefined ? countryData()[countryId].name : ''; //eslint-disable-line
        }
    });
});
