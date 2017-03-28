$(document).ready(function() {
    $('#main-menu').metisMenu();
    
    $(window).bind("load resize", function () {
        if ($(this).width() < 768) {
            $('div.sidebar-collapse').addClass('collapse')
        } else {
            $('div.sidebar-collapse').removeClass('collapse')
        }
    });
});
$(document).ready(function () {
    $("#sideNav").click(function(){
        if($(this).hasClass('closed')){
            $('.navbar-side').animate({left: '0px'});
            $(this).removeClass('closed');
            $('#page-wrapper').animate({'margin-left' : '200px'});
            
        }
        else{
            $(this).addClass('closed');
            $('.navbar-side').animate({left: '-200px'});
            $('#page-wrapper').animate({'margin-left' : '0px'}); 
        }
    });
});  