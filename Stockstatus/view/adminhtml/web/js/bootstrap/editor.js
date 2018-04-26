/**
 * WEB4PRO - Creating profitable online stores
 *
 * @author    vyurchenko@corp.web4pro.com.ua
 * @category  WEB4PRO
 * @package   Web4pro_Stockstatus
 * @copyright Copyright (c) 2017 WEB4PRO (http://www.web4pro.net)
 * @license   http://www.web4pro.net/license.txt
 */
define(['jquery', 'mage/adminhtml/browser'], function ($) {
        $.widget('web4prostockstatus.browser', {
            openDialog:function(url){
                this.options = true;
                return MediabrowserUtility.openDialog(url,false,false,false, this.options);
            }
        });

        return $.web4prostockstatus.browser;
});