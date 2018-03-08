(function($) {
    "use strict";

    var $navbar = $("#navbar-guest"),
        y_pos = $navbar.offset().top,
        height = $navbar.height();

    $(document).scroll(function() {
        var scrollTop = $(this).scrollTop();

        if (scrollTop > y_pos + height) {
            $navbar.addClass("sticky-navbar").animate({
                top: 0
            });
        } else if (scrollTop <= y_pos) {
            $navbar.removeClass("sticky-navbar").clearQueue().animate({
                top: "-48px"
            }, 0);
        }
    });

})(jQuery, undefined);