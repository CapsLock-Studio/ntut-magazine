<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<head>
  <title>臺北科大校訊</title>

  <!-- Meta -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="Calvin Huang">

  <!-- Favicon -->
  <link rel="shortcut icon" href="/favicon.ico">

  <!-- Web Fonts -->
  <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600&amp;subset=cyrillic,latin">

  <!-- CSS Global Compulsory -->
  <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="/dist/css/unify/style.css">

  <!-- CSS Header and Footer -->
  <link rel="stylesheet" href="/dist/css/unify/headers/header-default.css">
  <link rel="stylesheet" href="/dist/css/unify/footers/footer-v1.css">

  <!-- CSS Implementing Plugins -->
  <link rel="stylesheet" href="/plugins/animate.css">
  <link rel="stylesheet" href="/plugins/line-icons/line-icons.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="/plugins/cube-portfolio/cubeportfolio/css/cubeportfolio.min.css">
  <link rel="stylesheet" href="/plugins/cube-portfolio/cubeportfolio/custom/custom-cubeportfolio.css">
  <link rel="stylesheet" href="/plugins/magnific-popup/magnific-popup.css">

  <!-- CSS Theme -->
  <link rel="stylesheet" href="/dist/css/unify/theme-colors/default.css" id="style_color">
  <link rel="stylesheet" href="/dist/css/unify/theme-skins/dark.css">

  <!-- CSS Customization -->
  <link rel="stylesheet" href="/dist/css/unify/custom.css">

  <!-- JS Global Compulsory -->
  <script type="text/javascript" src="/plugins/jQuery/jquery-2.2.3.min.js"></script>
  <script type="text/javascript" src="/plugins/jQuery/jquery-migrate.min.js"></script>
</head>

<body class="header-fixed">
  <div class="wrapper">
    <!--=== Header ===-->
    @include('layouts.header')
    <!--=== End Header ===-->

    @yield('content')

    <!--=== Footer Version 1 ===-->
    @include('layouts.footer')
    <!--=== End Footer Version 1 ===-->
  </div><!--/wrapper-->

  <!-- JS Global Compulsory -->
  <script type="text/javascript" src="/bootstrap/js/bootstrap.min.js"></script>
  <!-- JS Implementing Plugins -->
  <script type="text/javascript" src="/plugins/back-to-top.js"></script>
  <script type="text/javascript" src="/plugins/cube-portfolio/cubeportfolio/js/jquery.cubeportfolio.min.js"></script>
  <script type="text/javascript" src="/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>
  <!-- JS Customization -->
  <script type="text/javascript" src="/dist/js/custom.js"></script>
  <!-- JS Page Level -->
  <script type="text/javascript" src="/dist/js/app-unify.js"></script>
  <script type="text/javascript" src="/dist/js/plugins/cube-portfolio/cube-portfolio-2-ns.js"></script>
  <script type="text/javascript">
    jQuery(document).ready(function() {
      App.init();
    });
  </script>
  <!--[if lt IE 9]>
    <script src="/plugins/respond.js"></script>
    <script src="/plugins/html5shiv.js"></script>
    <script src="/plugins/placeholder-IE-fixes.js"></script>
    <![endif]-->
</body>
</html>
