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
            <label>年份</label>
            <div class="controls">
              <select class="form-control" data-rule-required="true" name="year">
                @foreach (range(date('Y'), 2000) as $year)
                  <option {{ $magazine->year == $year ? 'selected="selected"' : '' }}>{{ $year }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group">
            <label>期數</label>
            <small><span class="label label-success">可留空</span></small>
            <div class="controls">
              <input class="form-control" placeholder="請輸入期數" name="period" value="{{ $magazine->period }}" />
            </div>
          </div>
          <div class="form-group">
            <label>標題文字</label>
            <small><span class="label label-success">可留空</span></small>
            <div class="controls">
              <input class="form-control" placeholder="請輸入標題" name="title" value="{{ $magazine->title }}" />
            </div>
          </div>
          <div class="form-group">
            <label>附件檔案</label>
            <small><span class="label label-success">可留空</span></small>
            <div class="controls">
              <input title="選擇檔案" class="btn btn-default" type="file" name="attach" />
              <a href="{{ $magazine->attachUrl == '' ? '' : asset($magazine->attachUrl) }}" class="btn btn-link {{ $magazine->attachUrl == '' ? 'disabled' : '' }}">目前附件檔案</a>
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