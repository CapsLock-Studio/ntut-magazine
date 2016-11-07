@extends('layouts.app')
@section('content')
  <!--=== Cube-Portfdlio ===-->
  <div class="cube-portfolio">
    <div class="content-xs">
      <div id="filters-container" class="cbp-l-filters-text content-xs">
        <div data-filter="*" class="cbp-filter-item-active cbp-filter-item"> All </div> |
        <div data-filter=".identity" class="cbp-filter-item"> Identity </div> |
        <div data-filter=".web-design" class="cbp-filter-item"> Web Design </div> |
        <div data-filter=".graphic" class="cbp-filter-item"> Graphic </div> |
        <div data-filter=".logos" class="cbp-filter-item"> Logo </div>
      </div><!--/end Filters Container-->
    </div>

    <div id="grid-container" class="cbp-l-grid-agency">
      <div class="cbp-item graphic">
        <div class="cbp-caption" >
          <div class="cbp-caption-defaultWrap">
            <img src="dist/img/main/img12.jpg" alt="">
          </div>
          <div class="cbp-caption-activeWrap">
            <div class="cbp-l-caption-alignCenter">
              <div class="cbp-l-caption-body">
                <ul class="link-captions">
                  <li><a href="portfolio_single_item.html"><i class="rounded-x fa fa-link"></i></a></li>
                  <li><a href="dist/img/main/img12.jpg" class="cbp-lightbox" data-title="Design Object"><i class="rounded-x fa fa-search"></i></a></li>
                </ul>
                <div class="cbp-l-grid-agency-title">Design Object 01</div>
                <div class="cbp-l-grid-agency-desc">Web Design</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="cbp-item web-design logos">
        <div class="cbp-caption">
          <div class="cbp-caption-defaultWrap">
            <img src="dist/img/main/img18.jpg" alt="">
          </div>
          <div class="cbp-caption-activeWrap">
            <div class="cbp-l-caption-alignCenter">
              <div class="cbp-l-caption-body">
                <ul class="link-captions">
                  <li><a href="portfolio_single_item.html"><i class="rounded-x fa fa-link"></i></a></li>
                  <li><a href="dist/img/main/img18.jpg" class="cbp-lightbox" data-title="Design Object"><i class="rounded-x fa fa-search"></i></a></li>
                </ul>
                <div class="cbp-l-grid-agency-title">Design Object 02</div>
                <div class="cbp-l-grid-agency-desc">Web Design</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="cbp-item graphic logos">
        <div class="cbp-caption">
          <div class="cbp-caption-defaultWrap">
            <img src="dist/img/main/img7.jpg" alt="">
          </div>
          <div class="cbp-caption-activeWrap">
            <div class="cbp-l-caption-alignCenter">
              <div class="cbp-l-caption-body">
                <ul class="link-captions">
                  <li><a href="portfolio_single_item.html"><i class="rounded-x fa fa-link"></i></a></li>
                  <li><a href="dist/img/main/img7.jpg" class="cbp-lightbox" data-title="Design Object"><i class="rounded-x fa fa-search"></i></a></li>
                </ul>
                <div class="cbp-l-grid-agency-title">Design Object 03</div>
                <div class="cbp-l-grid-agency-desc">Web Design</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="cbp-item web-design graphic">
        <div class="cbp-caption">
          <div class="cbp-caption-defaultWrap">
            <img src="dist/img/main/img4.jpg" alt="">
          </div>
          <div class="cbp-caption-activeWrap">
            <div class="cbp-l-caption-alignCenter">
              <div class="cbp-l-caption-body">
                <ul class="link-captions">
                  <li><a href="portfolio_single_item.html"><i class="rounded-x fa fa-link"></i></a></li>
                  <li><a href="dist/img/main/img4.jpg" class="cbp-lightbox" data-title="Design Object"><i class="rounded-x fa fa-search"></i></a></li>
                </ul>
                <div class="cbp-l-grid-agency-title">Design Object 04</div>
                <div class="cbp-l-grid-agency-desc">Web Design</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="cbp-item identity web-design">
        <div class="cbp-caption">
          <div class="cbp-caption-defaultWrap">
            <img src="dist/img/main/img3.jpg" alt="">
          </div>
          <div class="cbp-caption-activeWrap">
            <div class="cbp-l-caption-alignCenter">
              <div class="cbp-l-caption-body">
                <ul class="link-captions">
                  <li><a href="portfolio_single_item.html"><i class="rounded-x fa fa-link"></i></a></li>
                  <li><a href="dist/img/main/img3.jpg" class="cbp-lightbox" data-title="Design Object"><i class="rounded-x fa fa-search"></i></a></li>
                </ul>
                <div class="cbp-l-grid-agency-title">Design Object 05</div>
                <div class="cbp-l-grid-agency-desc">Web Design</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="cbp-item identity web-design">
        <div class="cbp-caption">
          <div class="cbp-caption-defaultWrap">
            <img src="dist/img/main/img6.jpg" alt="">
          </div>
          <div class="cbp-caption-activeWrap">
            <div class="cbp-l-caption-alignCenter">
              <div class="cbp-l-caption-body">
                <ul class="link-captions">
                  <li><a href="portfolio_single_item.html"><i class="rounded-x fa fa-link"></i></a></li>
                  <li><a href="dist/img/main/img6.jpg" class="cbp-lightbox" data-title="Design Object"><i class="rounded-x fa fa-search"></i></a></li>
                </ul>
                <div class="cbp-l-grid-agency-title">Design Object 06</div>
                <div class="cbp-l-grid-agency-desc">Web Design</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div><!--/end Grid Container-->
  </div>
  <!--=== End Cube-Portfdlio ===-->
@endsection