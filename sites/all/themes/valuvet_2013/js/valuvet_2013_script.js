(function ($) {

    $(document).ready(function() {
        $("#edit-search-block-form--2").focus(function(){
            $(this).animate({width: '120'}, 500, function(){});
        }).blur(function(){
            $(this).animate({width: '80'}, 500, function(){});
        });
    
        
       
        $('.nav-collapse .dropdown-toggle').addClass( 'disabled' );
        
        // if (document.documentElement.clientWidth < 700) {
        //   $('.nav-collapse .dropdown-toggle').removeClass( 'disabled' );
        // }
        
        
       
    
        $(".toggle_content").hide();
        $(".toggle").toggle(function(){
            $(this).addClass("active");
        }, function () {
            $(this).removeClass("active");
        });
    
        $(".toggle").click(function(){
            $(this).next(".toggle_content").slideToggle(300);
        });
    });

})(jQuery);
