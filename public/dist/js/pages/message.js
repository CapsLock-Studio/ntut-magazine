$(document).on('click', '.message-content', function() {
  var key = $(this).attr('data-key');
  var data = content[key];
  var brain = data.brain;
  $('.modal-body').load('/views/message.html', function() {
    if ($(brain).size()) {
      $(this).find('table').find('tbody').html('');
      var html = '';
      $(brain).each(function(i, v) {
        html += '<tr><td>' + v + '</td></tr>'
      });

      $(this).find('table').find('tbody').html(html);
    }

    $('.modal-title').text('對話內容');
    $('.modal').removeClassPrefix('modal-');
    $('.modal').addClass('modal-primary');
    $('.modal-footer > button').text('確定');
    $('.modal').modal('show');
    $('.modal-footer > button').off('click');
    $('.modal-footer > button').on('click', function() {
      $('.modal').modal('hide');
    });
  });
});
