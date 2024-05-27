// Code to execute when page is loaded
$(document).ready(function() {
    // Get the button element
    const button = $('.showModal');

    // Get the modal element
    const modal = $('.modal');

    button.on('click', function() {
        modal.show();
    });

    // Event listener for clicking outside the modal
    $(window).on('click', function(event) {
        if (!$(event.target).is(modal) && !$(event.target).is(button) && !$(event.target).closest(modal).length && modal.is(':visible')){
            modal.hide();
        }
    });
});
