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
   
    
    // Validation de base
    $validator = validator($request->all(), [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
        'role' => ['required', 'in:patient,medecin,secretaire,admin'],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);
    
    if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
    }

    // Validation pour le rôle PATIENT
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

    // Validation pour le rôle MÉDECIN
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

    // Création de l'utilisateur
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
    ]);

    // Création du dossier PATIENT
    if ($request->role == 'patient') {
        Patient::create([
            'user_id' => $user->id,
            'date_naissance' => $request->date_naissance,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse,
        ]);
    }

    // Création du dossier MÉDECIN
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