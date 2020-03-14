(function ($) {
    $('form[name="search"]').submit(function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        var results = $('#results');

        var updateResults = function(word, cls) {
            if(word) {
                $('#results .def, #results .classe').fadeIn();
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
        .done(function (data) {
            if(data) {
                updateResults(data.word, data.classe);
            } else {
                updateResults();
            }
        })
        .fail(function (data) {
            console.error(data);
        });
        // console.log(form.serialize());
        return false;
    });
    $('select').formSelect();    
})(jQuery);