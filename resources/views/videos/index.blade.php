@extends('layouts.app')
@section('content')
<div class="container content-md">
  <div class="row news-v1">
    @foreach ($videos as $index => $video)
      <a  href="https://www.youtube.com/watch?v={{ $video->youtubeId }}" class="popup-youtube col-md-4 md-margin-bottom-40">
        <div class="news-v1-in">
          <div class="mask">
            <i class="fa fa-youtube-play fa-5x"></i>
            <img class="img-responsive" src="{{ $video->thumbnailUrl }}" alt="">
          </div>
          <h3>{{ $video->title }}</h3>
          <p>{{ $video->description }}</p>
        </div>
      </a>
    @endforeach
  </div>
</div>
@endsection