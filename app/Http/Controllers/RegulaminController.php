<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegulaminController extends Controller
{
    public function index()
    {
        return view('regulamin');
    }
}
