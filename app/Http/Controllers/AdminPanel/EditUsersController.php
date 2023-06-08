<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class EditUsersController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('adminPanel.editUsers', compact('users'));
    }
}
