@extends('layouts.app')
@section('content')
<!--=== Breadcrumbs v3 ===-->
<div class="carousel carousel-fade slide" id="home-carousel">
  <ol class="carousel-indicators">
    @foreach ($carousels as $index => $carousel)
      <li data-target="#home-carousel" data-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"></li>
    @endforeach
  </ol>
  <div class="carousel-inner">
    @foreach ($carousels as $index => $carousel)
      <div class="item {{ $index == 0 ? 'active' : '' }}" style="background-image: url({{ $carousel->image->url('large') }});">
        <div class="carousel-caption">
          <h3>{{ $carousel->title }}</h3>
          <p>{{ $carousel->subtitle }}</p>
        </div>
        <a href="{{ $carousel->url }}">
        </a>
      </div>
    @endforeach
  </div>
  <div class="carousel-arrow">
    <a data-slide="prev" href="#home-carousel" class="left carousel-control">
      <span class="glyphicon glyphicon-chevron-left"></span>
    </a>
    <a data-slide="next" href="#home-carousel" class="right carousel-control">
      <span class="glyphicon glyphicon-chevron-right"></span>
    </a>
  </div>
</div>
<!--=== End Breadcrumbs v3 ===-->
<!--=== Cube-Portfdlio ===-->
<div class="cube-portfolio">
<div class="content-xs">
<div id="filters-container" class="cbp-l-filters-text content-xs">
  <div data-filter="*" class="cbp-filter-item-active cbp-filter-item"> 最新 </div> |
  @foreach ($years as $year)
    <div data-filter=".{{ $year }}" class="cbp-filter-item"> {{ $year }} 年份 </div> |
  @endforeach
  <div class="cbp-filter-item"> <a href="/">全部期刊</a> </div>
  </div><!--/end Filters Container-->
</div>
<div id="grid-container" class="cbp-l-grid-agency">
  @foreach ($magazines as $magazine)
    <div class="cbp-item {{ $magazine->year }}">
      <div class="cbp-caption" >
        <div class="cbp-caption-defaultWrap">
          <img src="{{ $magazine->image->url('medium') }}" alt="">
        </div>
        <div class="cbp-caption-activeWrap">
          <div class="cbp-l-caption-alignCenter">
            <div class="cbp-l-caption-body">
              <ul class="link-captions">
                @if ($magazine->attachUrl != '')
                  <li><a href="{{ $magazine->attachUrl }}"><i class="rounded-x fa fa-2x fa-cloud-download"></i></a></li>
                @endif
                <li><a href="{{ $magazine->image->url('original') }}" class="cbp-lightbox" data-title="{{ $magazine->title }}"><i class="rounded-x fa fa-2x fa-search"></i></a></li>
              </ul>
              <div class="cbp-l-grid-agency-title">{{ $magazine->title }}</div>
              <div class="cbp-l-grid-agency-desc">
                第 {{ $magazine->period }} 期

                @if (preg_match("/.pdf$/i", $magazine->attachUrl))
                  <br/><br/>
                  <a class="btn btn-default" href="/magazines/{{$magazine->id}}">線上觀看</a>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endforeach
  </div><!--/end Grid Container-->
</div>
<!--=== End Cube-Portfdlio ===-->
@endsection