// Code to execute when page is loaded
$(document).ready(function() {
    // Get the button element
    const button = $('.showModal');

    // Get the modal element
    const modal = $('.modal');

    const modalBody = $('.modal_body');

    button.on('click', function() {
        // définir a display flex
        $('.'+ $(this).data('formName')).css('display', 'flex');
    });

    // Event listener for clicking outside the modal
    $(window).on('click', function(event) {
        if (!$(event.target).is(modalBody) && !$(event.target).is(button) && !$(event.target).closest(modalBody).length && modal.is(':visible')){
            modal.hide();
        }
    });
});
