$( document ).ready(function() {
    console.log('static js');
});//end of $doc ready function

/*
// Smooth scrolling inside the page, id must start with 'page'
$('a[href^="#page"]').click(function(e){
  e.preventDefault();
  var target = $(this).attr('href');
  $('html, body').animate({scrollTop: $(target).offset().top-100}, 800, function(){    });
  return false;
});
*/
