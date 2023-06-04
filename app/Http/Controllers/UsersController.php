<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class UsersController extends Controller
{
    public function show($id)
    {
        $user = User::find($id);

        if (Gate::denies('view-user', $user)) {
            abort(403, 'Nie masz dostępu do tej strony.');
        }
        return view('users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::find($id);

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        // Walidacja danych z formularza

        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->address = $request->input('address');
        $user->city = $request->input('city');
        // Pozostałe pola do zaktualizowania

        $user->save();

        return redirect()->route('users.show', $user->id)->with('success', 'Dane użytkownika zostały zaktualizowane.');
    }
}
