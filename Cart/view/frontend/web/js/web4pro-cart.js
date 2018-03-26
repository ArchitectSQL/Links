define([
    'jquery',
    'mage/translate',
    'jquery/ui',
    'mage/mage'
], function($) {
    "use strict";
    $.widget('web4pro.cart', {
        options: {
            addToCartFieldSelector: '[data-role="cart-item-qty"]',
            triggerEvent: 'change'
        },


        _create: function() {
            var self = this;
            if($('[data-role="cart-item-qty"]').change()){
                    self.ajaxSubmit($(this));
                }
        },


        ajaxSubmit: function(form) {
            console.log(form);
            $.ajax({
                url: form.attr('action'),
                data: this.options.addToCartFieldSelector.serialize(),
                type: 'post',
                dataType: 'json',
                beforeSend: function() {
                    console.log('ajax send');

                },
                success: function(res) {
                    console.log('ajax success');
                    console.log(res);
                }
            });
        }
    });
    return $.web4pro.cart;
});