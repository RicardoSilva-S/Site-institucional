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

    public function institucional(): View
    {
        return view('site.institucional');
    }

    public function atuacao(): View
    {
        return view('site.atuacao');
    }

    public function contato(): View
    {
        return view('site.contato');
    }

    public function transparencia(): View
    {
        return view('site.transparencia');
    }
    public function privacidade(): View
    {
        return view('site.privacidade');
    }
}
