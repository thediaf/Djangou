(function ($) {

    var $langForm = $('form#submit-lang-form');

    $langForm.submit(function (e) {
        handleLangSubmit(e);
    });

    $('button#submit-lang').click(function(e) {
        handleLangSubmit(e);
    })

    function handleLangSubmit(e) {
        e.preventDefault();
        var success = $langForm.find('.alert-success');
        var error = $langForm.find('.alert-danger');
        var loading = $langForm.find('.alert-info');

        loading.fadeIn();
        error.fadeOut(0);
        success.fadeOut(0);

        $.ajax({
            url: $langForm.attr('action'),
            type: $langForm.attr('method'),
            data: $langForm.serialize()
        })
        .done(function (data) {
            loading.fadeOut(0);
            if(data && data.type == 'success') {
                success.find('.text').text(data.message);
                success.fadeIn();

                $('.langs .list-group').append(
                    `<a href="${data.lang.id}" class="list-group-item list-group-item-action text-primary">${data.lang.name}<a>`
                );
            } else {
                error.find('.text').text(data.message);
                error.fadeIn();
            }
        })
        .fail(function (data) {
            console.error(data);
        });
    }
})(jQuery);