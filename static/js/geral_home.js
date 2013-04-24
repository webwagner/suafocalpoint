$(document).ready(function(){

    $('.slideshow').tinycarousel();

    $("#login").validate();
    
    $(".login").focus(function(){
        $(this).addClass("login-b");
    });

    $(".senha").focus(function(){
        $(this).addClass("senha-b"); 
    });
    
    if (navigator.userAgent.indexOf('MSIE 7.0') > -1) 
        $("#ie7").show();
        
});
