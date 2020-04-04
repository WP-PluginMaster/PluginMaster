
(function($) {

    let url = window.location.href;
    let currentURL = 'admin.php'+url.split('admin.php')[1] ;

    let currentNAV = $('ul#adminmenu li.toplevel_page_BotNinja a[href="' + currentURL + '"]');

    $(currentNAV).closest('li').addClass('current')
    $('ul#adminmenu li.toplevel_page_BotNinja li').click(function(){
        $("ul#adminmenu li.toplevel_page_BotNinja li").removeClass('current') ;
        $(this).addClass('current')
    })

})( jQuery );
