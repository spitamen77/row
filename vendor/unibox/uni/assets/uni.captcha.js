/**
 * Uni Captcha widget.
 *
 * This is the JavaScript widget used by the uni\captcha\Captcha widget.
 *
 * @link http://www.efco.uz/unibox/
 * @copyright Copyright (c) 2017 EFFECT CONSULTING
 * @license http://efco.uz/unibox/license
 * @author Nuriddin Rashidov rnn0891@gmail.com
 * @since alfa version
 */
(function ($) {
    $.fn.uniCaptcha = function (method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Method ' + method + ' does not exist on jQuery.uniCaptcha');
            return false;
        }
    };

    var defaults = {
        refreshUrl: undefined,
        hashKey: undefined
    };

    var methods = {
        init: function (options) {
            return this.each(function () {
                var $e = $(this);
                var settings = $.extend({}, defaults, options || {});
                $e.data('uniCaptcha', {
                    settings: settings
                });

                $e.on('click.uniCaptcha', function () {
                    methods.refresh.apply($e);
                    return false;
                });

            });
        },

        refresh: function () {
            var $e = this,
                settings = this.data('uniCaptcha').settings;
            $.ajax({
                url: $e.data('uniCaptcha').settings.refreshUrl,
                dataType: 'json',
                cache: false,
                success: function (data) {
                    $e.attr('src', data.url);
                    $('body').data(settings.hashKey, [data.hash1, data.hash2]);
                }
            });
        },

        destroy: function () {
            return this.each(function () {
                $(window).unbind('.uniCaptcha');
                $(this).removeData('uniCaptcha');
            });
        },

        data: function () {
            return this.data('uniCaptcha');
        }
    };
})(window.jQuery);

