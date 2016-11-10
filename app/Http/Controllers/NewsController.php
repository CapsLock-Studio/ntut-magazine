<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\News;

class NewsController extends Controller
{
    function index(Request $request)
    {
        view()->share('news', News::orderBy('publishedAt')->paginate(25));
    }

    function show(Request $request, $id)
    {
        view()->share('news', News::find($id));
    }
}
