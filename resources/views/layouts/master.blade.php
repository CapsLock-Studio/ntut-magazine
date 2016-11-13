<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>NTUT 校訓管理系統</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="/plugins/datatables/dataTables.bootstrap.css">
  <link rel="stylesheet" href="/plugins/datepicker/datepicker3.css">
  <link rel="stylesheet" href="/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="/dist/css/skins/skin-blue.min.css">
  <link rel="stylesheet" href="/plugins/iCheck/all.css"></script>
  <link rel="stylesheet" href="/dist/css/app.css"></script>
  <script src="/plugins/jQuery/jquery-2.2.3.min.js"></script>
  <script src="/plugins/jQuery/jquery.md5.min.js"></script>
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  <header class="main-header">
    <a href="index2.html" class="logo">
      <span class="logo-mini">NTUT</b></span>
      <span class="logo-lg">NTUT</b></span>
    </a>
    <nav class="navbar navbar-static-top" role="navigation">
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown">
            <a href="/logout">
              <span class="hidden-xs">登出</span>
            </a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <aside class="main-sidebar">
    <section class="sidebar">
      <ul class="sidebar-menu">
        <li class="{{ @$controller_carousels }}">
          <a href="/admin/carousels">
            <i class="fa fa-exchange"></i>
            <span>輪播管理</span>
          </a>
        </li>
        <li class="{{ @$controller_news }}">
          <a href="/admin/news">
            <i class="fa fa-paper-plane-o"></i>
            <span>訊息發佈管理</span>
          </a>
        </li>
        <li class="{{ @$controller_magazines }}">
          <a href="/admin/magazines">
            <i class="fa fa-flag"></i>
            <span>校訊期刊管理</span>
          </a>
        </li>
        <li class="{{ @$controller_videos }}">
          <a href="/admin/videos">
            <i class="fa fa-video-camera"></i>
            <span>影片管理</span>
          </a>
        </li>
        <li class="{{ @$controller_users }}">
          <a href="/admin/users">
            <i class="fa fa-users"></i>
            <span>使用者管理</span>
          </a>
        </li>
        <li class="{{ @$controller_system }}">
          <a href="/admin/system">
            <i class="fa fa-power-off"></i>
            <span>系統管理</span>
          </a>
        </li>
      </ul>
    </section>
  </aside>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        {{ trans("function_module.$title") }}
      </h1>
      <ol class="breadcrumb">
        @yield('breadcrumb')
      </ol>
    </section>
    <section class="content">
      @yield('content')
    </section>
  </div>
  <footer class="main-footer">
    <strong>Copyright &copy; 2016 <a href="#">CapsLock Studio</a>.</strong> All rights reserved.
  </footer>
</div>
<div class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline"></button>
      </div>
    </div>
  </div>
</div>
<script src="/plugins/jQuery/jquery.validate.min.js"></script>
<script src="/plugins/jQueryUI/jquery-ui.min.js"></script>
<script src="/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="/plugins/iCheck/icheck.min.js"></script>
<script src="/plugins/fileinput/bootstrap-fileinput.js"></script>
<script src="/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="/plugins/input-mask/jquery.inputmask.js"></script>
<script src="/plugins/input-mask/jquery.inputmask.regex.extensions.js"></script>
<script src="/plugins/validate/jquery.validate.min.js"></script>
<script src="/plugins/validate/additional-methods.js"></script>
<script src="/bootstrap/js/bootstrap.min.js"></script>
<script src="/dist/js/components.min.js" type="text/javascript"></script>
<script src="/dist/js/app{{ App::environment('production') ? '.min' : '' }}.js"></script>
<script src="/dist/js/pages/{{ $controller }}{{ App::environment('production') ? '.min' : '' }}.js"></script>
</body>
</html>
