<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function tentang()
    {
        return view('pages.about');
    }

    public function caraMelapor()
    {
        return view('pages.cara-melapor');
    }

    public function syaratKetentuan()
    {
        return view('pages.terms');
    }

    public function kebijakanPrivasi()
    {
        return view('pages.privacy');
    }

    public function faq()
    {
        return view('pages.faq');
    }
}
