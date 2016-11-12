<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use App\Http\Requests;

use App\Magazine;

class MagazinesController extends Controller
{
    public function index(Request $request)
    {
        view()->share('flashMessage', $request->session()->get('flashMessage'));
        view()->share('flashStatus', $request->session()->get('flashStatus'));
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
        $magazine = new Magazine($request->except('_token'));

        if ($magazine->save()) {
            $request->session()->flash('flashMessage', "編號 {$magazine->id} 新增成功。");
            $request->session()->flash('flashStatus', 'success');
        } else {
            $request->session()->flash('flashMessage', "新增失敗，請洽系統管理員協詢處理。");
            $request->session()->flash('flashStatus', 'warning');
        }

        try {
            $uploadFile = $request->file('attach');
            $magazine->attach = $uploadFile->store('public/attaches');
            $magazine->save();

            if (!empty($request->get('isSetPdfFirstPageToCover')) && $uploadFile->getMimeType() == 'application/pdf') {
                $attachPath = base_path("storage/app/{$magazine->attach}");

                $pdfFirstPageImagePath = base_path("storage/app/{$magazine->attach}.png");

                $pdf = new \Spatie\PdfToImage\Pdf($attachPath);
                $pdf->setPage(1)
                    ->saveImage($pdfFirstPageImagePath);

                $magazine->image = $pdfFirstPageImagePath;
                $magazine->save();
            }
        } catch (Exception $exception) {
            $request->session()->flash('flashMessage', "新增失敗，請洽系統管理員協詢處理。");
            $request->session()->flash('flashStatus', 'warning');
        }

        return redirect()->action('Admin\MagazinesController@index');
    }

    public function update(Request $request, $id)
    {
        $magazine = Magazine::find($id);

        if ($magazine->update($request->except('_token'))) {
            $request->session()->flash('flashMessage', "編號 {$id} 修改成功。");
            $request->session()->flash('flashStatus', 'success');
        } else {
            $request->session()->flash('flashMessage', '修改失敗，請洽系統管理員協詢處理。');
            $request->session()->flash('flashStatus', 'warning');
        }

        $uploadFile = $request->file('attach');
        if (!empty($uploadFile)) {
            try {
                Storage::delete($magazine->attach);

                $magazine->attach = $uploadFile->store('public/attaches');
                $magazine->save();

                if (!empty($request->get('isSetPdfFirstPageToCover')) && $uploadFile->getMimeType() == 'application/pdf') {
                    $attachPath = base_path("storage/app/{$magazine->attach}");

                    $pdfFirstPageImagePath = base_path("storage/app/{$magazine->attach}.png");

                    $pdf = new \Spatie\PdfToImage\Pdf($attachPath);
                    $pdf->setPage(1)
                        ->saveImage($pdfFirstPageImagePath);

                    $magazine->image = $pdfFirstPageImagePath;
                    $magazine->save();
                }
            } catch (Exception $exception) {
                $request->session()->flash('flashMessage', '改失敗，請洽系統管理員協詢處理。');
                $request->session()->flash('flashStatus', 'warning');
            }
        }

        return redirect()->action('Admin\MagazinesController@index');
    }

    public function destroy(Request $request, $id)
    {
        $magazine = Magazine::find($id);

        Storage::delete($magazine->attach);

        if ($magazine->delete()) {
            $request->session()->flash('flashMessage', "編號 {$id} 刪除成功。");
            $request->session()->flash('flashStatus', 'success');
        } else {
            $request->session()->flash('flashMessage', '刪除失敗，請洽系統管理員協詢處理。');
            $request->session()->flash('flashStatus', 'warning');
        }

        return redirect()->action('Admin\MagazinesController@index');
    }
}
