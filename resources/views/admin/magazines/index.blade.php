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
                新增
              </a>
            </div>
          </div>
          <div class="actions">
            <a class="btn box-remove btn-xs btn-link" href="#"><i class="icon-remove"></i></a>
            <a class="btn box-collapse btn-xs btn-link" href="#"><i></i></a>
          </div>
        </div>
        <div class="box-body">
          <div class="responsive-table">
            <div class="scrollable-table sortable-container">
              <table class="table table-bordered table-striped data-table" style="margin-bottom:0;" 
                data-source="/api/magazines" data-trash="false" data-detail="false">
                <thead>
                <tr>
                  <th>編號</th>
                  <th class="no-sort">封面</th>
                  <th class="no-sort">標題文字</th>
                  <th class="no-sort">年份</th>
                  <th class="no-sort">期數</th>
                  <th class="no-sort">檔案</th>
                  <th class="no-sort"></th>
                </tr>
                </thead>
                <tbody id="sortable" data-sortable-axis="y" data-sortable-connect=".sortable">
                
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div id="flash-message" data-status="{{ $flashStatus }}">{{ $flashMessage }}</div>
@endsection