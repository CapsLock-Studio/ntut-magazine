@extends('layouts.app')
@section('content')
<div class="breadcrumbs-v1 text-center" style="background-image: url({{ $news->cover->url('large') }});">
  <div class="container">
    <span>{{ $news->title }}</span>
  </div>
</div>

<div class="bg-color-light">
  <div class="container content-sm">
    <!-- News v3 -->
    <div class="news-v3 bg-color-white margin-bottom-30">
      <div class="news-v3-in">
        <ul class="list-inline posted-info">
          <li>發佈於&nbsp;&nbsp;{{ trans("months.{$news->publishedAt->format('F')}") }}&nbsp;{{ $news->publishedAt->format('d, Y') }}</li>
        </ul>
        <h2><a href="#">{{ $news->title }}</a></h2>
        {!! clean($news->content) !!}
      </div>
    </div>
    <!-- End News v3 -->

    <div class="row">
      <div class="col-xs-12 text-center">
        <a class="btn btn-link" href="/news">回消息發佈列表</a>
      </div>
    </div>
  </div><!--/end container-->
</div>
@endsection