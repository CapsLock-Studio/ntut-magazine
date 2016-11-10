<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use App\Http\Requests;

use App\News;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        view()->share('flashMessage', $request->session()->get('flashMessage'));
        view()->share('flashStatus', $request->session()->get('flashStatus'));
    }

    public function create(Request $request)
    {
        view()->share('news', new News);
    }

    public function edit(Request $request, $id)
    {
        view()->share('news', News::find($id));
    }

    public function store(Request $request)
    {
        $news = new News($request->except('_token', 'content'));

        $news->content = clean($request->content);

        if ($news->save()) {
            $request->session()->flash('flashMessage', "編號 {$news->id} 新增成功。");
            $request->session()->flash('flashStatus', 'success');
        } else {
            $request->session()->flash('flashMessage', "新增失敗，請洽系統管理員協詢處理。");
            $request->session()->flash('flashStatus', 'warning');
        }

        return redirect()->action('Admin\NewsController@index');
    }

    public function update(Request $request, $id)
    {
        $news = News::find($id);

        if ($news->update($request->except('_token', 'content'))) {
            $news->content = clean($request->content);
            $news->save();

            $request->session()->flash('flashMessage', "編號 {$id} 修改成功。");
            $request->session()->flash('flashStatus', 'success');
        } else {
            $request->session()->flash('flashMessage', '修改失敗，請洽系統管理員協詢處理。');
            $request->session()->flash('flashStatus', 'warning');
        }

        return redirect()->action('Admin\NewsController@index');
    }

    public function destroy(Request $request, $id)
    {
        $news = News::find($id);

        Storage::delete($news->attach);

        if ($news->delete()) {
            $request->session()->flash('flashMessage', "編號 {$id} 刪除成功。");
            $request->session()->flash('flashStatus', 'success');
        } else {
            $request->session()->flash('flashMessage', '刪除失敗，請洽系統管理員協詢處理。');
            $request->session()->flash('flashStatus', 'warning');
        }

        return redirect()->action('Admin\NewsController@index');
    }
}
