/**
 * WEB4PRO - Creating profitable online stores
 *
 * @author    vyurchenko@corp.web4pro.com.ua
 * @category  WEB4PRO
 * @package   Web4pro_Stockstatus
 * @copyright Copyright (c) 2017 WEB4PRO (http://www.web4pro.net)
 * @license   http://www.web4pro.net/license.txt
 */
define(['jquery', 'jquery/ui'], function($){
    $.widget('web4pro.stockstatus', {

        /**
         *
         * @private
         */
        _create: function() {
            this._bindCore();
        },

        /**
         *
         * @private
         */
        _bindCore: function(){
            var widget = this;
            $(document).ready(function () {
                $("body").on("click", ".swatch-option", function () {
                    var dataOptionsId = [];
                    for (var index = 0; index < widget.options.productsOptions['attributes'].length; ++index) {
                        if ($("div.swatch-attribute." + widget.options.productsOptions['attributes'][index]).attr('option-selected')) {
                            var optionId = $("div.swatch-attribute." + widget.options.productsOptions['attributes'][index]).attr('option-selected');
                            if (optionId != null) {
                                dataOptionsId[index] = optionId;
                            }
                        }
                    }

                    dataOptionsId = widget.getOptionsArray(dataOptionsId);

                    if (dataOptionsId.length == widget.options.productsOptions['attributes'].length) {
                        widget.replaceStockStatus(dataOptionsId);
                    } else {
                        widget.replaceStockStatus();
                    }
                });
            });
        },

        /**
         *
         * @param dataOptionsId
         * @returns {*}
         */
        getOptionsArray: function(dataOptionsId){
            return dataOptionsId.filter(function(x) {
                return x !== undefined && x !== null;
            });
        },

        /**
         *
         * @param dataOptionsId
         * @returns {number}
         */
        compare: function(dataOptionsId){
            var widget = this;
            for ( var index = 0; index < widget.options.productsOptions['optionsProduct'].length; ++index ) {
                if(JSON.stringify(widget.options.productsOptions['optionsProduct'][index]['options']) == JSON.stringify(dataOptionsId))
                {
                    return index;
                }
            }
        },

        /**
         * @param dataOptionsId
         */
        replaceStockStatus: function(dataOptionsId) {
            var widget = this;
            $('div.stock.unavailable').remove();
            $('div.stock.available').remove();
            if (dataOptionsId) {
                var indexCompare = widget.compare(dataOptionsId);
                $('div.product-info-stock-sku').prepend(widget.options.productsOptions['optionsProduct'][indexCompare]['stockstatus']);
            } else {
                $('div.product-info-stock-sku').prepend(widget.options.productsOptions['optionsProduct'][0]);
            }
        },
    });

    return $.web4pro.stockstatus;
});