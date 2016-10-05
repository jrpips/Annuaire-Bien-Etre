$(function () {
    document.getElementsByTagName('body')[0].onscroll = headerColor;
    function headerColor() {
        console.log($(window).scrollTop());
        if ($(window).scrollTop() === 0) {
            $('header').attr('header-transparent');
            $('.header-wrapper').css('background-color', 'transparent');
        } else {
            $('header').removeAttr('header-transparent');
            $('.header-wrapper').css('background-color', 'rgba(0, 159, 139, 0.9)');
        }
    }
    setInterval(headerColor, 2000);
});


