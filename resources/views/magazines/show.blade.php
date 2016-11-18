@extends('layouts.app')
@section('content')
<div id="zoom-target-2" class="container content-md text-center">
  <div class="row">
    <div id="zoom-target-1" class="col-md-12 col-sm-12">
      <div class="row margin-bottom-20">
        <div class="col-sm-4 col-xs-12">
          <div class="btn-toolbar">
            <button class="btn btn-default" id="prev">上一頁</button>
            <button class="btn btn-default" id="next">下一頁</button>
            <a class="btn btn-default" href="{{ $magazine->attachUrl }}"><i class="fa fa-fw fa-cloud-download"></i>下載</a>
          </div>
        </div>
        <div class="col-xs-12 margin-bottom-10 visible-xs"></div>
        <div class="col-sm-4 col-xs-6">
          <button class="btn btn-default" id="zoom-in">
            <i class="fa fa-search-plus"></i>
          </button>
          <button class="btn btn-default" id="zoom-out">
            <i class="fa fa-search-minus"></i>
          </button>
        </div>
        <div class="col-sm-4 col-xs-6 text-right">
          <div style="padding-top: 6px;">
            <span>Page: <span id="page_num"></span> / <span id="page_count"></span></span>
          </div>
        </div>
      </div>
      <canvas id="the-canvas" style="border:1px solid rgba(0,0,0,.04)!important;box-shadow:0 1px 7px rgba(0,0,0,.05);width: 100%;height: 100%;"></canvas>
    </div>
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
      var viewport = page.getViewport(2);

      canvas.height = viewport.height;
      canvas.width = viewport.width;

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
<script>
  var zoomScale = 2;

  $('#zoom-in').on('click', function() {
    if (zoomScale > 2) {
      return;
    }

    $('#zoom-out').removeClass('disabled');

    if (zoomScale == 1) {
      $('#zoom-target-1').removeClass('col-md-10 col-md-offset-1').addClass('col-md-12');
    }

    if (zoomScale == 2) {
      $('#zoom-target-2').removeClass('container');
      $('#zoom-in').addClass('disabled');
    }

    zoomScale += 1;
  });

  $('#zoom-out').on('click', function() {
    if (zoomScale < 2) {
      return;
    }

    $('#zoom-in').removeClass('disabled');

    if (zoomScale == 2) {
      $('#zoom-target-1').addClass('col-md-10 col-md-offset-1').removeClass('col-md-12');
      $('#zoom-out').addClass('disabled');
    }

    if (zoomScale == 3) {
      $('#zoom-target-2').addClass('container');
    }

    zoomScale -= 1;
  });

</script>
@endsection