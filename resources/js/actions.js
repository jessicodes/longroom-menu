// Global Actions

$( document ).ready(function() {

  // User clicks the edit icon
  init_show_edit_options();

});

/**
 * Initiates the click of the edit icon, to show the edit options.
 */
function init_show_edit_options() {
  $(document).on('click', '.js-show-edit-options', function(e) {
    e.stopPropagation();
    e.preventDefault();
    $('.edit__options').hide();
    $(this).siblings('.edit__options').toggle();
  });
  // user clicks off, hides the options
  $(document).click( function(){
    $('.edit__options').hide();
  });
}

/**
 * Callback on vue component to add sticky class on
 * draft menu if height is creator than the window height.
 */
function init_draft_list_sticky() {
  var menuHeight = $('.activeMenu-wrapper').height() + 50;
  // console.log(menuHeight);
  // console.log($(window).height());
  if (menuHeight > 50
    && menuHeight <= $(window).height() ) {
    $('.activeMenu').addClass('sticky');
  } else {
    $('.activeMenu').removeClass('sticky');
  }
}