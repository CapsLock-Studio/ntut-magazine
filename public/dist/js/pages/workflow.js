$(function() {
  'use strict';

  var counter = {};
  var answer_type;
  var empty_field = function(field) {
    var flag = true;
    $.map(field, function(v) {
      flag = $(v).val() ? false: flag;
    });

    return flag;
  };

  var patternElements = function() {
    var word_pattern = $('*[name=word_pattern\\.value]');
    var word_regex = $('*[name=word_regex]');
    var request_parameter_from_regex = $('*[name^=request_parameter_from_regex\\.]');
    var word_full_match = $('*[name=word_full_match]');

    return {
      word_pattern: word_pattern,
      word_regex: word_regex,
      request_parameter_from_regex: request_parameter_from_regex,
      word_full_match: word_full_match
    };
  }

  var workflow = function(step) {
    var data = content[step] || {};
    var flow = data.flow || {};
    answer_type = data.type;
    if (!answer_type) {
      return false;
    }

    $('.modal-body').load('/views/' + answer_type + '.html', function() {
      $('.modal-title').text('');
      var body = $('.modal-body');
      for (var key in flow) {
        var c = flow[key];
        if ($.type(c) === 'object') {
          var i = 0;
          for (var ck in c) {
            var group = $('*[name=' + key + '\\.key]').eq(i).parents('.form-group');
            if ($(Object.keys(c)).size() - 1 > i) {
              group.find('.add-row').trigger('click');
            }
            group.find('*[name=' + key + '\\.key]').val(ck);
            group.find('*[name=' + key + '\\.value]').val(c[ck]);
            if ($.type(c[ck]) === 'object') {
              for (var ck_key in c[ck]) {
                group.find('*[name=' + key + '\\.value\\.' + ck_key + ']').val(c[ck][ck_key]);
              }
            }

            i ++;
          }
        } else if ($.type(c) === 'array') {
          var size = $(c).size();
          var tpye_for_element = '';
          $.each(c, function(i, v) {
            if ($.type(v) === 'object') {
              var type_for_object;
              if ($('*[name=' + key + '\\.value\\.type]').size()) {
                var group = $('*[name=' + key + '\\.value\\.type]').eq(i).parents('.form-group');
                group.find('*[name=' + key + '\\.value\\.type]').val(v.type);
                group.find('*[name=' + key + '\\.value\\.type]').val(v.type).trigger('change');
              } else {
                var group = $('*[name=' + key + '\\.value\\.title]').eq(i).parents('.form-group');
              }

              type_for_object = v.type;

              if ($(c).size() - 1 > i) {
                group.find('.add-row').trigger('click');
              }

              var custom = true;
              for (var kv in v) {
                (kv === 'payload') && v.payload.match(/^[0-9a-f]{32}$/) && (custom = false);
              }

              // 例外處理
              custom && type_for_object === 'postback' && group.find('*[name=' + key + '\\.value\\.type]').val(type_for_object + '_custom').trigger('change');
              for (var kv in v) {
                if (v[kv] && kv !== 'type') {
                  group.find('*[name=' + key + '\\.value\\.' + kv + ']').val(v[kv]);
                }
              }
            } else {
              var group = $('*[name=' + key + '\\.value]').eq(i).parents('.form-group');
              if ($(c).size() - 1 > i) {
                group.find('.add-row').trigger('click');
              }
              $('*[name=' + key + '\\.value]').eq(i).val(v);
            }
          });
        } else {
          var type_for_element = $('*[name=' + key + ']').attr('type');
          switch (type_for_element) {
            case 'checkbox':
              if (c == 1) {
                $('*[name=' + key + ']').parent('div[class^=icheckbox]').addClass('checked');
                $('*[name=' + key + ']').prop('checked', true);
              }
              break;
            default:
              $('*[name=' + key + ']').val(c);
              break;
          }
        }
      }
      $('.modal').removeClassPrefix('modal-');
      $('.modal').addClass('modal-info');
      $('.modal-footer button').text('儲存');
      $('.modal-footer button').off('click');
      $('.modal-footer button').on('click', function(e) {
        e.stopPropagation();
        e.preventDefault();
        e.stopImmediatePropagation();
        var form = $('.modal').find('form');
        var input = form.find('input, select, textarea');
        var names = [];
        $.each(input, function(i, v) {
          var element = $(v);
          var name = element.attr('name');
          if (name) {
            name = name.split('.');
            name = name[0];
            if (names.indexOf(name) === -1) {
              names.push(name);
            }
          }
        });

        var json = {};

        // 處理送到workflow的資料
        $.each(names, function(i, name) {
          var key = $('*[name=' + name + '\\.key]').filter(function () {
            return !!this.value;
          });
          var _value = $('*[name=' + name + '\\.value]').filter(function () {
            return !!this.value;
          });
          var value = $('*[name^=' + name + '\\.value\\.]').filter(function () {
            return !!this.value;
          });
          var target = $('*[name=' + name + ']').filter(function () {
            return !!this.value;
          });

          var archive = {};
          $.each(value, function(i, v) {
            var valueName = $(v).attr('name');
            valueName = valueName.replace(name + '.value.', '');
            archive[valueName] = archive[valueName] || [];
            archive[valueName].push($(v).val());
          });
          var final = [];
          $.each(archive, function(i, v) {
            $.each(v, function(_i, _v) {
              if (_v) {
                final[_i] = final[_i] || {};
                final[_i][i] = _v.replace('postback_custom', 'postback');
              }
            });
          });

          if (key.size()) {
            if (_value.size()) {
              $.each(key, function(i, v) {
                json[name] = json[name] || {};
                $(v).val() && (json[name][$(v).val()] = _value.eq(i).val());
              });
            } else if (value.size()) {
              $.each(key, function(i, v) {
                json[name] = json[name] || {};
                $(v).val() && (json[name][$(v).val()] = final[i]);
              });
            }
          } else if (value.size()) {
            json[name] = final;
          } else if (target.size()) {
            // 處理只有name
            if (target.size() > 1) {
              $.each(target, function(i, v) {
                json[name] = json[name] || [];

                $(v).val() && json[name].push($(v).val());
              });
            } else {
              if (target.attr('type') === 'checkbox') {
                if (target.parent().hasClass('checked')) {
                  json[name] = 1;
                }
              } else if (target.val()) {
                json[name] = target.val();
              }
            }
          } else if (_value.size()) {
            $.each(_value, function(i, v) {
              json[name] = json[name] || [];
              $(v).val() && json[name].push($(v).val());
            });
          }
        });

        // 特殊案例，quick replies可以多個可以一個
        if (json.request_endpoint) {
          if (Object.prototype.toString.call(json.response_payload_quick_replies_schema) === '[object Array]' && json.response_payload_quick_replies_schema.length === 1) {
            json.response_payload_quick_replies_schema = json.response_payload_quick_replies_schema[0];
          }
        }

        if (Object.prototype.toString.call(json.response_payload_elements_schema) === '[object Array]' && json.response_payload_elements_schema.length === 1) {
          json.response_payload_elements_schema = json.response_payload_elements_schema[0];
        }

        // remember your answer type here
        json.answer_type = answer_type;
        $.ajax({
          method: 'PUT',
          data: JSON.stringify({step: step, payload: json}),
          dialog: true
        }).done(function() {
          $.ajax({
            complete: function(e) {
              content = e.responseJSON;
              for (var step in content) {
                var tr = $('<tr>');
                var flow = content[step];
                tr.append('<td>')
                  .find('td')
                  .last()
                  .attr('class', 'step')
                  .text(step)
                  .parent()
                  .append('<td>')
                  .find('td')
                  .last()
                  .attr('class', 'type')
                  .text(flow.type)
                  .parent()
                  .append('<td>')
                  .find('td')
                  .last()
                  .attr('class', 'enter')
                  .text(flow.enter)
                  .parent()
                  .append('<td>')
                  .find('td')
                  .last()
                  .append('<a>')
                  .find('a')
                  .last()
                  .attr('href', '#')
                  .attr('data-step', step)
                  .addClass('btn')
                  .addClass('btn-primary')
                  .addClass('btn-sm')
                  .addClass('modify-target')
                  .text('編輯')
                  .parent()
                  .append('<a>')
                  .find('a')
                  .last()
                  .attr('href', '/workflow/' + flow.workflow)
                  .attr('data-step', step)
                  .addClass('btn')
                  .addClass('btn-danger')
                  .addClass('btn-sm')
                  .addClass('destroy-target')
                  .text('刪除');

                  if ($('*[data-step=' + step + ']').size()) {
                    $('*[data-step=' + step + ']').parents('tr').replaceWith(tr);
                  } else {
                    $('.add-chat').parents('tr').before(tr);
                  }
              }
            }
          });
        });
      });

      $('*[name=response_payload_buttons_schema\\.value\\.payload]').each(function(i, v) {
        var href = $(location).attr('href');
        var workflow = href.match(/\/(\d+\-.+)($|\?)/);
        workflow = workflow[1] || '';
        var priority = workflow.match(/(\d+)\-(.+)/);
        priority = (parseInt(priority[1], 10) || 0) + 1;
        var path = priority + '-' + $(v).val();
        $(v).prev('a').attr('href', '/workflow/' + path + '?pattern=' + $(v).val());
      });

      var pattern = $.param('pattern');
      var elements = patternElements();
      if (pattern && step == 1) {
        elements.word_pattern.attr('readonly', true);
        elements.word_pattern.val(pattern).parents('.form-group').find('.add-row').addClass('hide').parents('.form-group').find('.col-xs-8').addClass('col-xs-10').removeClass('col-xs-8');
        elements.word_regex.parents('.form-group').addClass('hide');
        elements.word_full_match.parents('.form-group').addClass('hide');
        elements.request_parameter_from_regex.parents('.form-group').addClass('hide');
      } else {
        for (var key in elements) {
          elements[key].trigger('blur');
        }
      }

      $('.modal').modal('show');
    });
  };

  $(document).on('blur', '*[name=word_pattern\\.value]', function() {
    var elements = patternElements();
    if (empty_field(elements.word_pattern)) {
      elements.word_pattern.parents('.form-group').removeClass('hide');
      elements.word_full_match.parents('.form-group').removeClass('hide');
      elements.word_regex.parents('.form-group').removeClass('hide');
      elements.request_parameter_from_regex.parents('.form-group').removeClass('hide');
    } else {
      elements.word_regex.val('').parents('.form-group').addClass('hide');
      elements.request_parameter_from_regex.val('').parents('.form-group').addClass('hide');
      elements.word_pattern.parents('.form-group').removeClass('hide');
      elements.word_full_match.parents('.form-group').removeClass('hide');
    }
  });

  $(document).on('blur', '*[name=word_regex]', function() {
    var elements = patternElements();
    if (empty_field(elements.word_regex)) {
      elements.word_pattern.parents('.form-group').removeClass('hide');
      elements.word_full_match.parents('.form-group').removeClass('hide');
      elements.word_regex.parents('.form-group').removeClass('hide');
      elements.request_parameter_from_regex.parents('.form-group').removeClass('hide');
    } else {
      elements.word_regex.parents('.form-group').removeClass('hide');
      elements.request_parameter_from_regex.parents('.form-group').removeClass('hide');
      elements.word_pattern.val('').parents('.form-group').addClass('hide');
      elements.word_full_match.val('').parents('.form-group').addClass('hide');
      elements.word_pattern.parents('.form-group').find('label').html('對應斷詞');
      $.each(elements.word_pattern, function(i, v) {
        if (i < $(elements.word_pattern).size() - 1) {
          $(v).remove();
        }
      });
    }
  });

  $(document).on('blur', '*[name^=request_parameter_from_regex\\.]', function() {
    var elements = patternElements();
    if (empty_field(elements.request_parameter_from_regex)) {
      elements.word_pattern.parents('.form-group').removeClass('hide');
      elements.word_full_match.parents('.form-group').removeClass('hide');
      elements.word_regex.parents('.form-group').removeClass('hide');
      elements.request_parameter_from_regex.parents('.form-group').removeClass('hide');
    } else {
      elements.word_regex.parents('.form-group').removeClass('hide');
      elements.request_parameter_from_regex.parents('.form-group').removeClass('hide');
      elements.word_pattern.val('').parents('.form-group').addClass('hide');
      elements.word_full_match.val('').parents('.form-group').addClass('hide');;
      elements.word_pattern.parents('.form-group').find('label').html('對應斷詞');
      $.each(elements.word_pattern, function(i, v) {
        if (i < $(elements.word_pattern).size() - 1) {
          $(v).remove();
        }
      });
    }
  });

  $(document).on('click', '.add-flow', function(e) {
    e.stopPropagation();
    e.preventDefault();
    e.stopImmediatePropagation();
    $('.modal-body').load('/views/workflow.html', function() {
      $('.modal-title').text('新增一個對話');
      $('.modal-footer > button').text('確定');
      $('.modal').removeClassPrefix('modal-');
      $('.modal').addClass('modal-primary');
      $('.modal').modal('show');
      $('.modal-footer > button').off('click');
      $('.modal-footer > button').on('click', function() {
        var validator = $('form').validate().form();
        if (validator) {
          var priority = $('.modal-body form input[name=priority]').val();
          var name = $('.modal-body form input[name=name]').val();
          $(location).attr('href', '/workflow/' + priority + '-' + name);
        }
      });
    });
  });

  $(document).on('click', '.add-chat', function(e) {
    e.stopPropagation();
    e.preventDefault();
    e.stopImmediatePropagation();
    $('.modal-body').load('/views/add_chat.html', function() {
      $('.modal-title').text('新增一個對話');
      $('.modal').removeClassPrefix('modal-');
      $('.modal').addClass('modal-primary');
      $('.modal-footer > button').text('確定');
      $('.modal').modal('show');
      $('.modal-footer > button').off('click');
      $('.modal-footer > button').on('click', function() {
        var type = $('.modal-body form select[name=flow-type]').val();
        if (type) {
          var last = $('.step').last().text();
          last = (parseInt(last, 10) || 0) + 1;
          content[last] = {};
          content[last].type = type;
          workflow(last);
        }
      });
    });
  });

  $(document).on('click', '.destroy-target', function(e) {
    e.stopPropagation();
    e.preventDefault();
    e.stopImmediatePropagation();
    var href = $(this).attr('href');
    var attributes = this.attributes;
    var json = {};
    var t = $(this).parents('tr');
    $.each(attributes, function(i, attr) {
      if (attr.name.match(/^data-/)) {
        json[attr.name.substr(5)] = attr.value;
      }
    })
    $('.modal-title').text('提示訊息');
    $('.modal').removeClassPrefix('modal-');
    $('.modal').addClass('modal-danger');
    $('.modal-body').text('請再按一次確定，按了之後才會刪除您的資料');
    $('.modal-footer > button').text('確定');
    $('.modal').modal('show');
    $('.modal-footer > button').off('click');
    $('.modal-footer > button').on('click', function() {
      $.ajax({
        method: 'DELETE',
        url: href,
        data: JSON.stringify(json),
        complete: function() {
          t.remove();
          $('.modal').modal('hide');
        }
      });
    });
  });

  $(document).on('click', '.add-row', function(e) {
    e.stopPropagation();
    e.preventDefault();
    e.stopImmediatePropagation();
    var parents = $(this).parents('.form-group');
    var input = parents.find('input, select');
    var name = input.attr('name');
    name = name.split('.');
    name = name[0];
    counter[name] = counter[name] || 0;
    counter[name] ++;
    switch (name) {
      case 'response_payload_buttons_schema':
        if (counter[name] >= 3) {
          return;
        }
        break;
      case 'response_payload_quick_replies_schema':
        if (counter[name] >= 10) {
          return;
        }
        break;
      case 'response_payload_elements_schema':
        if (counter[name] >= 10) {
          return;
        }
        break;
      default:
        break;
    }
    var clone = parents.clone();
    clone.find('label').text('');
    clone.find('input, select').val('').attr('readonly', false);
    clone.find('.is-hide').addClass('hide').removeClass('.is-hide');
    $(this).parents('.form-group').after(clone);
    $(this).parent().html('');
    $(clone).find('select, input').trigger('change');
  });

  $(document).on('change', '.quick-replies', function() {
    var select = $(this).val();
    $(this).parents('.form-group').find('.title').val('');
    switch (select) {
      case 'payload':
        var href = $(location).attr('href');
        var timestamp = new Date() / 1;
        var hash = $.md5(timestamp);
        var workflow = href.match(/\/(\d+\-.+)($|\?)/);
        workflow = workflow[1] || '';
        var priority = workflow.match(/(\d+)\-(.+)/);
        priority = (parseInt(priority[1], 10) || 0) + 1;
        var path = priority + '-' + hash;
        $(this).parents('.form-group').find('.payload').html('<a class="btn btn-danger btn-sm" target="_blank" href="/workflow/' + path + '?pattern=' + hash + '"><i class="fa fa-wrench"></i> 修改按鈕內容</a><input type="hidden" name="response_payload_quick_replies_schema.value.payload" value="' + hash + '">');
        break;
      default:
      case 'payload_custom':
        $(this).parents('.form-group').find('.payload').html('<input class="form-control" name="response_payload_quick_replies_schema.value.payload" placeholder="payload">');
        break;
    }
  });

  // button schema
  $(document).on('change', 'select[name=response_payload_buttons_schema\\.value\\.type]', function() {
    var val = $(this).val();
    var title = $(this).parents('.form-group').find('.title');
    var payload = $(this).parents('.form-group').find('.payload');
    var url = $(this).parents('.form-group').find('.url');
    var placeholder;
    title.addClass('is-hide').removeClass('hide');
    switch (val) {
      case 'web_url':
        payload.find('input').val('');
        title.find('input').val('');
        payload.addClass('hide').removeClass('is-hide');
        url.addClass('is-hide').removeClass('hide');
        break;
      case 'postback':
        var href = $(location).attr('href');
        var timestamp = new Date() / 1;
        var hash = $.md5(timestamp);
        var workflow = href.match(/\/(\d+\-.+)($|\?)/);
        workflow = workflow[1] || '';
        var priority = workflow.match(/(\d+)\-(.+)/);
        priority = (parseInt(priority[1], 10) || 0) + 1;
        var path = priority + '-' + hash;
        payload.html('<a class="btn btn-danger btn-sm" target="_blank" href="/workflow/' + path + '?pattern=' + hash + '"><i class="fa fa-wrench"></i> 修改按鈕內容</a><input type="hidden" name="response_payload_buttons_schema.value.payload" value="' + hash + '">');
        url.find('input').val('');
        title.find('input').val('');
        url.addClass('hide').removeClass('is-hide');
        payload.addClass('is-hide').removeClass('hide');
        break;
      case 'postback_custom':
        placeholder = placeholder || '請帶入自定義的payload';
      case 'phone_number':
        placeholder = placeholder || '電話以+886開頭';
        payload.html('<input class="form-control" name="response_payload_buttons_schema.value.payload" placeholder="' + placeholder + '">');
        url.find('input').val('');
        title.find('input').val('');
        url.addClass('hide').removeClass('is-hide');
        payload.addClass('is-hide').removeClass('hide');
        break;
      default:
        payload.find('input').val('');
        url.find('input').val('');
        title.find('input').val('');
        url.addClass('hide').removeClass('is-hide');
        title.addClass('hide').removeClass('is-hide');
        payload.addClass('hide').removeClass('is-hide');
        break;
    }
  });

  // load workflow content
  $(document).on('click', '.modify-target', function(e) {
    e.stopPropagation();
    e.preventDefault();
    e.stopImmediatePropagation();
    var step = $(this).attr('data-step');
    workflow(step);
  });

  $(document).on('blur', '*[name=request_endpoint]', function(e) {
    e.stopPropagation();
    e.preventDefault();
    e.stopImmediatePropagation();
    if ($(this).val()) {
      $('*[name^=response_payload_quick_replies_schema]').parents('.form-group').find('.add-row').addClass('hide').parents('.form-group').find('label').html('快速回答');
      $('*[name^=response_payload_quick_replies_schema]').parents('.form-group').find('label').html('快速回答');
      $('*[name^=response_payload_quick_replies_schema]').parents('.form-group').each(function(i, v) {
        if (i > 0) {
          $(v).remove();
        }
      });
    } else {
      $('*[name^=response_payload_quick_replies_schema]').last().parents('.form-group').find('label').html('快速回答').parents('.form-group').find('.add-row').removeClass('hide');
    }
  });
}(jQuery));
