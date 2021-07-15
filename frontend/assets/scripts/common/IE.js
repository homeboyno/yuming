/**------------------------------------------
 *  兼容性
 ------------------------------------------*/
 $('[modernizr-svg="' + (!Modernizr.svg).toString() + '"]').hide();
 var ua = window.navigator.userAgent;
 var msie = ua.indexOf("MSIE");
 
 if (msie > 0 && msie <= 8) {
     $('.container:not(footer .container) > .col-md-2 > .sidebar').parent().css({"margin-left":"5%", "width": "11.67%", "float": "left"})
     $('.container:not(footer .container) > .col-md-10').css({"width": "83.33%", "float": "left"})
     $('.container:not(footer .container) > .col-md-9').css({"width": "75%", "float": "left"})
     $('footer, footer > .container, footer > .col-md-12').css({"width": "100%"})
     $('footer .container > .col-md-6').css({"width": "50%", "float": "left"})
     if(window.location.pathname == "/company/index") {
         $(".party-photo.col-sm-6").css({"width": "50%", "float": "left"})
     }
     if(window.location.pathname == "/news/index") {
         $(".news-list").css({"width": "100%", "float": "left"})
         $(".news-list .col-sm-4").css({"width": "33.33%", "float": "left"})
     }
 }
 
 if (!Modernizr.input.placeholder) {
     $('.input-group label').show();
 }