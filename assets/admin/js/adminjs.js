window.$ = window.jQuery;

function loader() {
    $('body').append('<div class="swps-loader"><img src="' + object_name.loader_gif + '" alt="loader"></div>');
}

function remove_loader() {
    $(document).find('.swps-loader').remove();
}