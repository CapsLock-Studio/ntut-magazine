<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Magazine;

class MagazinesController extends Controller
{
    function index(Request $request)
    {
        $queryYear = $request->get('year');

        $startYear = date('Y');
        $earlesitYear = Magazine::orderBy('year')->first()->year;

        $years = range($startYear, $startYear - 3);

        $magazines = null;

        if ($queryYear) {
            $magazines = Magazine::where('year', '=', $queryYear);
        } else {
            $magazines = Magazine::where('year', '>=', $earlesitYear);
        }

        view()->share('magazines', $magazines
                                           ->orderBy('year', 'desc')
                                           ->orderBy('period', 'desc')
                                           ->get());
        view()->share('years', $years);
        view()->share('earlesitYear', $earlesitYear);
        view()->share('queryYear', $queryYear);
        view()->share('filterYear', $request->filterYear);
    }
}
