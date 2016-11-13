<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Magazine;
use App\Video;
use App\News;
use App\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/news', function (Request $request) {

    $news = null;

    if (!empty($request->order[0]['dir'])) {
        $news = News::orderBy('id', strtoupper($request->order[0]['dir']));

    } else if (!empty($request->order[3]['dir'])) {
        $news = News::orderBy('publishedAt', strtoupper($request->order[3]['dir']));
    }

    if (!empty($request->search['value'])) {
        $news = $news->where('title', 'LIKE', "%{$request->search['value']}%")
                   ->orWhere('content', 'LIKE', "%{$request->search['value']}%");
    }

    $news = $news
        ->offset($request->start)
        ->limit($request->length)
        ->get();

    return [
        'recordsTotal' => News::count(),
        'recordsFiltered' => News::count(),
        'data' => $news->map(function($eachNews) {
            return [
                $eachNews->id,
                $eachNews->title,
                mb_strimwidth(strip_tags($eachNews->content), 0, 60, "..."),
                $eachNews->publishedAt->format('Y-m-d'),
                ['target' => "/admin/news/{$eachNews->id}"]
            ];
        })
    ];
});

Route::get('/magazines', function (Request $request) {

    $magazines = null;

    if (!empty($request->order[0]['dir'])) {
        $magazines = Magazine::orderBy('id', strtoupper($request->order[0]['dir']));

    } else if (!empty($request->order[3]['dir'])) {
        $magazines = Magazine::orderBy('year', strtoupper($request->order[0]['dir']));

    } else if (!empty($request->order[4]['dir'])) {
        $magazines = Magazine::orderBy('period', strtoupper($request->order[0]['dir']));
    }

    if (!empty($request->search['value'])) {
        $magazines = $magazines->where('title', 'LIKE', "%{$request->search['value']}%");
    }

    $magazines = $magazines
        ->offset($request->start)
        ->limit($request->length)
        ->get();

    return [
        'recordsTotal' => Magazine::count(),
        'recordsFiltered' => Magazine::count(),
        'data' => $magazines->map(function($magazine) {
            return [
                $magazine->id,
                "<img src=\"{$magazine->image->url('thumb')}\" style=\"width: 200px;\" />",
                $magazine->title,
                $magazine->year,
                $magazine->period,
                "<a href=\"{$magazine->attachUrl}\" class=\"btn btn-link " . ($magazine->attachUrl == '' ? 'disabled' : '') . "\">點擊下載</a>",
                ['target' => "/admin/magazines/{$magazine->id}"]
            ];
        })
    ];
});

Route::get('/videos', function (Request $request) {
    $videos = Video::orderBy('id', strtoupper($request->order[0]['dir']));

    if (!empty($request->search['value'])) {
        $videos = $videos->where('title', 'LIKE', "%{$request->search['value']}%");
    }

    $videos = $videos
        ->offset($request->start)
        ->limit($request->length)
        ->get();

    return [
        'recordsTotal' => Video::count(),
        'recordsFiltered' => Video::count(),
        'data' => $videos->map(function($video) {
            return [
                $video->id, 
                "<a target=\"_blank\" href=\"https://www.youtube.com/watch?v={$video->youtubeId}\"><div>{$video->youtubeId} - {$video->title}</div><img src=\"{$video->thumbnailUrl}\" style=\"width: 200px;\" /></a>", 
                mb_strimwidth($video->description, 0, 60, "..."),
                ['target' => "/admin/videos/{$video->id}"]
            ];
        })
    ];
});

Route::get('/users', function (Request $request) {
    $users = User::orderBy('id', strtoupper($request->order[0]['dir']));

    $users = $users
        ->offset($request->start)
        ->limit($request->length)
        ->get();

    return [
        'recordsTotal' => User::count(),
        'recordsFiltered' => User::count(),
        'data' => $users->map(function($user) {
            return [
                $user->id,
                $user->name,
                "<a href=\"mailto:{$user->email}\">{$user->email}</a>",
                $user->active ? '已啟用' : '尚待啟用',
                ['target' => "/admin/users/{$user->id}"]
            ];
        })
    ];
});
