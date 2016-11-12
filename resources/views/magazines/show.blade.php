@extends('layouts.app')
@section('content')
<div class="container content-md text-center">
  <div class="margin-bottom-20">
    <button class="btn btn-default" id="prev">Previous</button>
    <button class="btn btn-default" id="next">Next</button>
    &nbsp; &nbsp;
    <span>Page: <span id="page_num"></span> / <span id="page_count"></span></span>
  </div>

  <div class="row">
    <canvas id="the-canvas" class="col-md-8 col-md-offset-2 col-sm-12" style="border:1px solid rgba(0,0,0,.04)!important;box-shadow:0 1px 7px rgba(0,0,0,.05);"></canvas>
  </div>
</div>
<script type="text/javascript" src="/plugins/mozilla/pdf.js"></script>
<script id="script">
  function getUrlParameter(name) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    var results = regex.exec(location.search);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
  };

  //
  // If absolute URL from the remote server is provided, configure the CORS
  // header on that server.
  //
  var url = '{{ $magazine->attachUrl }}';


  //
  // Disable workers to avoid yet another cross-origin issue (workers need
  // the URL of the script to be loaded, and dynamically loading a cross-origin
  // script does not work).
  //
  // PDFJS.disableWorker = true;

  //
  // In cases when the pdf.worker.js is located at the different folder than the
  // pdf.js's one, or the pdf.js is executed via eval(), the workerSrc property
  // shall be specified.
  //
  // PDFJS.workerSrc = '../../build/pdf.worker.js';

  var pdfDoc = null,
      pageNum = getUrlParameter('page') == '' ? 1 : parseInt(getUrlParameter('page'), 10),
      pageRendering = false,
      pageNumPending = null,
      canvas = document.getElementById('the-canvas'),
      ctx = canvas.getContext('2d');

  /**
   * Get page info from document, resize canvas accordingly, and render page.
   * @param num Page number.
   */
  function renderPage(num) {
    pageRendering = true;
    // Using promise to fetch the page
    pdfDoc.getPage(num).then(function(page) {
      var viewport = page.getViewport(canvas.width / page.getViewport(1.0).width);

      canvas.height = viewport.height;

      // Render PDF page into canvas context
      var renderContext = {
        canvasContext: ctx,
        viewport: viewport
      };
      var renderTask = page.render(renderContext);

      // Wait for rendering to finish
      renderTask.promise.then(function () {
        pageRendering = false;
        if (pageNumPending !== null) {
          // New page rendering is pending
          renderPage(pageNumPending);
          pageNumPending = null;
        }
      });
    });

    // Update page counters
    document.getElementById('page_num').textContent = pageNum;
  }

  /**
   * If another page rendering in progress, waits until the rendering is
   * finised. Otherwise, executes rendering immediately.
   */
  function queueRenderPage(num) {
    if (pageRendering) {
      pageNumPending = num;
    } else {
      renderPage(num);
    }
  }

  /**
   * Displays previous page.
   */
  function onPrevPage() {
    if (pageNum <= 1) {
      return;
    }
    pageNum--;
    queueRenderPage(pageNum);
  }
  document.getElementById('prev').addEventListener('click', onPrevPage);

  /**
   * Displays next page.
   */
  function onNextPage() {
    if (pageNum >= pdfDoc.numPages) {
      return;
    }
    pageNum++;
    queueRenderPage(pageNum);
  }
  document.getElementById('next').addEventListener('click', onNextPage);

  /**
   * Asynchronously downloads PDF.
   */
  PDFJS.getDocument(url).then(function (pdfDoc_) {
    pdfDoc = pdfDoc_;
    document.getElementById('page_count').textContent = pdfDoc.numPages;

    // Initial/first page rendering
    renderPage(pageNum);
  });
</script>
@endsection