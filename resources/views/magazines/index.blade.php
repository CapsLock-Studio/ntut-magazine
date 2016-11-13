@extends('layouts.app')
@section('content')
<div class="cube-portfolio container margin-bottom-60">
  <!--=== Cube-Portfdlio ===-->
  <div class="content-xs">
    <div id="filters-container" class="cbp-l-filters-text content-xs">
      <div data-filter="*" class="{{ $queryYear ?: 'cbp-filter-item-active' }} {{ empty($queryYear) ?: 'cbp-redirect' }} cbp-filter-item"> 最新 </div> |
      @foreach ($years as $year)
        <div data-filter=".{{ $year }}" 
             class="cbp-filter-item {{ empty($queryYear) ?: 'cbp-redirect' }}">
            {{ $year }} 年份
        </div> |
      @endforeach
      <div style="display: inline-block; margin-left: 14px;">
        <select onchange="document.location.href=this.options[this.selectedIndex].getAttribute('href');" style="color: #000000;">
          <option href="#">更早以前</option>
          @foreach (range(end($years) - 1, $earlesitYear) as $year)
            <option {{ $queryYear == $year ? 'selected="selected"' : '' }} href="/magazines?year={{ $year }}">{{ $year }} 年份</option>
          @endforeach
        </select>
      </div>
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
</div>
<script>
$(document).ready(function() {
  $('.cbp-redirect').on('click', function(e) {
    e.preventDefault();

    document.location.href = '/magazines?filterYear=' + $(this).data('filter').replace(/\./g, '');
  });

  var selectedYear = {{ $filterYear ?: 'null' }};
  if (selectedYear) {
    setTimeout(function() {
      $('[data-filter=".' + selectedYear + '"]').trigger('click');
    }, 1000);
  }
});
</script>
@endsection