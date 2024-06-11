<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Crawler extends Controller
{
    public function crawlerView()
    {
        return view('crawler.index');   
    }
}
