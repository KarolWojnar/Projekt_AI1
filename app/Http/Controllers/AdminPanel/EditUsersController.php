<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EditUsersController extends Controller
{
    public function index()
    {
        return view('adminPanel.editUsers');
    }
}
