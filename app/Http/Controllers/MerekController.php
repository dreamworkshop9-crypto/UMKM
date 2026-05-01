<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MerekController extends Controller
{
        public function index()
    {
        return view('layouts.merek');
    }
}
