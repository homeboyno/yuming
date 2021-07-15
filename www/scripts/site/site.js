$(document).ready(function() {
    $('.center-container').each(function() {
        var t_height = 0;
        $(this).children().each(function() {
            t_height += $(this).height(); // + parseInt($(this).attr('margin-top')) + parseInt($(this).attr('margin-bottom'));
        });
        $(this).height(t_height);
    });

    $('#left_ushinef').bind('mouseenter', function() {
        if ($('html').hasClass('no-csstransitions')) { // add animation for IE8
            $('.left-overlay').animate({
                width: '200%'
            }, "normal", "linear");
            $('.right-overlay').animate({
                width: '0'
            }, "normal", "linear");
        } else {
            $('.left-overlay').addClass('left-active');
            $('.right-overlay').addClass('left-active');
        }
        $('.right-container').addClass('left-active');
        $('.Navbar').addClass('active');
        $('.Navbar button').addClass('btn-blue').removeClass('btn-white');
        $('.Navbar .menu').addClass('blue');
    });

    $('#left_ushinef').bind('mouseout', function() {
        if ($('html').hasClass('no-csstransitions')) { // add animation for IE8
            $('.left-overlay').animate({
                width: '100%'
            }, "normal", "linear");
            $('.right-overlay').animate({
                width: '100%'
            }, "normal", "linear");
        } else {
            $('.left-overlay').removeClass('left-active');
            $('.right-overlay').removeClass('left-active');
        }
        $('.right-container').removeClass('left-active');
        $('.Navbar').removeClass('active');
        $('.Navbar button').removeClass('btn-blue').addClass('btn-white');
        $('.Navbar .menu').removeClass('blue');
    });
    $('#left_ushinef').click(function() {
        if ($('html').hasClass('no-csstransitions')) { // add animation for IE8
            $('.left-overlay').animate({
                width: '100%'
            }, "normal", "linear");
            $('.right-overlay').animate({
                width: '100%'
            }, "normal", "linear");
        } else {
            $('.left-overlay').addClass('left-active');
            $('.right-overlay').addClass('left-active');
        }
        $('.right-container').addClass('left-active');
        $('.Navbar').addClass('active');
        $('.Navbar button').addClass('btn-blue').removeClass('btn-white');
        $('.Navbar .menu').addClass('blue');
        setTimeout(function() {
            window.location.pathname = '/site/about-ushinef';
        }, 600);
    });

    $('.hlTips').mouseenter(function() {
        $(this).find('.hlclose').show()
    })
    $('.hlTips').mouseleave(function() {
        $(this).find('.hlclose').hide()
    })
});
