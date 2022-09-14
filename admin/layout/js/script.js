

$(function () {
  'use strict';
  // plus-minus-toggle icon in dashboard
  $('.plus-minus-toggle').click( function (){
    $(this).toggleClass('selected').parent('.card-header').next('.card-body').fadeToggle(100);
if ($(this).hasClass('selected')){
  $(this).html(' <i class="fa  fa-plus fa-pull-right fa-fw mt-1 "></i>');
}
else{
  $(this).html(' <i class="fa fa-minus fa-pull-right fa-fw mt-1 "></i>');
}

  });



// fire the select_box_it
  $("select").selectBoxIt();


  $('[placeholder]').focus(function () {
    $(this).attr('data-text', $(this).attr('placeholder'));
    $(this).attr('placeholder', '');

  }).blur(function () {
    $(this).attr('placeholder', $(this).attr('data-text'));

  });

  var passField = $('.password');
  $('.show_pass').hover(function () {

    passField.attr('type', 'text');
  }, function () {
    passField.attr('type', 'password');

  })


  $('input').each(function () {
    if ($(this).attr('required') == 'required') {
      $(this).after('<span class="astrisk">*</span>');
    }

  })
 
  $('.confirm').click( function ()  {
    return confirm("are you sure that you want to delete this member   ? ");
  })

$('.cat h5').click(function (){
    $(this).next('.full-view').fadeToggle(100);
})
  $('.card-header .view').click(function (){
    $(this).addClass('active').siblings('span').removeClass('active');
    if ($(this).data('view') === 'full' ){
      $('.full-view').fadeIn(100);
    }
    else {
      $('.full-view').fadeOut(100);
    }
  })




});
