<?php

namespace App\Http\Controllers\Cabinet\Adverts;

use App\Http\Controllers\Controller;

class AdvertController extends Controller
{
    public function __construct()
    {
        $this->middleware('filledProfile');
    }

    public function index()
    {
        return view('cabinet.adverts.index');
    }
}