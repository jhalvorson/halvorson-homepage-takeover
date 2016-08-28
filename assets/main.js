(function($) {
    $(window).load(function(){
        $('.takeover-modal').modal({
            fadeDuration: 100
        });
    });

    // $(document).ready(function() {
    //     if (Cookies.get('modal_shown') == null) {
    //         Cookies.set('modal_shown', 'yes', { expires: 3, path: '/' });
    //         setTimeout(function(){
    //             $(".takeover-modal").modal({
    //                 fadeDuration: 100
    //             });
    //         }, 3000);
    //     }
    // });
})( jQuery );