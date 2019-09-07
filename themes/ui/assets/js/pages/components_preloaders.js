$(function() {
    // show preloader
    $('#show_preloader_regular').click(function() {
        unibox_helpers.content_preloader_show('regular');
        setTimeout(function() {
            unibox_helpers.content_preloader_hide();
        },3000)
    });
    $('#show_preloader_md').click(function() {
        unibox_helpers.content_preloader_show('md');
        setTimeout(function() {
            unibox_helpers.content_preloader_hide();
        },3000)
    });
    $('#show_preloader_custom').click(function() {
        unibox_helpers.content_preloader_show('md','danger','#preloader_dynamic',64,64);
        setTimeout(function() {
            unibox_helpers.content_preloader_hide();
        },3000)
    })
});