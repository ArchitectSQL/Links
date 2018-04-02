define([
        'jquery',
        'Magento_Checkout/js/model/quote',
        'Magento_Checkout/js/model/resource-url-manager',
        'mage/storage',
        'Magento_Checkout/js/model/full-screen-loader',
        'Magento_Checkout/js/action/set-shipping-information',
        'Magento_Checkout/js/action/get-totals',
        'jquery/ui','mage/cookies'
    ],
    function($, quote, resourceUrlManager, storage, fullScreenLoader, setShipping, getTotals) {
    "use strict";
    $.widget('web4pro.cart', {
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
                var idProduct = arrayHerf.pop();
                var product = arrayHerf.pop();
                var idItem = arrayHerf.pop();
                var url = domaine + 'checkout/query/custom';
                var idItemCart = {
                    'qty': {'qty': qty}
                };
                console.log(url);
                jQuery.ajax({
                    url: '/checkout/sidebar/updateItemQty',
                    type: 'post',
                    dataType: 'json',
                    data: {item_qty: qty,item_id: idItem,cart: idItemCart},
                    success: function(res) {
                        setShipping();
                        getTotals();
                        //console.log(getTotals());
                        var result = getTotals();

                        console.log(result);
                        /*jQuery.ajax({
                            url: url,
                            type: 'post',
                            dataType: 'json',
                            data: {item_qty: qty,item_id: idItem,cart: idItemCart},
                            success: function(res) {
                                

                        var price = JSON.stringify(res);
                        console.log(price);
                        var totalPrice = jQuery(that).closest('tbody.cart.item').find('.subtotal span.price');*/
                       // var summaryQtyProducts = jQuery('.qty .counter-number');

                        /*var summaryTotalPrice = jQuery('.cart-summary .sub .amount>.price');
                        var shippingPrice = jQuery('.cart-summary .shipping .amount>.price');
                        var orderTotal = jQuery('.cart-summary .grand .price');
                        var tax = jQuery('#co-shipping-method-form .item-options .price>.price');
                        summaryTotalPrice.text('$' + window.checkoutConfig.totalsData.subtotal);



                        totalPrice.text('$' + price['data']['priceTotal']);
                         summaryTotalPrice.text('$' + price['data']['grandTotal']);*/
                        // summaryQtyProducts.text(result.responseJSON.items_qty);
                         /*shippingPrice.text('$' + price['data']['shippingPrice']);
                         orderTotal.text('$' + price['data']['orderTotal']);
                         tax.text('$' + price['data']['shippingPrice']);
                         console.log(price['data']['shippingPrice']);
                         console.log(price['data']['orderTotal']);
                         console.log(shippingPrice);
                         console.log(orderTotal);
                         $("input[data-cart-item=" + price['data']['itemIdMinicart'] + "]").val(qty);

                            }
                        });*/
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