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
    $('.edit__options').hide();
    $(this).siblings('.edit__options').toggle();
  });
  // user clicks off, hides the options
  $(document).click( function(){
    $('.edit__options').hide();
  });
}
