jQuery(document).ready(function($) {


  // Toggle nav
  $("#mobile-menu").on("click", function(){
    $(".menu-header").slideToggle();
    $(this).toggleClass("active");
  });

  // Same height formatting
  $('#blog p').matchHeight();


});
