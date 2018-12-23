<?php

namespace App\Http\Controllers;

use Illuminate\Auth\GuardHelpers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Authenticatable;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function showForm()
    {
      return view('registration.login');
    }

    public function selectForm(Request $request)
    {
        if ($request->has('loginClient')) {
            return $this->applyClientForm();
        }
        elseif ($request->has('loginSeller')){
            return $this->applySellerForm();
        }
    }

    public function applyClientForm()
    {
      request()->validate([
        'mailClient' => ['required','email'],
        'passwordClient' => ['required'],
        ]);

       if(Auth::guard('client')->attempt(['mailClient' => request('mailClient'), 'password' => request('passwordClient') ])){
           return redirect('/client/profil');
       }
       return back()->withInput()->withErrors([
           'mailClient' => "Email ou mot de passe incorrect",
       ]);
    }

    public function applySellerForm()
    {
        request()->validate([
            'mailSeller' => ['required','email'],
            'passwordSeller' => ['required'],
        ]);

        $login = Auth::guard('seller')->attempt([
            'mailVendeur' => request('mailSeller'),
            'password' => request('passwordSeller') //// laravel va chercher le mdp en utilisant password et non mdpSeller
        ]);

        if($login){
            return redirect('/client/profil');
        }
        return back()->withErrors([
            'mailSeller' => "Email ou mot de passe incorrect",
        ]);
    }
}
