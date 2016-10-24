@extends('layouts.master')
@section('content')
  <div class="row">
    <form action="/admin/carousels/order" method="POST">
      <input type="hidden" name="_method" value="PUT">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">

      <div class="col-sm-12">
        <div class="box bordered-box sea-blue-border" style="margin-bottom:0;">
          <div class="box-header">
            <div class="title">
              <label>輪播列表</label>
              <div class="pull-right btn-toolbar">
                <button class="btn btn-primary" type="submit">
                  儲存排序
                </button>
                <a class="btn btn-default" href="/admin/carousels/create">
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
                <table class="table" style="margin-bottom:0;">
                  <thead>
                  <tr>
                    <th>圖片</th>
                    <th>文字</th>
                    <th>連結</th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody id="sortable" data-sortable-axis="y" data-sortable-connect=".sortable">
                  @foreach ($carousels as $carousel)
                    <tr>
                      <input type="hidden" class="sort-item" name="carousels[{{ $carousel->id }}][order]" value="{{ $carousel->order }}" />
                      <input type="hidden" class="sort-item" name="carousels[{{ $carousel->id }}][id]" value="{{ $carousel->id }}" />
                      <td>
                        <div class="preview">
                          <img src="{{ $carousel->image->url('thumb') }}" />
                        </div>
                      </td>
                      <td>
                        {{ $carousel->title }}
                      </td>
                      <td>
                        <a class="btn btn-default" href="{{ $carousel->url }}" target="_blank">
                          <i class="fa fa-link"></i>
                        </a>
                      </td>
                      <td>
                        <div class='text-right'>
                          <a class="btn btn-default" href="/admin/carousels/{{ $carousel->id }}">
                            <i class='fa fa-pencil'></i>
                          </a>
                          <a href="/admin/carousels/{{ $carousel->id }}" class="btn btn-danger" method="DELETE" data-token="{{ csrf_token() }}" data-confirm="你確定要刪除嗎？提醒您，刪除後的資料無法回覆。">
                            <i class='fa fa-remove'></i>
                          </a>
                        </div>
                      </td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
  <div id="flash-message" data-status="{{ $flashStatus }}">{{ $flashMessage }}</div>
@endsection