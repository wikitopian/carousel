jQuery( document ).ready(function( $ ) {

    $('#carousel img:gt(0)').hide();

    setInterval(
        function() {
            $('#carousel :first-child').fadeOut()
            .next('img').fadeIn()
            .end().appendTo('#carousel');
        },
        carousel.interval
    );

});
