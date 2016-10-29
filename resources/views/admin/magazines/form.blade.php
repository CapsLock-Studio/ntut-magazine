<form class="form validate-form" enctype="multipart/form-data" accept-charset="UTF-8" method="post" action="/admin/magazines{{ $magazine->id ? "/{$magazine->id}" : '' }}">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  @if ($magazine->id)
    <input type="hidden" name="_method" value="PUT">
  @endif
  <div class="box">
    <div class="box-body">
      <div class="row">
        <div class="col-sm-4 col-xs-12">
          <div class="image-preview-box">
            <img src="{{ $magazine->image->url('medium') }}" class="img-responsive" style="width: 100%;" />
            <input title="選擇圖片" class="btn btn-default btn-block" type="file" name="image" />
          </div>
        </div>
        <div class="col-sm-6 col-xs-12">
          <div class="form-group">
            <label>敘述文字</label>
            <small><span class="label label-success">可留空</span></small>
            <div class="controls">
              <input class="form-control" placeholder="請輸入敘述" name="title" value="{{ $magazine->title }}" />
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="box-footer">
      <div class="col-sm-8 col-sm-offset-4 col-xs-12">
        <a href="/admin/magazines" class="btn btn-default">取消</a>
        <button type="submit" class="btn btn-info">儲存</button>
      </div>
    </div>
  </div>
</form>