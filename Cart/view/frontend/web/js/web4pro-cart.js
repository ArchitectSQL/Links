define([
    'jquery',
    'jquery/ui'
], function($) {
    "use strict";
    $.widget('web4pro.cart', {
        options: {
            triggerEvent: 'change',
            controller: 'http://developer.loc/web4pro_cart/query/custom',
            qty: '[data-role="cart-item-qty"]',
            itemId: '.action.action-edit'
        },

        _create: function() {
            this._bind();
        },

        _bind: function() {
            var self = this;
            self.element.on(self.options.triggerEvent, function() {
                self._ajaxSubmit();
            });
        },

        _ajaxSubmit: function() {
            jQuery(this.options.qty).on('change', function () {
                var that = this;
                var qty = $(this).val();
                var editAction = $(this).closest('tbody.cart.item').find('a.action-edit').attr('href');
                var arrayHerf = editAction.split('/');
                var blank = arrayHerf.pop();
                var idItem = arrayHerf.pop();
                console.log(qty);
                console.log(idItem);
                jQuery.ajax({
                    url: 'http://developer.loc/web4pro_cart/query/custom',
                    type: 'post',
                    dataType: 'json',
                    data: {qty: qty,idItem: idItem},
                    success: function(res) {
                        console.log('ajax success');
                        var price = JSON.stringify(res);
                        var totalPrice = $(that).closest('tbody.cart.item').find('.subtotal span.price');
                        totalPrice.text('$' + price);
                    }
                });
            });
        },

        _updateOrderHandler: function () {
            $(this).trigger('change');
        }
    });
    return $.web4pro.cart;
});