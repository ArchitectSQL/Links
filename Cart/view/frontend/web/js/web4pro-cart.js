define([
    'jquery',
    'Magento_Checkout/js/model/quote',
    'Magento_Checkout/js/model/shipping-service',
    'Magento_Checkout/js/model/shipping-rate-registry',
    'Magento_Checkout/js/model/shipping-rate-processor/customer-address',
    'Magento_Checkout/js/model/shipping-rate-processor/new-address',
    'Magento_Checkout/js/action/set-shipping-information',
    'Magento_Customer/js/customer-data',
    'Magento_Checkout/js/model/cart/totals-processor/default',
    'jquery/ui',
    'mage/cookies'
], function($, quote, shippingService, rateRegistry, customerAddressProcessor, newAddressProcessor, setShipping, customerData, totalsProcessor) {
    "use strict";
       
    $.widget('web4pro.cart', {
        options: {
            triggerEvent: 'change',
            controller: 'checkout/query/custom',
            qty: '[data-role="cart-item-qty"]',
            itemId: '.action.action-edit',
            minicart: '.update-cart-item'
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
                
                jQuery.ajax({
                    url: url,
                    type: 'post',
                    dataType: 'json',
                    data: {item_qty: qty,item_id: idProduct,cart: idItemCart},
                    success: function(res) {
                        setShipping();
                        var address = quote.shippingAddress();
                        rateRegistry.set(address.getCacheKey(), null);
                        var type = quote.shippingAddress().getType();
                        if (type == 'new-customer-address')
                        {
                            newAddressProcessor.getRates(address);
                        }
                        totalsProcessor.estimateTotals(customerData.get('checkout-data')());
                        //var price = JSON.stringify(res);
                        console.log(res);
                        var totalPrice = jQuery(that).closest('tbody.cart.item').find('.subtotal span.price');
                        var summaryQtyProducts = jQuery('.qty .counter-number');
                        
                        totalPrice.text('$' + res['data']['priceTotal']);
                        summaryQtyProducts.text(res['data']['summaryQtyProducts']);
                         $("input[data-cart-item=" + res['data']['itemIdMinicart'] + "]").val(qty);
                    }
                });
            });
            
            }
    });
    return $.web4pro.cart;
});