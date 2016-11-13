<form class="form validate-form" enctype="multipart/form-data" accept-charset="UTF-8" method="post" action="/admin/users{{ $user->id ? "/{$user->id}" : '' }}">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  @if ($user->id)
    <input type="hidden" name="_method" value="PUT">
  @endif
  <div class="box">
    <div class="box-body">
      <div class="row">
        <div class="col-sm-6 col-xs-12">
          <div class="form-group">
            <label>用戶名稱</label>
            <div class="controls">
              <input class="form-control" placeholder="請輸入" name="name" value="{{ $user->name }}" data-required="true" {{ !$user->id ?: 'disabled="disabled"' }} />
            </div>
          </div>
          <div class="form-group">
            <label>用戶Email</label>
            <div class="controls">
              <input class="form-control" placeholder="請輸入 Email" name="email" value="{{ $user->email }}" data-rule-required="true" data-rule-email="true" {{ !$user->id ?: 'disabled="disabled"' }} />
            </div>
          </div>
          <div class="form-group">
            <label>預設密碼</label>
            <span class="label label-success">可留空，留空將會自動設定密碼</span>
            <div class="controls">
              <input class="form-control"  type="password" placeholder="請輸入密碼" name="defaultPassword" value="" />
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="box-footer">
      <div class="col-sm-8col-xs-12">
        <a href="/admin/users" class="btn btn-default">取消</a>
        @if ($user->id and !$user->active)
          <button type="submit" class="btn btn-info">重新生成預設密碼</button>
        @elseif (!$user->id)
          <button type="submit" class="btn btn-info">新建帳戶</button>
        @endif
      </div>
    </div>
  </div>
</form>