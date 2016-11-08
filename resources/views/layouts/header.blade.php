<div class="header">
  <div class="container container-space">
    <!-- Logo -->
    <a class="logo" href="/">
      <span class="large">
        臺北國立科技大學校訊
      </span>
      <div class="sub">
        <span class="text-info">Taipei Tech Gazette</span>
      </div>
    </a>
    <!-- End Logo -->
    <!-- Topbar -->
    <div class="topbar">
      <ul class="loginbar pull-right">
        <li><a href="mailto:imhannah@ntut.edu.tw"><i class="fa fa-fw fa-envelope"></i> 聯絡我們</a></li>
      </ul>
    </div>
    <!-- End Topbar -->
    <!-- Toggle get grouped for better mobile display -->
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
      <span class="sr-only">Toggle navigation</span>
      <span class="fa fa-bars"></span>
    </button>
    <!-- End Toggle -->
  </div>
  <!--/end container-->
  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse mega-menu navbar-responsive-collapse">
    <div class="container">
      <ul class="nav navbar-nav">
        <li class="{{ @$controller_home }}">
          <a href="/">首頁</a>
        </li>
        <li class="{{ @$controller_news }}">
          <a href="/magazines">消息發佈</a>
        </li>
        <li class="{{ @$controller_magazines }}">
          <a href="/magazines">校訓期刊發佈</a>
        </li>
        <li class="{{ @$controller_videos }}">
          <a href="/videos">影片瀏覽</a>
        </li>
        <li class="{{ @$controller_ebook }}">
          <a href="/ebook">電子期刊</a>
        </li>
      </ul>
    </div>
    <!--/end container-->
  </div>
  <!--/navbar-collapse-->
</div>