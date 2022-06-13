// General Purpose functions

(function ($) {
    $.fn.extend({
        validate: function (options) {
            settings = $.extend({
                title: 'Required fields:',
            }, options);
            var isvalid = true;
            var errmsg = "";
            $('.required').each(function () {
                if ($(this).val() == '') {
                    isvalid = false;
                    // var msg = $(this).attr('id');
                    $(this).parent().children('.required_input').css('display', 'block');
                } else {
                    $(this).parent().children('.required_input').css('display', 'none');
                }
            });
            $('.email').each(function () {
                if ($(this).val() == '' && !$(this).hasClass('required')) return;
                if (!validateEmail($(this).val())) {
                    isvalid = false;
                    $(this).parent().children('.invalid_email').css('display', 'block');
                } else
                    $(this).parent().children('.invalid_email').css('display', 'none');
            });
            return isvalid;

            function validateEmail(email) {
                const re = /^([a-zA-Z0-9_\-?\.?]){3,}@([a-zA-Z]){3,}\.([a-zA-Z]){2,5}$/;
                if (re.test(email)) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    });
    $.fn.extend({
        resetError: function (options) {
            settings = $.extend({
                format: ''
            }, options);
            $('.required').each(function () {
                $(this).parent().children('.required_input').css('display', 'none');
            });
            $('.email').each(function () {
                $(this).parent().children('.invalid_email').css('display', 'none');
            });
        }
    });
})(jQuery);