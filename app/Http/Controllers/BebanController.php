<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BebanController extends Controller
{
    public function index()
    {
        return view('beban.index');
    }
}
