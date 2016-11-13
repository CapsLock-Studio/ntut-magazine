<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth;

use App\Http\Requests;

use App\User;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        view()->share('flashMessage', $request->session()->get('flashMessage'));
        view()->share('flashStatus', $request->session()->get('flashStatus'));
    }

    public function create(Request $request)
    {
        view()->share('user', new User);
    }

    public function edit(Request $request, $id)
    {
        view()->share('user', User::find($id));
    }

    public function store(Request $request)
    {
        $user = new User($request->except('_token'));

        $request->defaultPassword = $request->defaultPassword ? $request->defaultPassword : str_random(10);

        $user->password = Hash::make($request->defaultPassword);

        if ($user->save()) {
            $request->session()->flash('flashMessage', "編號 {$user->id} 新增成功。預設密碼為 {$request->defaultPassword} ，請轉達給新用戶！");
            $request->session()->flash('flashStatus', 'success');
        } else {
            $request->session()->flash('flashMessage', "新增失敗，請洽系統管理員協詢處理。");
            $request->session()->flash('flashStatus', 'warning');
        }

        return redirect()->action('Admin\UsersController@index');
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        $request->defaultPassword = $request->defaultPassword ? $request->defaultPassword : str_random(10);

        $user->password = Hash::make($request->defaultPassword);

        if ($user->save()) {
            $request->session()->flash('flashMessage', "編號 {$user->id} 新增成功。預設密碼為 {$request->defaultPassword} ，請轉達給新用戶！");
            $request->session()->flash('flashStatus', 'success');
        } else {
            $request->session()->flash('flashMessage', '修改失敗，請洽系統管理員協詢處理。');
            $request->session()->flash('flashStatus', 'warning');
        }

        return redirect()->action('Admin\UsersController@index');
    }

    public function destroy(Request $request, $id)
    {
        $user = User::find($id);

        Storage::delete($user->attach);

        if ($user->delete()) {
            $request->session()->flash('flashMessage', "編號 {$id} 刪除成功。");
            $request->session()->flash('flashStatus', 'success');
        } else {
            $request->session()->flash('flashMessage', '刪除失敗，請洽系統管理員協詢處理。');
            $request->session()->flash('flashStatus', 'warning');
        }

        return redirect()->action('Admin\UsersController@index');
    }

    public function setting(Request $request)
    {
        view()->share('title', 'user.setting');
        view()->share('controller', '');

        view()->share('flashMessage', $request->session()->get('flashMessage'));
        view()->share('flashStatus', $request->session()->get('flashStatus'));

        return view('admin.users.setting');
    }

    public function updateSetting(Request $request)
    {
        $user = Auth::user();
        if (!Hash::check($request->oldPassword, $user->password)) {
            $request->session()->flash('flashMessage', '舊密碼確認錯誤');
            $request->session()->flash('flashStatus', 'warning');

            return redirect()->action('Admin\UsersController@setting');

        } else if ($request->newPassword != $request->confirmPassword) {
            $request->session()->flash('flashMessage', '新密碼確認失敗');
            $request->session()->flash('flashStatus', 'warning');

            return redirect()->action('Admin\UsersController@setting');

        } else {
            $user->password = Hash::make($request->newPassword);
            $user->active = true;
            $user->save();

            $request->session()->flash('flashMessage', '密碼更新成功');
            $request->session()->flash('flashStatus', 'success');

            return redirect('/admin');
        }
    }
}
