<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Magazine;

class MagazinesController extends Controller
{
    public function index(Request $request)
    {
        view()->share('flashMessage', $request->session()->get('flashMessage'));
        view()->share('flashStatus', $request->session()->get('flashStatus'));
        view()->share('magazines', Magazine::all());
    }

    public function create(Request $request)
    {
        view()->share('magazine', new Magazine);
    }

    public function edit(Request $request, $id)
    {
        view()->share('magazine', Magazine::find($id));
    }

    public function store(Request $request)
    {
        $magazine = Magazine::create($request->except('_token'));

        if ($magazine) {
            $request->session()->flash('flashMessage', "編號 {$magazine->id} 新增成功。");
            $request->session()->flash('flashStatus', 'success');
        } else {
            $request->session()->flash('flashMessage', "新增失敗，請洽系統管理員協詢處理。");
            $request->session()->flash('flashStatus', 'warning');
        }

        return redirect()->action('Admin\MagazinesController@index');
    }

    public function update(Request $request, $id)
    {
        if (Magazine::find($id)->update($request->except('_token'))) {
            $request->session()->flash('flashMessage', "編號 {$id} 修改成功。");
            $request->session()->flash('flashStatus', 'success');
        } else {
            $request->session()->flash('flashMessage', '改失敗，請洽系統管理員協詢處理。');
            $request->session()->flash('flashStatus', 'warning');
        }

        return redirect()->action('Admin\MagazinesController@index');
    }

    public function destroy(Request $request, $id)
    {
        if (Magazine::destroy($id)) {
            $request->session()->flash('flashMessage', "編號 {$id} 刪除成功。");
            $request->session()->flash('flashStatus', 'success');
        } else {
            $request->session()->flash('flashMessage', '刪除失敗，請洽系統管理員協詢處理。');
            $request->session()->flash('flashStatus', 'warning');
        }

        return redirect()->action('Admin\MagazinesController@index');
    }
}
