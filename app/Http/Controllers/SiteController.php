<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class SiteController extends Controller
{
    public function home(): View
    {
        return view('site.home');
    }

    public function marcoLegal(): View
    {
        return view('site.marco-legal');
    }

    public function atuacao(): View
    {
        return view('site.atuacao');
    }
}
