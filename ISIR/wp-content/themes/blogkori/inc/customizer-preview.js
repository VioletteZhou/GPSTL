( function( $ ) {
    // Codes here.
    wp.customize('theme_accent_color', function(value) {
        value.bind(function(to) {
            $('#nav, .navbar-default').css({
                'background-color': to,
            });
            $('.sticky').css({
                'border-left-color': to
            });

        });
    });

    wp.customize('theme_link_color', function(value) {
        value.bind(function(to) {
            $('a, a:hover, a:visited, .post-title a:hover, #title, #title a').css({
                'color': to
            });

            $('.navbar-default .navbar-nav > .active > a, .navbar-default .navbar-nav > .active > a:hover, .navbar-default .navbar-nav>.open>a, .navbar-default .navbar-nav>.open>a:focus, .navbar-default, .navbar-nav>.open>a:hover, nav .menu-item a:hover').css({
                'background-color': to
            });
        });

    });
} )( jQuery );
