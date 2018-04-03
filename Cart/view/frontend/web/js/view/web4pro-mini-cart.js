define([
        'jquery'
    ],
    function($) {
        "use strict";

        $.widget('web4pro.minicart', {
            options: {
                triggerEvent: 'change',
                controller: 'checkout/query/custom',
                qty: '[data-role="cart-item-qty"]',
                itemId: '.action.action-edit'
            },

            _create: function() {
                this._bind();
            },
            _bind: function() {
                //debugger;
                var self = this;
                var param = $('#cart-item-30-qty');
                param.on('change',function() {
                    self._minicart();
                });


            },
            _minicart: function() {
                var self = this;
                console.log('lllllllll');

                console.log(param);
                alert('yeap');

            },



            _updateOrderHandler: function () {
                $(this).trigger('change');
            }
        });
        return $.web4pro.minicart;
    });