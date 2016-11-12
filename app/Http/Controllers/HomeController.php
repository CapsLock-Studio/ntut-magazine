<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Carousel;
use App\Magazine;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $startYear = date('Y');
        $years = range($startYear, $startYear - 3);

        view()->share('carousels', Carousel::orderBy('order')->get());
        view()->share('magazines', Magazine::where('year', '>=', '2013')
                                           ->orderBy('year', 'desc')
                                           ->orderBy('period', 'desc')
                                           ->get());
        view()->share('years', $years);
    }
}
