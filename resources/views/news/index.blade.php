@extends('layouts.app')
@section('content')
<div class="container content-md">
  @foreach ($news as $eachNews)
    <div class="row margin-bottom-20">
      <div class="col-sm-3 col-xs-12 sm-margin-bottom-20">
        <img class="img-responsive" src="{{ $eachNews->cover->url('medium') }}" alt="">
      </div>
      <div class="col-sm-9 col-xs-12 news-v3">
        <div class="news-v3-in-sm no-padding">
          <ul class="list-inline posted-info">
            <li>發佈於&nbsp;&nbsp;{{ trans("months.{$eachNews->publishedAt->format('F')}") }}&nbsp;{{ $eachNews->publishedAt->format('d, Y') }}</li>
          </ul>
          <h2><a href="/news/{{ $eachNews->id }}">{{ $eachNews->title }}</a></h2>
          <p>{{ mb_strimwidth(strip_tags($eachNews->content), 0, 200, "...") }}</p>
          <div><a href="/news/{{ $eachNews->id }}" class="btn btn-link">看詳細內容</a></div>
        </div>
      </div>
    </div>
  @endforeach
  <div class="row">
    <div class="col-xs-12 text-center">
      {{ $news->links() }}
    </div>
  </div>
</div>
@endsection