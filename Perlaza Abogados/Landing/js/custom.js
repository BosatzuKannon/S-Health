(function($){"use strict";$(document).ready(function(){jQuery('nav#main-menu').meanmenu();$(".all-attorneys").owlCarousel({autoPlay:false,slideSpeed:2000,pagination:false,navigation:true,items:3,navigationText:["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],itemsDesktop:[1199,3],itemsDesktopSmall:[980,2],itemsTablet:[768,2],itemsTablet:[767,1],itemsMobile:[479,1],});$(".all-patner").owlCarousel({autoPlay:true,slideSpeed:2000,pagination:false,navigation:false,items:6,navigationText:["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],itemsDesktop:[1199,6],itemsDesktopSmall:[980,5],itemsTablet:[768,5],itemsMobile:[479,3],});$.scrollUp({scrollText:'<i class="fa fa-angle-up"></i>',easingType:'linear',scrollSpeed:900,animation:'fade'});$('.counter').counterUp({delay:10,time:1000});$(".all-slide").owlCarousel({autoPlay:false,slideSpeed:1500,pagination:false,navigation:true,mouseDrag:false,items:1,navigationText:["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],itemsDesktop:[1199,1],itemsDesktopSmall:[980,1],itemsTablet:[768,1],itemsMobile:[479,1],});$(window).load(function(){$('#preloader').fadeOut();$('#preloader-status').delay(200).fadeOut('slow');$('body').delay(200).css({'overflow-x':'hidden'});});});})(jQuery);