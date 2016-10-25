<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Carousel;

class CarouselsController extends Controller
{

    public function index(Request $request)
    {
        view()->share('flashMessage', $request->session()->get('flashMessage'));
        view()->share('flashStatus', $request->session()->get('flashStatus'));
        view()->share('carousels', Carousel::orderBy('order')->get());
    }

    public function edit(Request $request, $id)
    {
        view()->share('carousel', Carousel::find($id));
    }

    public function create(Request $request)
    {
        view()->share('carousel', new Carousel);
    }

    public function store(Request $request)
    {
        try {
            $lastCarousel = Carousel::orderBy('order', 'DESC')->get()->first();
            $lastOrder = $lastCarousel ? $lastCarousel->order : 0;

            $carousel = Carousel::create(
                array_merge(
                    $request->except('_token'), 
                    ['order' => $lastOrder]
                )
            );

            $request->session()->flash('flashMessage', "編號 {$carousel->id} 新增成功。");
            $request->session()->flash('flashStatus', 'success');
        } catch (ErrorException $exception) {
            $request->session()->flash('flashMessage', "新增失敗，請洽系統管理員協詢處理。");
            $request->session()->flash('flashStatus', 'warning');
        }

        return redirect()->action('Admin\CarouselsController@index');
    }

    public function update(Request $request, $id)
    {
        if (Carousel::find($id)->update($request->except('_token'))) {
            $request->session()->flash('flashMessage', "編號 {$id} 修改成功。");
            $request->session()->flash('flashStatus', 'success');
        } else {
            $request->session()->flash('flashMessage', '改失敗，請洽系統管理員協詢處理。');
            $request->session()->flash('flashStatus', 'warning');
        }

        return redirect()->action('Admin\CarouselsController@index');
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

    public function order(Request $request)
    {
        // $carousels = Carousel::find(array_map(function($param) { return $param['id']; }, $request->carousels));
        $carousels = $request->carousels;
        $results = [];

        foreach ($carousels as $carousel) {
            array_push($results, Carousel::find($carousel['id'])->update(['order' => $carousel['order']]));
        }

        if (array_reduce($results, function($previous, $current) { return $previous & $current; }, true)) {
            $request->session()->flash('flashMessage', "排序儲存成功。");
            $request->session()->flash('flashStatus', 'success');
        } else {
            $request->session()->flash('flashMessage', '儲存失敗，請洽系統管理員協詢處理。');
            $request->session()->flash('flashStatus', 'warning');
        }

        return redirect()->action('Admin\CarouselsController@index');
    }
}
