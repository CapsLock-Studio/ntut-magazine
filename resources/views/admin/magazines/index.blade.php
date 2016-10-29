@extends('layouts.master')
@section('content')
  <div class="row">
    <div class="col-sm-12">
      <div class="box bordered-box sea-blue-border" style="margin-bottom:0;">
        <div class="box-header">
          <div class="title">
            <label>期刊列表</label>
            <div class="pull-right btn-toolbar">
              <a class="btn btn-default" href="/admin/magazines/create">
                新增輪播
              </a>
            </div>
          </div>
          <div class="actions">
            <a class="btn box-remove btn-xs btn-link" href="#"><i class="icon-remove"></i></a>
            <a class="btn box-collapse btn-xs btn-link" href="#"><i></i></a>
          </div>
        </div>
        <div class="box-content box-no-padding">
          <div class="responsive-table">
            <div class="scrollable-table sortable-container">
              @if ($magazines->count() > 0)
                <table class="table" style="margin-bottom:0;">
                  <thead>
                  <tr>
                    <th>圖片</th>
                    <th>文字</th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody id="sortable" data-sortable-axis="y" data-sortable-connect=".sortable">
                  @foreach ($magazines as $magazine)
                    <tr>
                      <td>
                        <div class="preview">
                          <img src="{{ $magazine->image->url('thumb') }}" style="width: 200px;" />
                        </div>
                      </td>
                      <td>
                        {{ $magazine->title }}
                      </td>
                      <td>
                        <div class='text-right'>
                          <a class="btn btn-default" href="/admin/magazines/{{ $magazine->id }}/edit">
                            <i class='fa fa-pencil'></i>
                          </a>
                          <a href="/admin/magazines/{{ $magazine->id }}" class="btn btn-danger" method="DELETE" data-token="{{ csrf_token() }}" data-confirm="你確定要刪除嗎？提醒您，刪除後的資料無法回覆。">
                            <i class='fa fa-remove'></i>
                          </a>
                        </div>
                      </td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>
              @else
                <div style="padding: 10px 20px; text-align: center;">
                  <div class="text-muted">目前沒有期刊，馬上去 <a href="/admin/magazines/create">新增</a></div>
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div id="flash-message" data-status="{{ $flashStatus }}">{{ $flashMessage }}</div>
@endsection