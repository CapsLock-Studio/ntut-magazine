@extends('layouts.master')
@section('content')

<form class="form validate-form" enctype="multipart/form-data" accept-charset="UTF-8" method="post" action="/admin/users/update-setting">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <input type="hidden" name="_method" value="PUT">
  <div class="box">
    <div class="box-body">
      <div class="row">
        <div class="col-sm-6 col-xs-12">
          <div class="form-group">
            <label>舊密碼</label>
            <div class="controls">
              <input class="form-control" type="password" placeholder="請輸入" data-rule-required="true" name="oldPassword" />
            </div>
          </div>
          <div class="form-group">
            <label>新密碼</label>
            <div class="controls">
              <input class="form-control" type="password" placeholder="請輸入" data-rule-required="true" name="newPassword" />
            </div>
          </div>
          <div class="form-group">
            <label>密碼確認</label>
            <div class="controls">
              <input class="form-control" type="password" placeholder="請輸入" data-rule-required="true" name="confirmPassword" />
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="box-footer">
      <div class="col-sm-8col-xs-12">
        <a href="/admin/users" class="btn btn-default">取消</a>
        <button type="submit" class="btn btn-info">更新密碼</button>
      </div>
    </div>
  </div>
</form>

<div id="flash-message" data-status="{{ $flashStatus }}">{{ $flashMessage }}</div>
@endsection