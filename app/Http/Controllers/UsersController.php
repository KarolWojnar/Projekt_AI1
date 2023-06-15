<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Loan;
use App\Models\Movie;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;

class UsersController extends Controller
{
    public function show($id)
    {
        $user = User::find($id);
        $loansAll = Loan::all();
        $today = Carbon::today()->startOfDay();
        foreach ($loansAll as $loan)
        {
            $expectDate = Carbon::parse($loan->start_loan);
            if ($today->greaterThan($expectDate) && $loan->status == 'Nieopłacone') {
                foreach ($loan->movies as $movie) {
                    $movie->available = 'dostępny';
                    $movie->save();
                }
                $loan->movies()->detach();
                $loan->delete();
            }
        }
        $loans = Loan::where('user_id', $id)->get();

        if (Gate::denies('view-user', $user)) {
            abort(403, 'Nie masz dostępu do tej strony.');
        }
        return view('users.show', compact('user', 'loans'));
    }

    public function edit($id)
    {
        $user = User::find($id);

        if (Gate::denies('view-user', $user)) {
            abort(403, 'Nie masz dostępu do tej strony.');
        }

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

        return redirect()->back()->with('success', 'Dane użytkownika zostały zaktualizowane.');
    }
    public function update2(Request $request, $id)
    {
        $user = User::find($id);

        // Walidacja danych z formularza

        $user->address = $request->input('address');
        $user->city = $request->input('city');

        $user->save();

        return redirect()->back()->with('success', 'Dane użytkownika zostały zaktualizowane.');
    }

    public function delete($id)
{
    $user = User::find($id);

    if (!$user) {
        return redirect()->back()->with('error', 'Użytkownik nie został znaleziony.');
    }

    $user->delete();

    return redirect()->back()->with('success', 'Użytkownik został pomyślnie usunięty.');
}
}
