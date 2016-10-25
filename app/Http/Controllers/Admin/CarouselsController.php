<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;

class CarouselsController extends Controller
{

    public function index(Request $request)
    {
        view()->share('flashMessage', $request->session()->get('flashMessage'));
        view()->share('flashStatus', $request->session()->get('flashStatus'));
        view()->share('carousels', Carousel::orderBy('order')->get());
    }

    public function destroy(Request $request, $id)
    {
        if (Carousel::destroy($id)) {
            $request->session()->flash('flashMessage', "編號 {$id} 刪除成功。");
            $request->session()->flash('flashStatus', 'success');
        } else {
            $request->session()->flash('flashMessage', '刪除失敗，請洽系統管理員協詢處理。');
            $request->session()->flash('flashStatus', 'warning');
        }

        return redirect()->action('Admin\CarouselsController@index');
    }
}
