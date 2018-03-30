define([
    'jquery',
    'jquery/ui',
    'Magento_Checkout/js/model/resource-url-manager',
    'mage/storage',
    'Magento_Checkout/js/model/quote'
], function($) {
    "use strict";
    $.widget('web4pro.cart', {
        options: {
            triggerEvent: 'change',
            controller: 'web4pro_cart/query/custom',
            qty: '[data-role="cart-item-qty"]',
            itemId: '.action.action-edit'
        },

        _create: function() {
            this._bind();
        },

        _bind: function() {
            var self = this;
                self._ajaxSubmit();

        },

        _ajaxSubmit: function() {
            jQuery(this.options.qty).on('change', function () {
                var that = this;
                var qty = $(this).val();
                var editAction = $(this).closest('tbody.cart.item').find('a.action-edit').attr('href');
                var arrayHerf = editAction.split('/');
                var blank = arrayHerf.pop();
                var idItem = arrayHerf.pop();
                var url = domine + 'web4pro_cart/query/custom';
                jQuery.ajax({
                    url: url,
                    type: 'post',
                    dataType: 'json',
                    data: {qty: qty,idItem: idItem},
                    success: function(res) {
                        console.log('ajax success');
                        var price = /*JSON.stringify(*/res/*)*/;
                        console.log(price);
                        var totalPrice = jQuery(that).closest('tbody.cart.item').find('.subtotal span.price');
                        var summaryTotalPrice = jQuery('.sub .amount span.price');
                        var summaryQtyProducts = jQuery('.qty .counter-number');
                        totalPrice.text('$' + price['data']['priceTotal']);
                        summaryTotalPrice.text('$' + price['data']['grandTotal']);
                        summaryQtyProducts.text(price['data']['summaryQtyProducts']);

                        $("input[data-cart-item=" + price['data']['itemIdMinicart'] + "]").val(qty);

                        
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