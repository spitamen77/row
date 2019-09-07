/*!
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014
 * @package uni2-widgets
 * @subpackage uni2-widget-depdrop
 * @version 1.0.3
 *
 * Extensions to dependent dropdown for Uni:
 * - Initializes dependent dropdown for Select2 widget
 * 
 * For more JQuery plugins visit http://plugins.krajee.com
 * For more Uni related demos visit http://demos.krajee.com
 */
var initDepdropS2;
(function ($) {
    "use strict";
    initDepdropS2 = function (id, text) {
        var $s2 = $('#' + id), $s2cont = $('#select2-' + id + '-container'), ph = '...';
        $s2.on('depdrop.beforeChange', function () {
            $s2.find('option').attr('value', ph).html(text);
            $s2.val(ph);
            $s2.select2('val', ph);
            $s2cont.removeClass('kv-loading').addClass('kv-loading');
        }).on('depdrop.afterChange', function () {
            $s2.trigger('change');
            $s2cont.removeClass('kv-loading');
        });
    };
}(window.jQuery));