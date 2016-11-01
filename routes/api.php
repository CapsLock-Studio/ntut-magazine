<?php

use Illuminate\Http\Request;

use App\Magazine;
use App\Video;

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

Route::get('/magazines', function (Request $request) {

    $magazines = Magazine::orderBy('id', strtoupper($request->order[0]['dir']));

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
            return [$magazine->id, "<img src=\"{$magazine->image->url('thumb')}\" style=\"width: 200px;\" />", $magazine->title, ['target' => "/admin/magazines/{$magazine->id}"]];
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
        'recordsTotal' => Magazine::count(),
        'recordsFiltered' => Magazine::count(),
        'data' => $videos->map(function($video) {
            return [$video->id, "<a target=\"_blank\" href=\"https://www.youtube.com/watch?v={$video->youtubeId}\"><div>{$video->title} - {$video->youtubeId}</div><img src=\"{$video->thumbnailUrl}\" style=\"width: 200px;\" /></a>", ['target' => "/admin/videos/{$video->id}"]];
        })
    ];
});
