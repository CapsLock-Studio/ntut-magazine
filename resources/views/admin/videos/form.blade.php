<form class="form validate-form" enctype="multipart/form-data" accept-charset="UTF-8" method="post" action="/admin/videos">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <div class="box">
    <div class="box-body">
      <div class="row">
        <div class="col-sm-4 col-xs-12">
          <div class="image-preview-box">
            <img src="{{ $video->thumbnailUrl ?: 'https://placeholdit.imgix.net/~text?txtsize=33&txt=Image&w=400&h=400' }}" class="img-responsive" style="width: 100%;" />
            <input title="選擇影片" class="btn btn-default btn-block" type="file" name="video" />
          </div>
        </div>
        <div class="col-sm-6 col-xs-12">
          <div class="form-group">
            <label>影片類別</label>
            <select class="form-control" name="categoryId">
              @foreach ($categories as $categorie)
                <option {{ $categorie['categoryId'] == $video->categoryId ? 'selected="selected"' : '' }} value="{{ $categorie['categoryId'] }}">{{ $categorie['categoryName'] }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label>影片標題</label>
            <small><span class="label label-success">可留空</span></small>
            <div class="controls">
              <input class="form-control" placeholder="請輸入標題" name="title" value="{{ $video->title }}" />
            </div>
          </div>
          <div class="form-group">
            <label>敘述文字</label>
            <small><span class="label label-success">可留空</span></small>
            <div class="controls">
              <textarea class="form-control" placeholder="請輸入敘述" name="description">{{ $video->description }}</textarea>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="box-footer">
      <div class="col-sm-8 col-sm-offset-4 col-xs-12">
        <a href="/admin/videos" class="btn btn-default">取消</a>
        <button type="submit" class="btn btn-info">儲存</button>
      </div>
    </div>
  </div>
</form>

@include('admin.videos.authRequestModal')