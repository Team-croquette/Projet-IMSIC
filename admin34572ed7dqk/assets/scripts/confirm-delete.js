// Load confirm delete on click
$(document).ready(function() {

    $('.gestion__content .content li a').click(function(e) {
        if(confirm('Êtes-vous sûr de vouloir supprimer cet élément ?') == false) {
            e.preventDefault();
        }
    });
});
