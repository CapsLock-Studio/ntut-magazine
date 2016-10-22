$(function() {
  'use strict';

  $(document).on('click', '.save', function() {
    var json = {};
    $('input, select').each(function(i, o) {
      json[$(o).attr('name')] = $(o).val();
    });

    $.ajax({
      method: 'POST',
      data: JSON.stringify(json),
      dialog: true
    });
  });

  $('input[name*=endpoint],input[name*=image_url]').inputmask('Regex', {regex: '^https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)$'});
}(jQuery));
