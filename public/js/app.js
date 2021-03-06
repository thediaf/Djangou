(function($) {
    $('form[name="search"]').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        var results = $('#results');

        var updateResults = function(word, cls) {
            if (word) {
                $('#results .def, #results .classe').fadeIn().removeClass('bs-hide');
                $('#results .def .data').text(word);
                $('#results .classe .data').text(cls);
                results.find('.undefined').fadeOut(0);
            } else {
                $('#results .def, #results .classe').fadeOut(0);
                $('#results .def .data').text('');
                $('#results .classe .data').text('');
                results.find('.undefined').fadeOut(0).fadeIn();
            }
        };

        $.ajax({
                url: '/',
                type: 'POST',
                data: formData
            })
            .done(function(data) {
                if (data) {
                    updateResults(data.word, data.classe);
                } else {
                    updateResults();
                }
            })
            .fail(function(data) {
                console.error(data);
            });
        // console.log(form.serialize());
        return false;
    });

    $('.sidenav').sidenav();

    $('select').formSelect();

    if ($('form[name="suggestion"]').length > 0) {
        $('form[name="suggestion"] .select-wrapper').addClass('col s12 m3');
        processTranslateCollection();
    }

    (function ($) {
        var inputs = $('.histories input[type="checkbox"]');
        let currentRequest = null;
        
        inputs.each(function() {
            const input = $(this);
            const label = input.parent().find('span');

            input.change(function(){
                const isMemorized = input.is(':checked');
                
                currentRequest = $.ajax({
                    url: input.parent().parent().parent().data('status-update-url'),
                    method: "POST",
                    dataType: 'JSON',
                    data: {isMemorized},

                    beforeSend: function() {
                        if(currentRequest) {
                            currentRequest.abort();
                        }
                    }
                })
                .done(function(data) {
                    if(data.success === true) {
                        if(isMemorized) {
                            label.removeClass('black-text').addClass('green-text');
                        } else {
                            label.removeClass('green-text').addClass('black-text');
                        }
                        $('.progress .determinate').attr('style', `width: ${data.progression}%;`);
                    } else {
                        console.log(data);
                    }
                })
                .fail(function(data) {
                    console.log(data);
                });
            });
        });
    })(jQuery);

    function processTranslateCollection() {
        $('.add-translation').click(function(_) {
            var list = $($(this).attr('data-list-selector'));
            var counter = list.data('widget-counter') || list.children().length;
            var newWidget = list.attr('data-prototype');
            newWidget = newWidget.replace(/__name__/g, counter);
            counter++;
            list.data('widget-counter', counter);

            var newElem = jQuery(list.attr('data-widget-tags')).html(newWidget);
            newElem.appendTo(list);
            newElem.addClass('col s12');
            newElem.find('input').addClass('input-field col m2 offset-m1');
            newElem.find('select').addClass('input-field m3').removeClass('form-control');
            newElem.find('select').formSelect();
            newElem.find('.select-wrapper').addClass('col s12 m3');
        });
    }
})(jQuery);