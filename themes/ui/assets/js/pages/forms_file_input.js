$(function() {
    // dropify file input
    unibox_form_file_dropify.init();
});


unibox_form_file_dropify = {
    init: function() {

        $('.dropify').dropify();

        $('.dropify-fr').dropify({
            messages: {
                default: 'Glissez-déposez un fichier ici ou cliquez',
                replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                remove:  'Supprimer',
                error:   'Désolé, le fichier trop volumineux'
            }
        });

    }
};