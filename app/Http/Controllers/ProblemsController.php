<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Support;
use Illuminate\Support\Facades\Validator;

class ProblemsController extends Controller
{
    public function show() {
        $problems = Support::all();
        return view('adminPanel.support', compact('problems'));
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255'],
            'typeOf' => ['required', 'string', 'max:255'],
            'problem' => ['required', 'string', 'max:255'],
        ]);
    }

    protected function create(Request $request)
{
    $validatedData = $request->validate([
        'email' => ['required', 'string', 'email', 'max:255'],
        'typeOf' => ['required', 'string', 'max:255'],
        'problem' => ['required', 'string', 'max:255'],
    ]);

    // Dodaj walidację adresu e-mail
    $emailValidator = Validator::make($request->only('email'), [
        'email' => ['email'],
    ]);

    // Sprawdź poprawność adresu e-mail
    if ($emailValidator->fails()) {
        return redirect()->back()->withErrors($emailValidator)->withInput();
    }

    Support::create([
        'email' => $validatedData['email'],
        'typeOf' => $validatedData['typeOf'],
        'problem' => $validatedData['problem'],
    ]);

    return redirect()->back()->with('success', 'Problem został wysłany.');
}


    public function delete($id)
    {
        $problem = Support::find($id);

        if (!$problem) {

            return redirect()->back()->with('error', 'Problem nie został znaleziony.');
        }

        $problem->delete();

        return redirect()->back()->with('success', 'Problem rozwiązany.');
    }


    public function updateStatus(Request $request, $id)
    {
        $problem = Support::find($id);


        // Walidacja danych z formularza

        $problem->status = $request->input('status');

        $problem->save();

        return redirect()->back()->with('success', 'Status zaaktualizowany pomyślnie.');
    }
}
