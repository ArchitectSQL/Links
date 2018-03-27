define([
    'jquery',
    'jquery/ui'
], function($) {
    "use strict";
    $.widget('web4pro.cart', {
        options: {
            triggerEvent: 'change',
            controller: 'http://developer.loc/web4pro_cart/query/custom'
        },

        _create: function() {
            console.log('3333');
            this._bind();
        },

        _bind: function() {
            var self = this;
            self.element.on(self.options.triggerEvent, function() {
                console.log('2222');
                self._ajaxSubmit();

            });

        },
        _ajaxSubmit: function() {
            console.log(jQuery('[data-role="cart-item-qty"]').val());
            console.log('1111');
            console.log(this.options.controller);
            jQuery.ajax({
                url: this.options.controller,
                type: 'post',
                dataType: 'json',
                data: 'qty='+jQuery('[data-role="cart-item-qty"]').val(),
                success: function(res) {
                    alert('ajax send');
                    console.log('ajax success');
                    console.log(JSON.stringify(res));
                }
            });
        }
    });
    return $.web4pro.cart;
});