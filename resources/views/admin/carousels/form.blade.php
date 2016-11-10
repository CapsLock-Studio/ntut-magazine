<form class="form validate-form" enctype="multipart/form-data" accept-charset="UTF-8" method="post" action="/admin/carousels{{ $carousel->id ? "/{$carousel->id}" : '' }}">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  @if ($carousel->id)
    <input type="hidden" name="_method" value="PUT">
  @endif
  <div class="box">
    <div class="box-body">
      <div class="row">
        <div class="col-sm-8 col-xs-12">
          <div class="image-preview-box">
            <img src="{{ $carousel->image->url('medium') }}" class="img-responsive" style="width:100%;" />
            <input title="選擇圖片" class="btn btn-default btn-block fit-placeholder-size" type="file" name="image" />
          </div>
        </div>
        <div class="col-sm-4 col-xs-12">
          <div class="form-group">
            <label>連結</label>
            <small style="margin-left:10px;">
              <span class="label label-success">可留空</span>
            </small>
            <div class="controls">
              <input class="form-control" data-rule-url="true" placeholder="http(s)://" name="url" value="{{ $carousel->url }}" />
            </div>
          </div>
          <div class="form-group">
            <label>標題文字</label>
            <small><span class="label label-success">可留空</span></small>
            <div class="controls">
              <input class="form-control" placeholder="請輸入敘述" name="title" value="{{ $carousel->title }}" />
            </div>
          </div>
          <div class="form-group">
            <label>副標題文字</label>
            <small><span class="label label-success">可留空</span></small>
            <div class="controls">
              <input class="form-control" placeholder="請輸入敘述" name="subtitle" value="{{ $carousel->subtitle }}" />
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="box-footer">
      <div class="col-sm-4 col-sm-offset-8 col-xs-12">
        <a href="/admin/carousels" class="btn btn-default">取消</a>
        <button type="submit" class="btn btn-info">儲存</button>
      </div>
    </div>
  </div>
</form>