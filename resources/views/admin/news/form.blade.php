<form class="form validate-form" enctype="multipart/form-data" accept-charset="UTF-8" method="post" action="/admin/news{{ $news->id ? "/{$news->id}" : '' }}">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  @if ($news->id)
    <input type="hidden" name="_method" value="PUT">
  @endif
  <div class="box">
    <div class="box-body">
      <div class="row">
        <div class="col-xs-12">
          <div class="form-group">
            <label>發佈時間</label>
            <div class="input-group date">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" class="form-control pull-right" id="datepicker" name="publishedAt" value="{{ $news->publishedAt ?: date("Y-m-d") }}">
            </div>
            <!-- /.input group -->
          </div>
          <!-- /.form group -->
          <div class="form-group">
            <label>標題文字</label>
            <div class="controls">
              <input class="form-control" placeholder="請輸入標題" name="title" value="{{ $news->title }}" data-rule-required="true" />
            </div>
          </div>
          <div class="form-group">
            <label>訊息內容</label>
            <div class="controls">
              <textarea id="editor1" name="content">
                {!! clean($news->content) !!}
              </textarea>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="box-footer">
      <div class="col-sm-8 col-xs-12">
        <a href="/admin/newss" class="btn btn-default">取消</a>
        <button type="submit" class="btn btn-info">儲存</button>
      </div>
    </div>
  </div>
</form>
<script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>