(function($) {
    var sortable = $('#sortable');
    if (sortable.length > 0) {
        sortable.sortable({
            placeholder: 'ui-state-highlight'
        });

        sortable.on('sortupdate', function(event, ui){
            $('.sort-item').each(function(index){
                $(this).val(index);
            });
        });
    }
})(jQuery);