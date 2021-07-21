// Parallax header
var top_header = '';
$(document).ready(function(){
  top_header = $('#header');
});
$(window).scroll(function () {
  var st = $(window).scrollTop();
  top_header.css({'background-position':"center "+(st*.9)+"px"});
});

// Menu
$('.icon-menu').click(function() {
  
  $('.menu').animate({
     
    left: "0px"
   
  }, 700);

    
$('body').animate({
      
  left: "100%"
  
  }, 700);
 
});

$('.icon-close').click(function() {
   
  $('.menu').animate({
    
    left: "-100%"
   
  }, 700);

    
$('body').animate({
    
  left: "0px"
  
  }, 700);
  
});

$('h1').addClass('animated slideInDown');
$('b').addClass('animated slideInDown');
$('h3').addClass('animated slideInRight');
$('.icon-menu').addClass('animated slideInDown');