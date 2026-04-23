<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Patient;
use App\Models\Medecin;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $validator = validator(
            $request->all(),
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'role' => ['required', 'in:patient,medecin,secretaire,admin'],
                'password' => ['required', 'confirmed', 'min:8', Rules\Password::defaults()],
            ],
            [
                'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
                'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
                'email.unique' => 'Cet email est déjà utilisé.',
                'role.required' => 'Veuillez choisir un rôle.',
            ],
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if ($request->role == 'patient') {
            $validatorPatient = validator($request->all(), [
                'telephone' => ['required', 'string'],
                'date_naissance' => ['required', 'date'],
                'adresse' => ['required', 'string'],
            ]);

            if ($validatorPatient->fails()) {
                return back()->withErrors($validatorPatient)->withInput();
            }
        }

        if ($request->role == 'medecin') {
            $validatorMedecin = validator($request->all(), [
                'specialite' => ['required', 'string'],
                'diplome' => ['required', 'string'],
                'annee_experience' => ['required', 'integer', 'min:0'],
            ]);

            if ($validatorMedecin->fails()) {
                return back()->withErrors($validatorMedecin)->withInput();
            }
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        if ($request->role == 'patient') {
            Patient::create([
                'user_id' => $user->id,
                'date_naissance' => $request->date_naissance,
                'telephone' => $request->telephone,
                'adresse' => $request->adresse,
            ]);
        }

        if ($request->role == 'medecin') {
            Medecin::create([
                'user_id' => $user->id,
                'specialite' => $request->specialite,
                'diplome' => $request->diplome,
                'annee_experience' => $request->annee_experience,
            ]);
        }

        event(new Registered($user));
        Auth::login($user);

        return redirect(route('dashboard', absolute: false))->with('success', 'Compte créé avec succès !');
    }
}
