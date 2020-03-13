(function ($) {

    var $langForm = $('form#submit-lang-form');

    $langForm.submit(function (e) {
        handleLangSubmit(e);
    });

    $('button#submit-lang').click(function(e) {
        handleLangSubmit(e);
    })

    $('#addTranslateModal').on('show.bs.modal', event => {
        var button = $(event.relatedTarget);
        var modal = $('#addTranslateModal');
        var currentRequest = null;
        var successText = modal.find('.success.text-success');
        var errorText = modal.find('.danger.text-danger');
        var loading = modal.find('.info.text-info');

        loading.fadeIn();

        $.ajax({
            url: button.data('resolve-url')
        })
        .done(function(data) {
            modal.find('.modal-body').html(data);
            processTranslateCollection();

            modal.submit(function(e) {
                currentRequest = $.ajax({
                    url: button.data('resolve-url'),
                    method: 'POST',
                    data: modal.find('form').serialize(),

                    beforeSend: function() {
                        if(currentRequest) {
                            currentRequest.abort();
                        }
                        errorText.fadeOut(0);
                        successText.fadeOut(0);
                        loading.fadeIn();
                        modal.find('button').addClass('disabled cursor-progress');
                    },

                    success: function(res) {
                        modal.find('.modal-body form').fadeIn();
                        if(res === 'success') {
                            modal.find('.modal-body form p.alert').remove();
                            successText.fadeIn();
                        } else {
                            modal.find('.modal-body').html(res);
                        }
                        errorText.fadeOut(0);
                    },

                    error: function(res) {
                        errorText.fadeIn();
                        console.error(res);
                    },

                    complete: function(data) {
                        modal.find('button').removeClass('disabled cursor-progress');
                        loading.fadeOut(0);
                    }
                });

                e.preventDefault();
                return false;
            });
        })
        .fail(function(data) {
            console.error(data);
        })
        .always(function(){
            loading.fadeOut(0);
        });
    });

    $('.remove-button').click(function(e){
        var ele = $(this).parent().parent().parent();

        ele.hide('fast', function(){ ele.remove(); })
    });


    function processTranslateCollection() {
        $('.add-translation').click(function(e) {
            var list = $($(this).attr('data-list-selector'));
            var counter = list.data('widget-counter') || list.children().length;
            var newWidget = list.attr('data-prototype');
            newWidget = newWidget.replace(/__name__/g, counter);
            counter++;
            list.data('widget-counter', counter);
    
            var newElem = jQuery(list.attr('data-widget-tags')).html(newWidget);
            newElem.appendTo(list);
        });    
    }

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

                console.log(data);
                

                $('.langs .list-group').append(
                    `<a href="${data.url}" class="list-group-item list-group-item-action text-primary">${data.lang.name}<a>`
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