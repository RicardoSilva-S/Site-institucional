<?php

namespace App\Http\Controllers;

class SiteController extends Controller
{
    public function home()
    {
        return view('site.home');
    }

    public function marcoLegal()
    {
        return view('site.marco-legal');
    }

    public function contato()
    {
        return view('site.contato');
    }

    public function transparencia()
    {
        return view('site.transparencia');
    }
}
