;
(function ($) {

    'use strict';

    $.DCCore = {

        init: function () {

            $(document).ready(function (e) {

                $('.tables_length select' ) .change(function (e) {
                    $.DCCore.setParameterAndRedirect('itemsPerPage' , $(this).find(":selected").val())
                });

                $('.tables_length select').select2({
                    minimumResultsForSearch: Infinity,
                    dropdownAutoWidth: true,
                    width: 'auto'
                });

            });

            $(window).on('load', function (e) {

            });
        },

        setParameterAndRedirect: function (paramName, paramValue)
        {
            var url = window.location.href;
            var hash = location.hash;
            url = url.replace(hash, '');
            if (url.indexOf(paramName + "=") >= 0)
            {
                var prefix = url.substring(0, url.indexOf(paramName));
                var suffix = url.substring(url.indexOf(paramName));
                suffix = suffix.substring(suffix.indexOf("=") + 1);
                suffix = (suffix.indexOf("&") >= 0) ? suffix.substring(suffix.indexOf("&")) : "";
                url = prefix + paramName + "=" + paramValue + suffix;
            }
            else
            {
                if (url.indexOf("?") < 0)
                    url += "?" + paramName + "=" + paramValue;
                else
                    url += "&" + paramName + "=" + paramValue;
            }
            window.location.href = url + hash;
        },

        /**
         *
         *
         * @var
         */
        components: {}

    };

    $.DCCore.init();

})(jQuery);