<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Loan;
use Illuminate\Http\Request;

class EditUsersController extends Controller
{
    public function index()
    {
        $users = User::all();
        $loans = Loan::where('status', 'Wysłane')->get();
        return view('adminPanel.editUsers', compact('users', 'loans'));
    }
}
