["DOMContentLoaded", "DOMNodeInserted"].forEach(function(ev) {
  var exec_body_scripts = function (body) {
    var parser = new DOMParser();
    var body_el = parser.parseFromString(body, "text/html");
    var scripts = body_el.getElementsByTagName("script");

    for (i = 0; scripts[i]; i++) {
      var script = scripts[i].innerHTML;
      if (window.execScript){
        window.execScript(scripts);
      } else {
        var head = document.getElementsByTagName('head')[0];
        var scriptElement = document.createElement('script');
        scriptElement.setAttribute('type', 'text/javascript');
        scriptElement.innerText = script;
        head.appendChild(scriptElement);
        head.removeChild(scriptElement);
      }
    }
  }

  document.addEventListener(ev, function() {
    var src = document.getElementsByTagName('require');
    src = Array.prototype.slice.call(src);

    src.forEach(function(e) {
      var locked = e.getAttribute('locked');
      if (!locked) {
        e.setAttribute('locked', true);
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open('GET', e.getAttribute('src'), false);
        xmlhttp.send();
        e.outerHTML = xmlhttp.responseText;
        exec_body_scripts(xmlhttp.responseText);
      }
    });
  });
});
